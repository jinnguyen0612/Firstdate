<?php

return [
    [
        'title' => 'Dashboard',
        'routeName' => 'admin.dashboard',
        'icon' => '<i class="ti ti-home"></i>',
        'roles' => [],
        'permissions' => ['createDiscountCode', 'viewDiscountCode', 'updateDiscountCode', 'deleteDiscountCode'],
        'sub' => []
    ],
    [
        'title' => 'Thông báo',
        'routeName' => null,
        'icon' => '<i class="ti ti-bell-ringing"></i>',
        'roles' => [],
        'permissions' => [
            'createNotification',
            'viewNotification',
            'updateNotification',
            'deleteNotification',
        ],
        'sub' => [
            [
                'title' => 'Thêm Thông báo',
                'routeName' => 'admin.notification.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createNotification'],
            ],
            [
                'title' => 'DS Thông báo',
                'routeName' => 'admin.notification.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewNotification'],
            ],
        ]
    ],
    [
        'title' => 'Người dùng',
        'routeName' => null,
        'icon' => '<i class="ti ti-users"></i>',
        'roles' => [],
        'permissions' => ['createUser', 'viewUser', 'updateUser', 'deleteUser'],
        'sub' => [
            [
                'title' => 'Thêm Người dùng',
                'routeName' => 'admin.user.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createUser'],
            ],
            [
                'title' => 'DS Người dùng',
                'routeName' => 'admin.user.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewUser'],
            ],
        ]
    ],
    [
        'title' => 'Đối tác',
        'routeName' => null,
        'icon' => '<i class="ti ti-transform"></i>',
        'roles' => [],
        'permissions' => ['createPartner', 'viewPartner', 'updatePartner', 'deletePartner'],
        'sub' => [
            [
                'title' => 'Thêm Đối tác',
                'routeName' => 'admin.partner.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createPartner'],
            ],
            [
                'title' => 'DS Đối tác',
                'routeName' => 'admin.partner.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewPartner'],
            ],
            [
                'title' => 'DS Loại Đối tác',
                'routeName' => 'admin.partner_category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewPartner'],
            ],
        ]
    ],
    [
        'title' => 'Câu hỏi',
        'routeName' => null,
        'icon' => '<i class="ti ti-message-2-question"></i>',
        'roles' => [],
        'permissions' => ['createQuestion', 'viewQuestion', 'updateQuestion', 'deleteQuestion'],
        'sub' => [
            [
                'title' => 'Thêm Câu hỏi',
                'routeName' => 'admin.question.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createQuestion'],
            ],
            [
                'title' => 'DS Câu hỏi',
                'routeName' => 'admin.question.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewQuestion'],
            ],
        ]
    ],
    [
        'title' => 'Gói',
        'routeName' => null,
        'icon' => '<i class="ti ti-packages"></i>',
        'roles' => [],
        'permissions' => ['createPackage', 'viewPackage', 'updatePackage', 'deletePackage'],
        'sub' => [
            [
                'title' => 'Thêm Gói',
                'routeName' => 'admin.package.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createPackage'],
            ],
            [
                'title' => 'DS Gói',
                'routeName' => 'admin.package.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewPackage'],
            ],
        ]
    ],
    [
        'title' => 'Bảng giá',
        'routeName' => null,
        'icon' => '<i class="ti ti-receipt-2"></i>',
        'roles' => [],
        'permissions' => ['createPriceList', 'viewPriceList', 'updatePriceList', 'deletePriceList'],
        'sub' => [
            [
                'title' => 'Thêm Giá',
                'routeName' => 'admin.price_list.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createPriceList'],
            ],
            [
                'title' => 'DS Giá',
                'routeName' => 'admin.price_list.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewPriceList'],
            ],
        ]
    ],
    [
        'title' => 'Giao dịch',
        'routeName' => 'admin.transaction.index',
        'icon' => '<i class="ti ti-cash"></i>',
        'roles' => [],
        'permissions' => ['viewTransaction'],
        'sub' => []
    ],
    [
        'title' => 'DS Lý do từ chối',
        'routeName' => 'admin.reject_reason.index',
        'icon' => '<i class="ti ti-list-check"></i>',
        'roles' => [],
        'permissions' => ['viewTransaction'],
        'sub' => []
    ],
    [
        'title' => 'DS Kèo',
        'routeName' => 'admin.deal.index',
        'icon' => '<i class="ti ti-timeline-event"></i>',
        'roles' => [],
        'permissions' => ['viewTransaction'],
        'sub' => []
    ],
    [
        'title' => 'DS Lịch hẹn',
        'routeName' => 'admin.booking.index',
        'icon' => '<i class="ti ti-brand-tinder"></i>',
        'roles' => [],
        'permissions' => ['viewTransaction'],
        'sub' => []
    ],
    [
        'title' => 'Câu hỏi hỗ trợ',
        'routeName' => 'admin.support_category.index',
        'icon' => '<i class="ti ti-help"></i>',
        'roles' => [],
        'permissions' => ['createPartner', 'viewPartner', 'updatePartner', 'deletePartner'],
        'sub' => []
    ],
    [
        'title' => 'QL Hiển Thị AppMobile',
        'routeName' => null,
        'icon' => '<i class="ti ti-device-mobile"></i>',
        'roles' => [],
        'permissions' => ['createAppTitle', 'viewAppTitle', 'updateAppTitle', 'deleteAppTitle'],
        'sub' => [
            [
                'title' => 'Chỉnh sửa tiêu đề',
                'routeName' => 'admin.app_title.index',
                'icon' => '<i class="ti ti-letter-case"></i>',
                'roles' => [],
                'permissions' => ['createRole'],
            ],
            [
                'title' => 'Chỉnh sửa video',
                'routeName' => 'admin.app_title_video.index',
                'icon' => '<i class="ti ti-brand-youtube"></i>',
                'roles' => [],
                'permissions' => ['viewRole'],
            ]
        ]
    ],
    [
        'title' => 'Vai trò',
        'routeName' => null,
        'icon' => '<i class="ti ti-user-check"></i>',
        'roles' => [],
        'permissions' => ['createRole', 'viewRole', 'updateRole', 'deleteRole'],
        'sub' => [
            [
                'title' => 'Thêm Vai trò',
                'routeName' => 'admin.role.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createRole'],
            ],
            [
                'title' => 'DS Vai trò',
                'routeName' => 'admin.role.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewRole'],
            ]
        ]
    ],
    [
        'title' => 'Admin',
        'routeName' => null,
        'icon' => '<i class="ti ti-user-shield"></i>',
        'roles' => [],
        'permissions' => ['createAdmin', 'viewAdmin', 'updateAdmin', 'deleteAdmin'],
        'sub' => [
            [
                'title' => 'Thêm Admin',
                'routeName' => 'admin.admin.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createAdmin'],
            ],
            [
                'title' => 'DS Admin',
                'routeName' => 'admin.admin.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewAdmin'],
            ],
        ]
    ],
    [
        'title' => 'Cài đặt',
        'routeName' => null,
        'icon' => '<i class="ti ti-settings"></i>',
        'roles' => [],
        'permissions' => ['settingGeneral'],
        'sub' => [
            [
                'title' => 'Theme',
                'routeName' => 'admin.setting.theme',
                'icon' => '<i class="ti ti-tool"></i>',
                'roles' => [],
                'permissions' => ['settingGeneral'],
            ],
            [
                'title' => 'Chung',
                'routeName' => 'admin.setting.general',
                'icon' => '<i class="ti ti-tool"></i>',
                'roles' => [],
                'permissions' => ['settingGeneral'],
            ],
            [
                'title' => 'Thông tin thanh toán',
                'routeName' => 'admin.setting.payment',
                'icon' => '<i class="ti ti-credit-card"></i>',
                'roles' => [],
                'permissions' => ['settingGeneral'],
            ],
        ]
    ],
];
