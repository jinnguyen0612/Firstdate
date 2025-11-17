<?php

namespace App\Api\V1\Http\Controllers\Notification;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Traits\AuthService;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Http\Requests\Paginate\PaginateRequest;
use App\Api\V1\Http\Resources\Notification\NotificationResource;
use App\Api\V1\Http\Resources\Notification\NotificationDetailResource;
use App\Api\V1\Repositories\Notification\NotificationRepositoryInterface;
use App\Api\V1\Support\Response;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Http\JsonResponse;

/**
 * @group Thông báo
 */

class NotificationController extends Controller
{
    use Response, AuthService;

    public function __construct(
        NotificationRepositoryInterface $repository,
        NotificationServiceInterface $service,
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Chi tiết thông báo
     *
     * Lấy chi tiết thông báo.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @pathParam id integer required
     * id thông báo. Example: 12 | cat-1
     *
     * @responseFile 200 App/Api/V1/Http/Resources/Notification/NotificationDetailResource.json
     */
    public function detail($id): JsonResponse
    {
        $note = $this->repository->find($id);
        if ($note) {
            $note->markAsRead();
        }

        if (!$note) {
            // return response()->json(['status' => 404, 'message' => 'Không tìm thấy'], 404);
            return $this->jsonResponseError('Không tìm thấy', 404);
        }

        return $this->jsonResponseSuccess(new NotificationDetailResource($note));
    }

    /**
     * Danh sách thông báo của người dùng
     *
     * Lấy danh sách thông báo của người dùng.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @responseFile 200 App/Api/V1/Http/Resources/Notification/NotificationResource.json
     */
    public function getUserNotifications(PaginateRequest $request): JsonResponse
    {
        $userId = auth()->user()->id;
        $notifications = $this->repository->getUserNotifications($userId, $request);

        return $this->jsonResponseSuccess(new NotificationResource($notifications));
    }

    /**
     * Đọc tất cả thông báo
     *
     * Dùng để đọc tất cả thông báo.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @responseFile 200 App/Api/V1/Http/Resources/BaseResource.json
     */
    public function updateAllStatusRead(): JsonResponse
    {
        $userId = auth()->user()->id;

        if (auth('user')->check()) {
            $criteria = [
                'status' => NotificationStatus::NOT_READ,
                'user_id' => $userId,
            ];
        } else {
            $criteria = [
                'status' => NotificationStatus::NOT_READ,
                'partner_id' => $userId,
            ];
        }

        $notifications = $this->repository->getBy($criteria);
        foreach ($notifications as $notification) {
            $notification->markAsRead();
        }
        return $this->jsonResponseSuccess(null);
    }

    /**
     * Xoá thông báo.
     *
     * ? Xoá thông báo
     *
     * @pathParam id integer required
     * id thông báo. Example: 1
     *
     * @responseFile 200 App/Api/V1/Http/Resources/BaseResource.json
     */
    public function delete($id)
    {
        $notification = $this->repository->find($id);

        if ($notification) {
            $result = $this->repository->delete($id);
            if ($result) {
                return $this->jsonResponseSuccess([]);
            }
        }
        return $this->jsonResponseError();
    }

    /**
     * Xoá tất cả thông báo.
     *
     * ? Xoá tất cả thông báo
     *
     * @responseFile 200 App/Api/V1/Http/Resources/BaseResource.json
     */
    public function deleteAll()
    {
        $user = $this->getCurrentUser();

        if (auth('user')->check()) {
            $notifications = $this->repository->getBy(['user_id' => $user->id]);
        } else {
            $notifications = $this->repository->getBy(['partner_id' => $user->id]);
        }

        foreach ($notifications as $notification) {
            $this->repository->delete($notification->id);
        }
        return $this->jsonResponseSuccess([]);
    }
}
