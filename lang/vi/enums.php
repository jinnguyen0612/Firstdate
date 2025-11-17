<?php

use App\Enums\Attendance\AttendanceStatus;
use App\Enums\Booking\BookingDeposit;
use App\Enums\Booking\BookingStatus;
use App\Enums\Deal\DealStatus;
use App\Enums\DefaultActiveStatus;
use App\Enums\DefaultStatus;
use App\Enums\FeaturedStatus;
use App\Enums\Module\ModuleStatus;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Notification\NotificationType;
use App\Enums\Post\PostStatus;
use App\Enums\PostCategory\PostCategoryStatus;
use App\Enums\PriorityStatus;
use App\Enums\Slider\SliderStatus;
use App\Enums\User\Gender;
use App\Enums\WithdrawStatus;
use App\Enums\Weekday\Weekday;
use App\Enums\Notification\NotificationContactType;
use App\Enums\Notification\NotificationObject;
use App\Enums\Reschedule\RescheduleStatus;
use App\Enums\Session\SessionStatus;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Enums\User\DatingTime;
use App\Enums\User\LookingFor;
use App\Enums\User\Relationship;
use App\Models\Deal;

return [
    TransactionType::class => [
        TransactionType::Send->value => 'Gửi tiền',
        TransactionType::Receive->value => 'Nhận tiền',
        TransactionType::Deposit->value => 'Nạp tiền',
        TransactionType::Withdraw->value => 'Rút tiền',
        TransactionType::Payment->value => 'Thanh toán',
        TransactionType::Refund->value => 'Hoàn tiền',
    ],
    DatingTime::class => [
        DatingTime::From8To12->value => '08:00 - 12:00',
        DatingTime::From12To16->value => '12:00 - 16:00',
        DatingTime::From16To19->value => '16:00 - 19:00',
        DatingTime::From19To22->value => '19:00 - 22:00',
        DatingTime::After22->value => 'Sau 22:00',
    ],
    Relationship::class => [
        Relationship::SeriousDating->value => 'Hẹn hò nghiêm túc',
        Relationship::CasualDating->value => 'Hẹn hò vui vẻ',
        Relationship::LookingForFriends->value => 'Tìm bạn bè',
    ],
    TransactionStatus::class => [
        TransactionStatus::Pending->value => 'Đang xử lý',
        TransactionStatus::Success->value => 'Thành công',
        TransactionStatus::Failed->value => 'Thất bại',
    ],
    BookingDeposit::class => [
        BookingDeposit::Pending->value => 'Chờ xác nhận',
        BookingDeposit::Paid->value => 'Đã thanh toán',
        BookingDeposit::Refunded->value => 'Đã hoàn tiền',
        BookingDeposit::Forfeited->value => 'Mất cọc',
    ],
    BookingStatus::class => [
        BookingStatus::Pending->value => 'Đang chờ',
        BookingStatus::Confirmed->value => 'Xác nhận',
        BookingStatus::Processing->value => 'Đang tiến hành',
        BookingStatus::Completed->value => 'Đã hoàn thành',
        BookingStatus::Cancelled->value => 'Đã hủy',
    ],
    DealStatus::class => [
        DealStatus::Pending->value => 'Đang chờ',
        DealStatus::Confirmed->value => 'Xác nhận',
        DealStatus::Cancelled->value => 'Đã hủy',
    ],
    Weekday::class => [
        Weekday::Sunday->value => 'Chủ nhật',
        Weekday::Monday->value => 'Thứ hai',
        Weekday::Tuesday->value => 'Thứ ba',
        Weekday::Wednessday->value => 'Thứ tư',
        Weekday::Thursday->value => 'Thứ năm',
        Weekday::Frisday->value => 'Thứ sáu',
        Weekday::Saturday->value => 'Thứ bảy',
    ],
    ModuleStatus::class => [
        ModuleStatus::ChuaXong => 'Chưa xong',
        ModuleStatus::DaXong => 'Đã xong',
        ModuleStatus::DaDuyet => 'Đã duyệt'
    ],
    LookingFor::class => [
        LookingFor::Male->value => 'Nam',
        LookingFor::Female->value => 'Nữ',
        LookingFor::Both->value => 'Cả 2',
    ],
    Gender::class => [
        Gender::Male->value => 'Nam',
        Gender::Female->value => 'Nữ',
        Gender::Other->value => 'Khác',
    ],
    WithdrawStatus::class => [
        WithdrawStatus::Cancelled->value => 'Đã huỷ',
        WithdrawStatus::Confirmed->value => 'Đã xác nhận',
        WithdrawStatus::Pending->value => 'Đang chờ',
    ],
    NotificationType::class => [
        NotificationType::Sound->value => 'Âm thanh',
        NotificationType::Speed->value => 'Tốc độ',
    ],
    NotificationContactType::class => [
        NotificationContactType::SMS->value => 'SMS',
        NotificationContactType::EMAIL->value => 'Email',
        NotificationContactType::PUSHNOTIFICATION->value => 'APP',
    ],
    NotificationStatus::class => [
        NotificationStatus::READ->value => 'Đã đọc',
        NotificationStatus::NOT_READ->value => 'Chưa đọc',
    ],
    NotificationObject::class => [
        NotificationObject::All->value => 'Tất cả',
        NotificationObject::Partner->value => 'Đối tác',
        NotificationObject::User->value => 'Người dùng',
        NotificationObject::Only->value => 'Chỉ định',
    ],
    DefaultActiveStatus::class => [
        DefaultActiveStatus::Active->value => 'Có',
        DefaultActiveStatus::UnActive->value => 'Không',
    ],
    SliderStatus::class => [
        SliderStatus::Active => 'Đang hoạt động',
        SliderStatus::UnActive => 'Ngưng hoạt động',
    ],
    PostCategoryStatus::class => [
        PostCategoryStatus::Published => 'Đã xuất bản',
        PostCategoryStatus::Draft => 'Bản nháp',
    ],
    PostStatus::class => [
        PostStatus::Draft->value => 'Bản nháp',
        PostStatus::Published->value => 'Đã xuất bản',
    ],
    DefaultStatus::class => array(
        DefaultStatus::Published->value => 'Đã xuất bản',
        DefaultStatus::Draft->value => 'Bản nháp',
        DefaultStatus::Deleted->value => 'Đã xoá',
    ),
    PriorityStatus::class => [
        PriorityStatus::Priority->value => 'Ưu tiên',
        PriorityStatus::NotPriority->value => 'Không ưu tiên'
    ],
    FeaturedStatus::class => [
        FeaturedStatus::Featured->value => 'Nổi bật',
        FeaturedStatus::Featureless->value => 'Không nổi bật'
    ],
];
