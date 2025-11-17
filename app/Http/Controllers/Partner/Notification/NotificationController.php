<?php

namespace App\Http\Controllers\Partner\Notification;

use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Slider\SliderRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Enums\Notification\NotificationStatus;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    use AuthService;
    private $login;

    protected SettingRepositoryInterface $settingRepository;
    protected SliderRepositoryInterface $sliderRepository;
    public function __construct(
        SettingRepositoryInterface $settingRepository,
        SliderRepositoryInterface $sliderRepository,
        protected NotificationRepositoryInterface $notificationRepository,
    ) {
        parent::__construct();
        $this->settingRepository = $settingRepository;
        $this->sliderRepository = $sliderRepository;
    }
    public function getView()
    {
        return [
            'index' => 'partner.notification.index',
            'show' => 'partner.notification.show',
        ];
    }
    public function index()
    {
        $settings = $this->settingRepository->getAll();

        $notifications = $this->notificationRepository->getByPartnerIdAndPaginate();

        return view($this->view['index'], [
            'settings' => $settings,
            'title' => 'Thông báo',
            'notifications' => $notifications,
        ]);
    }

    public function show($id)
    {
        $settings = $this->settingRepository->getAll();
        $notification = $this->notificationRepository->findOrFail($id);
        $notification->update(['status' => NotificationStatus::READ]);

        return view($this->view['show'], [
            'settings' => $settings,
            'title' => 'Chi tiết thông báo',
            'notification' => $notification,
        ]);
    }

    public function readAll()
    {
        $currentPartnerId = $this->getCurrentPartnerId();

        $this->notificationRepository->readAllByPartnerId($currentPartnerId);

        $notifications = $this->notificationRepository->getByPartnerIdAndPaginate($currentPartnerId);

        $html = view('partner.notification.components.mobile-notification', [
            'notifications' => $notifications
        ])->render();

        return response()->json([
            'status' => 'success',
            'message' => 'Đọc các thông báo thành công',
            'html' => $html
        ]);
    }

    public function deleteRead()
    {
        $currentPartnerId = $this->getCurrentPartnerId();

        $this->notificationRepository->deleteByPartnerId($currentPartnerId);

        $notifications = $this->notificationRepository->getByPartnerIdAndPaginate($currentPartnerId);

        $html = view('partner.notification.components.mobile-notification', [
            'notifications' => $notifications
        ])->render();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa các thông báo đã được đọc',
            'html' => $html
        ]);
    }

    public function multipleAction(Request $request)
    {
        $action = $request->action; // Lấy action từ request
        $ids = explode(',', $request->ids); // Lấy danh sách id từ request

        $this->notificationRepository->multipleAction($action, $ids);

        return response()->json([
            'status' => 'success',
            'message' => 'Thành công'
        ]);
    }

    public function loadPage(Request $request)
    {
        $currentPartnerId = $this->getCurrentPartnerId();

        $notifications = $this->notificationRepository->getByPartnerIdAndPaginate($currentPartnerId, $request->page);

        $html = view('partner.notification.components.table-notification', [
            'notifications' => $notifications
        ])->render();

        return response()->json([
            'status'       => 'success',
            'html'         => $html,
            'current_page' => $notifications->currentPage(),
            'last_page'    => $notifications->lastPage()
        ]);
    }

    public function loadMore(Request $request)
    {
        $currentPartnerId = $this->getCurrentPartnerId();

        $notifications = $this->notificationRepository->getByPartnerIdAndPaginate($currentPartnerId, $request->page);

        $html = view('partner.notification.components.mobile-notification', [
            'notifications' => $notifications
        ])->render();

        return response()->json([
            'status'       => 'success',
            'html'         => $html,
            'current_page' => $notifications->currentPage(),
            'last_page'    => $notifications->lastPage()
        ]);
    }
}
