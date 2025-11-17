@extends('admin.layouts.master')
<style>
    .stats-card {
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notification-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #fff;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .notification-item.notification-unread {
        border-left: 5px solid #ff9800;
        /* Màu cam */
    }

    .notification-item.notification-read {
        border-left: 5px solid #4caf50;
        /* Màu xanh */
    }

    .notification-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .notification-title {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .notification-message {
        font-size: 14px;
        color: #666;
    }

    .notification-status {
        font-size: 12px;
        font-weight: bold;
    }

    .notification-status.status-unread {
        color: #ff9800;
        /* Màu cam cho trạng thái chưa đọc */
    }

    .notification-status.status-read {
        color: #4caf50;
        /* Màu xanh cho trạng thái đã đọc */
    }

    .notification-time {
        font-size: 12px;
        color: #aaa;
    }

    .pagination {
        display: flex;
        margin-bottom: 1em;
        justify-content: center;
        align-items: center;
    }

    .pagination-btn {
        border: 1px solid #ccc;
        border-radius: 50% 50%;
        padding: 5px 12px;
        margin: 0 5px;
        background-color: #fff;
        color: #000;
        cursor: pointer;
    }

    .pagination-btn:hover {
        background-color: #1c5639;
        color: #fff;
    }

    .pagination-btn.active {
        background-color: #1c5639;
        color: #fff;
    }

    .pagination-btn.prev,
    .pagination-btn.next {
        cursor: pointer;
        padding: 5px 8px
    }

    .pagination-btn[disabled] {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav class="fancy-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb-list">
                        <li class="breadcrumb-item active" aria-current="page">
                            <span class="breadcrumb-link">
                                <span class="breadcrumb-icon">📍</span>
                                <span class="breadcrumb-text">{{ __('Dashboard') }}</span>
                            </span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        {{-- Thống kê tổng quan --}}
        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-primary text-primary bg-opacity-10">
                                <i class="ti ti-receipt fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ $totalOrders }}</h1>
                                <p class="text-muted mb-0">Tổng đơn hàng</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 100%" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-warning text-warning bg-opacity-10">
                                <i class="ti ti-receipt-off fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ $pendingOrders }}</h1>
                                <p class="text-muted mb-0">Đơn chưa xác nhận</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning"
                                style="width: {{ ($pendingOrders / $totalOrders) * 100 }}%"
                                role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-success text-success bg-opacity-10">
                                <i class="ti ti-receipt-2 fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ $completedOrders }}</h1>
                                <p class="text-muted mb-0">Đơn hoàn thành</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success"
                                style="width: {{ ($completedOrders / $totalOrders) * 100 }}%"
                                role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-info text-info bg-opacity-10">
                                <i class="ti ti-coin fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ format_price($totalRevenue) }}</h1>
                                <p class="text-muted mb-0">Tổng doanh thu</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" style="width: 100%" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-info text-info bg-opacity-10">
                                <i class="ti ti-user-plus fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ $newCustomers }}</h1>
                                <p class="text-muted mb-0">Khách hàng mới (tháng)</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" style="width: 100%" role="progressbar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-pink text-pink bg-opacity-10">
                                <i class="ti ti-brand-producthunt fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ $totalProductsSold }}</h1>
                                <p class="text-muted mb-0">Sản phẩm đã bán</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-pink" style="width: 100%" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-danger text-danger bg-opacity-10">
                                <i class="ti ti-receipt-tax fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ number_format($cancelRate, 1) }}%</h1>
                                <p class="text-muted mb-0">Tỷ lệ đơn hủy</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: {{ $cancelRate }}%" role="progressbar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-teal text-teal bg-opacity-10">
                                <i class="ti ti-cash fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ format_price($averageOrderValue) }}</h1>
                                <p class="text-muted mb-0">Giá trị TB/đơn</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-teal" style="width: 100%" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-success bg-gradient text-info bg-opacity-10">
                                <i class="ti ti-user-up fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ $newCustomersThisYear }}</h1>
                                <p class="text-muted mb-0">Khách hàng mới (năm)</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success bg-gradient" style="width: 100%" role="progressbar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-danger text-pink bg-opacity-10">
                                <i class="ti ti-user-star fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ number_format($returningCustomerRate, 1) }}%</h1>
                                <p class="text-muted mb-0">Tỷ lệ khách hàng quay lại</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: {{ $returningCustomerRate }}%"
                                role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-info bg-gradient text-danger bg-opacity-10">
                                <i class="ti ti-package fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ number_format($averageItemsPerOrder, 1) }}</h1>
                                <p class="text-muted mb-0">Sản phẩm trung bình / đơn</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info bg-gradient" style="width: 100%" role="progressbar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stats-icon icon-pulse bg-warning bg-gradient text-info bg-opacity-10">
                                <i class="ti ti-discount fs-1 text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h1 class="mb-0">{{ format_price($totalDiscountGiven) }}</h1>
                                <p class="text-muted mb-0">Tổng giảm giá cho khách</p>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning bg-gradient" style="width: 100%" role="progressbar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Biểu đồ --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Biểu đồ doanh thu theo tháng</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tỷ lệ đơn hàng</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="orderPieChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="notifications-container me-3 ms-3 mt-3">
        @forelse($notifications as $notification)
            <div
                class="notification-item {{ $notification->status == App\Enums\Notification\NotificationStatus::NOT_READ ? 'notification-unread' : 'notification-read' }}">
                <div>
                    <div class="notification-title">{{ $notification->title }}</div>
                    <div class="notification-message">{!! $notification->message !!}</div>
                </div>
                <div class="notification-meta d-flex justify-content-between align-items-end">
                    <div>
                        <div
                            class="notification-status {{ $notification->status == App\Enums\Notification\NotificationStatus::NOT_READ ? 'status-unread' : 'status-read' }}">
                            {{ $notification->status == App\Enums\Notification\NotificationStatus::NOT_READ ? 'Chưa đọc' : 'Đã đọc' }}
                        </div>
                        <div class="notification-time">
                            {{ $notification->created_at->format('H:i d/m/Y') }}
                        </div>
                        <div>
                            <a href="{{ route('admin.notification.show', ['id' => $notification->id]) }}"
                                class="btn btn-outline-blue btn-sm">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>Không có thông báo nào.</p>
        @endforelse
    </div>

    <div class="pagination w-100 d-flex justify-content-center bottom-0 mb-0 mt-3">
        <blade
            include|(%26%2339%3Bcomponents.pagination%26%2339%3B%2C%20%5B%26%2339%3Bpaginator%26%2339%3B%20%3D%3E%20%24notifications%5D)%0D />
    </div>
</div>
@endsection

<script src="{{ asset('libs/chart/chart.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Biểu đồ đường (Line Chart) với animation nâng cao
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');

        // Tạo gradient cho background
        const gradientFill = revenueCtx.createLinearGradient(0, 0, 0, 300);
        gradientFill.addColorStop(0, 'rgba(75, 192, 192, 0.6)');
        gradientFill.addColorStop(1, 'rgba(75, 192, 192, 0.0)');

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {
                    !!json_encode($months) !!
                },
                datasets: [{
                    label: 'Doanh thu',
                    data: {
                        !!json_encode($monthlyRevenue) !!
                    },
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: gradientFill,
                    pointBackgroundColor: 'rgb(75, 192, 192)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(75, 192, 192)',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                animations: {
                    tension: {
                        duration: 1000,
                        easing: 'easeInOutCubic',
                        from: 0.6,
                        to: 0.1,
                        loop: true
                    },
                    y: {
                        duration: 2000,
                        easing: 'easeInOutQuart',
                        delay: function (ctx) {
                            return ctx.dataIndex * 100;
                        },
                        loop: false
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 16,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        },
                        displayColors: false,
                        callbacks: {
                            label: function (context) {
                                return 'Doanh thu: ' + context.parsed.y.toLocaleString() + ' đ';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                }
            }
        });

        // Biểu đồ tròn (Doughnut Chart) với animation nâng cao
        const pieCtx = document.getElementById('orderPieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hoàn thành', 'Chưa xác nhận', 'Đơn hủy'],
                datasets: [{
                    data: [{
                            {
                                % 24 completedOrders
                            }
                        },
                        {
                            {
                                % 24 pendingOrders
                            }
                        },
                        {
                            {
                                % 24 cancelledOrders
                            }
                        },
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 92, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(255, 99, 132, 0.8)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 92, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 13
                            },
                            generateLabels: function (chart) {
                                const data = chart.data;
                                const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                                return data.labels.map((label, i) => ({
                                    text: `${label} (${Math.round(data.datasets[0].data[i]/total*100)}%)`,
                                    fillStyle: data.datasets[0].backgroundColor[i],
                                    strokeStyle: data.datasets[0].borderColor[i],
                                    lineWidth: 2,
                                    hidden: isNaN(data.datasets[0].data[i]) || chart
                                        .getDatasetMeta(0).data[i].hidden,
                                    index: i
                                }));
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function (context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.raw;
                                const percentage = Math.round(value / total * 100);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                animations: {
                    animateRotate: true,
                    animateScale: true,
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'easeInOutCubic',
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart',
                    onProgress: function (animation) {
                        const chart = animation.chart;
                        const ctx = chart.ctx;
                        const width = chart.width;
                        const height = chart.height;

                        // Vẽ text ở giữa
                        ctx.restore();
                        const fontSize = (height / 114).toFixed(2);
                        ctx.font = fontSize + 'em sans-serif';
                        ctx.textBaseline = 'middle';

                        const total = {
                            {
                                % 24 completedOrders % 20 % 2 B % 20 % 24 pendingOrders % 20 %
                                    2 B % 20 % 24 cancelledOrders
                            }
                        };
                        const text = `${total} đơn`;
                        const textX = Math.round((width - ctx.measureText(text).width) / 2);
                        const textY = height / 2;

                        ctx.fillStyle = '#666';
                        ctx.fillText(text, textX, textY - fontSize * 8);
                        ctx.save();
                    }
                }
            }
        });
    });
</script>