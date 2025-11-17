<?php

namespace App\Admin\Http\Controllers\Dashboard;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\ProfileMonthly\ProfileMonthlyRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Enums\Order\OrderStatus;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use AuthService;

    public function __construct(
        NotificationRepositoryInterface $repository,
        protected ProfileMonthlyRepositoryInterface $profileMonthlyRepository,
        protected TransactionRepositoryInterface $transactionRepository,
    ) {
        parent::__construct();
        $this->repository = $repository;
    }

    public function getView()
    {
        return [
            'index' => 'admin.dashboard.index',
            'index-default' => 'admin.dashboard.index-default'
        ];
    }
    public function index()
    {
        $profileStatistics = $this->profileMonthlyRepository->getQueryBuilderOrderBy('id', 'ASC')->pluck('total_profiles');
        $totalProfiles = $profileStatistics->sum();
        $profitUser = $this->transactionRepository->getUserProfit();
        $profitPartner = $this->transactionRepository->getPartnerProfit();

        return view($this->view['index-default'], [
            'totalProfiles' => $this->formatNumberShort($totalProfiles),
            'profileStatistics' => $profileStatistics,
            'profitUser' => $profitUser,
            'profitPartner' => $profitPartner,
            'notifications' => []
        ]);
    }

    protected function formatNumberShort($number)
    {
        if ($number >= 1000000000) {
            return round($number / 1000000000, 2) . 'B';
        }
        if ($number >= 1000000) {
            return round($number / 1000000, 2) . 'M';
        }
        if ($number >= 1000) {
            return round($number / 1000, 2) . 'K';
        }
        return (string) $number;
    }
}
