<?php

namespace App\Api\V1\Http\Controllers\Teacher;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\Setup;
use App\Api\V1\Http\Requests\Teacher\GetAllTeacherRequest;
use App\Api\V1\Http\Requests\Teacher\LoginRequest;
use App\Api\V1\Http\Requests\Teacher\RefreshTokenRequest;
use App\Api\V1\Http\Requests\Teacher\ResendOTPRequest;
use App\Api\V1\Http\Requests\Teacher\UpdatePasswordRequest;
use App\Api\V1\Http\Requests\Teacher\UpdateRequest;
use App\Api\V1\Http\Resources\Teacher\AllTeacherResource;
use App\Api\V1\Http\Resources\Teacher\ShowTeacherDetailResource;
use App\Api\V1\Services\Auth\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Api\V1\Http\Resources\Teacher\TeacherResource;
use App\Api\V1\Repositories\Teacher\TeacherRepositoryInterface;
use App\Api\V1\Support\Response;
use App\Mail\Authentication;
use App\Traits\JwtService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

/**
 * @group Người dùng
 */

class TeacherController extends Controller
{
    use Setup, Response, JwtService;

    private $login;
    private $fileService;
    protected $settingRepository;
    public function __construct(
        AuthServiceInterface $service,
        FileService $fileService,
        SettingRepositoryInterface $settingRepository,
        private TeacherRepositoryInterface $teacherRepository,
    ) {
        $this->service = $service;
        $this->fileService = $fileService;
        $this->settingRepository = $settingRepository;
    }

    public function show()
    {
        $user = auth('teacher')->user();
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => new TeacherResource($user)
        ]);
    }

    protected function resolve()
    {
        return Auth::guard('teacher')->attempt($this->login);
    }

    public function login(LoginRequest $request)
    {
        return $this->loginUser($request, 'teacher');
    }

    public function refresh(RefreshTokenRequest $request): JsonResponse
    {
        return $this->refreshToken($request);
    }

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        if (isset($data['avatar'])) {
            $avatar = $data['avatar'];
            $data['avatar'] = $this->fileService->uploadAvatar('images', $avatar, $user->avatar);
        }

        $user->update($data);

        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new TeacherResource($user)
        ], 200);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $password = bcrypt($request->input('password'));
        $user = auth('teacher')->user();
        $user->update([
            'password' => $password
        ]);
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
        ], 200);
    }

    public function logout()
    {
        return $this->logoutUser('teacher');
    }

    public function resendOTP(ResendOTPRequest $request)
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

    public function getAllTeachers(GetAllTeacherRequest $request)
    {
        $data = $request->validated();
        $classrooms = $this->teacherRepository->getTeacherPaginate(...$data);
        $classrooms = new AllTeacherResource($classrooms);

        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => $classrooms
        ]);
    }

    public function getTeacher($id)
    {
        try {
            $classrooms = $this->teacherRepository->findOrFail($id);
            $classrooms = new ShowTeacherDetailResource($classrooms);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $classrooms
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'status' => 500,
                'message' => __('Đã xảy ra lỗi, vui lòng thử lại')
            ], 500);
        }
    }
}
