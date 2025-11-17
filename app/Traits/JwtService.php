<?php

namespace App\Traits;

use App\Api\V1\Http\Resources\User\UserResource;
use App\Models\Otp;
use App\Models\Partner;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

trait JwtService
{
    /**
     * Generate JWT response with token and user data
     */
    protected function respondWithToken($user, $token, $refreshToken): JsonResponse
    {
        $ttl = config('jwt.ttl');

        return response()->json([
            'user' => $user,
            'token' => [
                'access_token' => $token,
                'refresh_token' => $refreshToken,
                'expires_in' => $ttl * 60,
            ]
        ]);
    }

    private function createRefreshToken($user, $guard)
    {
        $now = time();

        $data = [
            'sub' => $user->getKey(), // claim bắt buộc
            'iat' => $now,            // thời điểm tạo
            'exp' => $now + config('jwt.refresh_ttl', 20160) * 60, // TTL mặc định phút → giây
            'nbf' => $now,
            'jti' => uniqid(),
            'user_id' => $user->id,
            'guard' => $guard,
            'random' => rand() . $now,
            'is_refresh_token' => true,
        ];

        return JWTAuth::getJWTProvider()->encode($data);
    }


    /**
     * Login after registrer
     */
    public function loginRegister(Request $request, string $guard): JsonResponse
    {
        $data = $request->validated();

        if ($guard === 'user') {
            $user = User::where('email', $data['email'])->first();

            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'message' => __('Email không tồn tại.')
                ], 404);
            }

            // Đăng nhập bằng OTP (không cần password)
            $token = Auth::guard($guard)->login($user);
            $refreshToken = $this->createRefreshToken($user, $guard);

            return $this->respondWithToken(new UserResource($user), $token, $refreshToken);
        }

        // Các guard khác login bằng password
        if ($token = Auth::guard($guard)->attempt($data)) {
            $user = Auth::guard($guard)->user();
            $refreshToken = $this->createRefreshToken($user, $guard);

            return $this->respondWithToken(new UserResource($user), $token, $refreshToken);
        }

        return response()->json([
            'status' => 401,
            'message' => __('Thông tin đăng nhập chưa chính xác.')
        ], 401);
    }

    /**
     * Login user based on guard type
     */
    public function loginUser(Request $request, string $guard): JsonResponse
    {
        $data = $request->validated();

        // Guard user: login bằng OTP / PIN
        if ($guard === 'user') {
            $username = $data['username'];
            $otp      = $data['otp'];

            // true = email, false = phone
            $isEmail  = filter_var($username, FILTER_VALIDATE_EMAIL) !== false;

            // Tìm user theo email hoặc phone
            $user = User::where($isEmail ? 'email' : 'phone', $username)->first();

            if (!$user) {
                return response()->json([
                    'status'  => 404,
                    'message' => __('Không tìm thấy tài khoản.')
                ], 404);
            }

            // Email + OTP table
            if ($isEmail) {
                if (!$this->validateOtp($user, $otp)) {
                    return response()->json([
                        'status'  => 401,
                        'message' => __('Mã OTP không hợp lệ hoặc đã hết hạn.')
                    ], 401);
                }
            } else {
                // Phone + PIN trong bảng users
                if ($user->pin !== $otp) {
                    return response()->json([
                        'status'  => 401,
                        'message' => __('Mã đăng nhập không hợp lệ.')
                    ], 401);
                }
            }

            // Đăng nhập không cần password
            $token         = Auth::guard($guard)->login($user);
            $refreshToken  = $this->createRefreshToken($user, $guard);

            // Chỉ clear OTP khi login bằng email
            if ($isEmail && $user->email) {
                Otp::where('email', $user->email)
                    ->update([
                        'token_account'    => null,
                        'token_expiration' => null,
                    ]);
            }

            return $this->respondWithToken(new UserResource($user), $token, $refreshToken);
        }

        // Các guard khác: login bằng password
        if ($token = Auth::guard($guard)->attempt($data)) {
            $user         = Auth::guard($guard)->user();
            $refreshToken = $this->createRefreshToken($user, $guard);

            return $this->respondWithToken(new UserResource($user), $token, $refreshToken);
        }

        return response()->json([
            'status'  => 401,
            'message' => __('Thông tin đăng nhập chưa chính xác.')
        ], 401);
    }

    protected function validateOtp($user, string $otp): bool
    {
        return Otp::where('email', $user->email)
            ->where('token_account', $otp)
            ->where('token_expiration', '>=', now())
            ->exists();
    }

    /**
     * Logout user based on guard
     */
    public function logoutUser(string $guard): JsonResponse
    {
        Auth::guard($guard)->logout();

        return response()->json(['status' => 200, 'message' => 'Đăng xuất thành công.']);
    }

    /**
     * Refresh token with guard awareness
     */
    public function refreshToken(Request $request): JsonResponse
    {
        $data = $request->validated();
        $refreshToken = $data['refresh_token'];

        try {
            $decoded = JWTAuth::setToken($refreshToken)->getPayload();

            if (!$decoded->get('is_refresh_token', false)) {
                return response()->json(['message' => 'Invalid token type.'], 401);
            }

            $guard = $decoded->get('guard');
            $userId = $decoded->get('user_id');

            // Xác định model dựa trên guard
            $model = match ($guard) {
                'user' => User::class,
                'partner' => Partner::class,
                'teacher' => \App\Models\Teacher::class,
            };

            $user = $model::find($userId);

            if (!$user) {
                return response()->json(['message' => 'User not found.'], 404);
            }

            // Tạo token mới với guard tương ứng
            $newToken = Auth::guard($guard)->login($user);
            $newRefreshToken = $this->createRefreshToken($user, $guard);

            return $this->respondWithToken($newToken, $newRefreshToken);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Invalid token.',
                'error' => $e->getMessage()
            ], 401);
        }
    }
}
