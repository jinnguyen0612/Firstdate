<?php

namespace App\Api\V1\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Repositories\Teacher\TeacherRepositoryInterface;
use App\Api\V1\Http\Requests\User\PasswordResetUpdateRequest;
use App\Api\V1\Http\Requests\User\ResetPasswordRequest;
use App\Api\V1\Http\Requests\User\VerifyRequest;
use Illuminate\Support\Facades\Mail;
use App\Api\V1\Services\Auth\AuthServiceInterface;
use App\Mail\Authentication;
use Carbon\Carbon;


class ResetPasswordController extends Controller
{
    protected $userRepository;
    protected $teacherRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
        TeacherRepositoryInterface $teacherRepository,
        AuthServiceInterface $service,
    ) {
        parent::__construct();
        $this->service = $service;
        $this->userRepository = $userRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function resetPasswordUser(ResetPasswordRequest $request)
    {
        $user = $this->userRepository->findByField('email', $request->input('email'));
        $user->token_active_account = random_int(1000, 9999);
        $user->token_expiration = Carbon::now()->addMinutes(30);
        $user->save();
        Mail::to($user['email'])->send(new Authentication($user));

        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công. Mã xác nhận đã được gửi về email của bạn.')
        ]);
    }


    public function resetPasswordTeacher(ResetPasswordRequest $request)
    {
        $user = $this->repository->findByField('email', $request->input('email'));
        $user->token_active_account = random_int(1000, 9999);
        $user->token_expiration = Carbon::now()->addMinutes(30);
        $user->save();
        Mail::to($user['email'])->send(new Authentication($user));

        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công. Mã xác nhận đã được gửi về email của bạn.')
        ]);
    }

    public function verifyUser(VerifyRequest $request)
    {
        $user = $this->userRepository->findByField('email', $request->input('email'));
        if ($user && $user->token_active_account == $request->input('token_active_account') && $user->token_expiration > Carbon::now()) {
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.')
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => __('Mã xác thực chưa chính xác hoặc đã hết hạn.')
        ]);
    }

    public function verifyTeacher(VerifyRequest $request)
    {
        $user = $this->repository->findByField('email', $request->input('email'));
        if ($user && $user->token_active_account == $request->input('token_active_account') && $user->token_expiration > Carbon::now()) {
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.')
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => __('Mã xác thực chưa chính xác hoặc đã hết hạn.')
        ]);
    }

    public function updatePasswordUser(PasswordResetUpdateRequest $request)
    {
        $user = $this->userRepository->findByField('email', $request->input('email'));
        $password = bcrypt($request->input('password'));
        $user->update([
            'password' => $password,
            'token_active_account' => null,
            'token_expiration' => null,
        ]);
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.')
        ]);
    }

    public function updatePasswordTeacher(PasswordResetUpdateRequest $request)
    {
        $user = $this->repository->findByField('email', $request->input('email'));
        $password = bcrypt($request->input('password'));
        $user->update([
            'password' => $password,
            'token_active_account' => null,
            'token_expiration' => null,
        ]);
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.')
        ]);
    }
}
