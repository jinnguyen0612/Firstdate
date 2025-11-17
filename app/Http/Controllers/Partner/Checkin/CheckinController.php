<?php

namespace App\Http\Controllers\Partner\Checkin;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Http\Requests\Auth\StaffLoginRequest;
use App\Admin\Repositories\Booking\BookingRepositoryInterface;
use App\Admin\Repositories\Partner\PartnerRepositoryInterface;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Slider\SliderRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\AuthService;
use App\Api\V1\Http\Resources\Transaction\TransactionMessage;
use App\Api\V1\Repositories\Matching\MatchingRepositoryInterface;
use App\Enums\Booking\BookingAttendanceType;
use App\Enums\Booking\BookingDeposit;
use App\Enums\Booking\BookingStatus;
use App\Enums\Deal\DealStatus;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Http\Requests\Partner\Booking\CompletedRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\type;

class CheckinController extends BaseController
{
    private $login;

    protected SettingRepositoryInterface $settingRepository;
    public function __construct(
        SettingRepositoryInterface $settingRepository,
        protected BookingRepositoryInterface $bookingRepository,
        protected UserRepositoryInterface $userRepository,
        protected MatchingRepositoryInterface $matchingRepository,
        protected TransactionRepositoryInterface $transactionRepository,
        protected PartnerRepositoryInterface $partnerRepository,
        private FileService $fileService,
    ) {
        parent::__construct();
        $this->settingRepository = $settingRepository;
    }

    public function index($code)
    {
        $settings = $this->settingRepository->getAll();

        $now = now();
        $today = $now->toDateString();
        $timeNow = $now->format('H:i:s');

        $query = $this->bookingRepository->getQueryBuilder()
            ->whereHas('table', fn($q) => $q->where('code', $code))
            ->whereIn('status', [
                BookingStatus::Confirmed->value,
                BookingStatus::Processing->value,
            ])
            ->where('date', $today)
            ->whereRaw('? between SUBTIME(time, "00:15:00") and ADDTIME(time, "02:00:00")', [$timeNow])
            ->with(['user_male', 'user_female', 'partner', 'table']);

        $booking = $query->first();



        return view('partner.checkin.index', [
            'title' => 'Check-in',
            'booking' => $booking,
            'settings' => $settings,
            'code' => $code,
        ]);
    }

    public function userCheckin($bookingCode, $userCode)
    {
        $settings = $this->settingRepository->getAll();

        $now = now();
        $today = $now->toDateString();
        $timeNow = $now->format('H:i:s');

        $query = $this->bookingRepository->getQueryBuilder()
            ->where('code', $bookingCode)
            ->whereIn('status', [
                BookingStatus::Confirmed->value,
                BookingStatus::Processing->value,
            ])
            ->where(function ($q) use ($userCode) {
                $q->whereHas('user_male', fn($sub) => $sub->where('code', $userCode))
                    ->orWhereHas('user_female', fn($sub) => $sub->where('code', $userCode));
            })
            ->where('date', $today)
            ->whereRaw('? between SUBTIME(time, "00:15:00") and ADDTIME(time, "02:00:00")', [$timeNow])
            ->with(['user_male', 'user_female', 'partner', 'table']);

        $booking = $query->first();

        if (!$booking) {
            abort(404);
        }

        $user = $this->userRepository->getQueryBuilder()
            ->where('code', $userCode)->first();

        return view('partner.checkin.user', [
            'title' => 'Check-in',
            'booking' => $booking,
            'user' => $user,
            'settings' => $settings,
        ]);
    }

    public function staffLoginView($code)
    {
        $settings = $this->settingRepository->getAll();
        return view('partner.checkin.staff_login', [
            'code' => $code,
            'title' => 'Login',
            'settings' => $settings
        ]);
    }

    public function staffLogin(StaffLoginRequest $request)
    {
        try {
            $this->login = $request->validated();
            $code = $request->code;
            unset($this->login['code']);

            $partner = $this->partnerRepository->getQueryBuilder()
                ->whereHas('partner_table', fn($q) => $q->where('code', $code))
                ->first();

            if (!$partner) {
                return back()->with('error', __('Mã bàn không tồn tại'));
            }
            $this->login['email'] = $partner->email;

            Auth::guard('admin')->logout();

            $attempt = $this->resolvePartner();
            if ($attempt) {
                $request->session()->regenerate();
                return $this->handlePartnerLogin($code);
            }

            return back()->with('error', __('Mật khẩu không đúng'));
        } catch (\Throwable $th) {
            Log::error('Error login: ' . $th->getMessage());
            return back()->with('error', __('Đã có lỗi xảy ra'));
        }
    }

    protected function resolvePartner()
    {
        return Auth::guard('partner')->attempt([
            'email' => $this->login['email'],
            'password' => $this->login['password'],
        ], true);
    }

    protected function handlePartnerLogin($code)
    {
        if (Auth::guard('partner')->check()) {
            return redirect()->intended(route('partner.staff', ['code' => $code]))->with('success', __('Đăng nhập thành công'));
        }
    }


    public function staff($code)
    {
        $settings = $this->settingRepository->getAll();

        $now = now();
        $today = $now->toDateString();

        $query = $this->bookingRepository->getQueryBuilder()
            ->whereHas('table', fn($q) => $q->where('code', $code))
            ->whereIn('status', [
                BookingStatus::Confirmed->value,
                BookingStatus::Processing->value,
                BookingStatus::Completed->value,
            ])
            ->where('date', $today)
            ->orderBy('time', 'asc')
            ->with(['user_male', 'user_female', 'partner', 'table']);

        $bookings = $query->get();



        return view('partner.checkin.staff', [
            'title' => 'Check-in',
            'bookings' => $bookings,
            'settings' => $settings,
            'code' => $code,
            'today' => $today,
        ]);
    }


    public function sendUserCheckin($bookingCode, $userCode)
    {
        try {
            $data = request()->validate([
                'pin' => 'required|string|size:6',
            ]);

            $booking = $this->bookingRepository->getQueryBuilder()
                ->where('code', $bookingCode)
                ->whereIn('status', [
                    BookingStatus::Confirmed->value,
                ])
                ->where(function ($q) use ($userCode) {
                    $q->whereHas('user_male', fn($sub) => $sub->where('code', $userCode))
                        ->orWhereHas('user_female', fn($sub) => $sub->where('code', $userCode));
                })
                ->with(['user_male', 'user_female', 'partner', 'table'])
                ->first();

            if (!$booking) {
                abort(404);
            }

            $user = $this->userRepository->getQueryBuilder()
                ->where('code', $userCode)->first();

            if (!$user || $user->pin !== $data['pin']) {
                return response()->json(['status' => 400, 'message' => 'Mã PIN không hợp lệ. Vui lòng thử lại.']);
            }

            if ($booking->hasUserAttended($user->id)) {
                return response()->json(['status' => 400, 'message' => 'Người dùng đã điểm danh trước đó.']);
            }

            $booking->attendance()->create([
                'user_id' => $user->id,
                'type' => BookingAttendanceType::Attended->value,
            ]);

            $checkin = $booking->attendance()->where('type', BookingAttendanceType::Attended->value)->get();

            if (count($checkin) == 2) {
                $booking->status = BookingStatus::Processing->value;
                $booking->save();
            }


            return response()->json(['status' => 200, 'message' => 'Điểm danh thành công!']);
        } catch (\Throwable $th) {
            Log::info('Checkin error: ' . $th->getMessage());
            return response()->json(['status' => 500, 'message' => 'Điểm danh thất bại! Vui lòng thử lại.']);
        }
    }

    public function staffDetail($code, $bookingCode)
    {
        $settings = $this->settingRepository->getAll();

        $now = now();
        $today = $now->toDateString();

        $query = $this->bookingRepository->getQueryBuilder()
            ->where('code', $bookingCode)
            ->whereIn('status', [
                BookingStatus::Confirmed->value,
                BookingStatus::Processing->value,
                BookingStatus::Completed->value,
            ])
            ->where('date', $today)
            ->orderBy('time', 'asc')
            ->with(['user_male', 'user_female', 'partner', 'table']);

        $booking = $query->first();



        return view('partner.checkin.staff_detail', [
            'title' => 'Check-in',
            'booking' => $booking,
            'settings' => $settings,
            'code' => $code,
            'today' => $today,
        ]);
    }

    public function completed(CompletedRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Khóa bản ghi để tránh race-condition
            /** @var \App\Models\Booking $booking */
            $booking = $this->bookingRepository->getQueryBuilder()->with(['attendance', 'deposits', 'partner', 'user_male', 'user_female', 'deal'])
                ->whereKey($data['id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Chuẩn hoá tiền
            $rawTotal = $data['total'] ?? null;
            if (is_string($rawTotal)) {
                $rawTotal = str_replace(',', '', $rawTotal);
            }
            $total = $rawTotal !== null && $rawTotal !== '' ?  round((float) $rawTotal) : null;

            $profit_percent = (float) ($this->settingRepository
                ->getQueryBuilder()
                ->where('setting_key', 'profit_split')
                ->pluck('plain_value')
                ->first() ?? 0);

            $profitSplit = $total !== null
                ?  round($total * $profit_percent / 100)
                : 0;

            // Upload invoice nếu có (giữ nguyên hành vi cũ)
            if (!empty($data['invoice'])) {
                $data['invoice'] = $this->fileService->uploadAvatar('partner/invoice', $data['invoice']);
            }

            // Đếm attendance 1 lần
            $attendedCount = $booking->attendance()
                ->where('type', BookingAttendanceType::Attended->value)
                ->count();


            if ($booking->status === BookingStatus::Processing->value) {
                // Request cũ đã bắt buộc total + invoice ở trạng thái này
                // -> tiếp tục tính phí & hoàn cọc
                $this->bookingRepository->update($booking->id, ['status' => BookingStatus::Completed->value]);

                $booking->invoice()->updateOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'total'        => $total,
                        'invoice'      => $data['invoice'] ?? null,
                        'profit_split' => $profitSplit,
                    ]
                );

                $currentPartner = $this->partnerRepository->findOrFail($booking->partner_id);
                $currentPartner->decrement('wallet', $profitSplit);

                $this->transactionRepository->createTransaction(
                    null,
                    $currentPartner,
                    $profitSplit,
                    TransactionType::Payment->value,
                    TransactionStatus::Success->value,
                    null,
                    TransactionMessage::message(TransactionType::Payment->value, [
                        'value'   => $profitSplit,
                        'service' => 'phí dịch vụ cuộc hẹn có mã #' . $booking->code,
                    ])
                );

                // Xoá matching 2 chiều
                $this->matchingRepository->deleteBy(['user_id' => $booking->user_male_id, 'user_loved_id' => $booking->user_female_id]);
                $this->matchingRepository->deleteBy(['user_id' => $booking->user_female_id, 'user_loved_id' => $booking->user_male_id]);

                // Hoàn cọc cho 2 user
                $maleRefund = $booking->depositForUser($booking->user_male_id);
                if ($maleRefund > 0) {
                    $booking->user_male->increment('wallet', $maleRefund);
                    $this->transactionRepository->createTransaction(
                        null,
                        $booking->user_male,
                        $maleRefund,
                        TransactionType::Refund->value,
                        TransactionStatus::Success->value,
                        null,
                        TransactionMessage::message(TransactionType::Refund->value, [
                            'value'   => $maleRefund,
                            'service' => 'hoàn cọc cuộc hẹn có mã #' . $booking->code,
                        ])
                    );
                }

                $femaleRefund = $booking->depositForUser($booking->user_female_id);
                if ($femaleRefund > 0) {
                    $booking->user_female->increment('wallet', $femaleRefund);
                    $this->transactionRepository->createTransaction(
                        null,
                        $booking->user_female,
                        $femaleRefund,
                        TransactionType::Refund->value,
                        TransactionStatus::Success->value,
                        null,
                        TransactionMessage::message(TransactionType::Refund->value, [
                            'value'   => $femaleRefund,
                            'service' => 'hoàn cọc cuộc hẹn có mã #' . $booking->code,
                        ])
                    );
                }

                DB::commit();
                return response()->json(['status' => 200, 'message' => 'Đã hoàn thành cuộc hẹn.']);
            }

            if ($booking->status === BookingStatus::Confirmed->value) {
                if ($attendedCount === 1) {
                    $booking->update([
                        'status' => BookingStatus::Cancelled->value,
                        'note'   => 'Có 1 người đã không đến cuộc hẹn.',
                    ]);
                    $booking->deal()?->update(['status' => DealStatus::Cancelled->value, 'updated_at' => now()]);

                    $attendanceUser = $booking->attendance()
                        ->where('type', BookingAttendanceType::Attended->value)
                        ->first();

                    // FIX: So sánh theo user_id (không phải id của bản ghi attendance)
                    $attendedUserId = $attendanceUser?->user_id;
                    if (!$attendedUserId) {
                        DB::rollBack();
                        return response()->json(['status' => 400, 'message' => 'Dữ liệu điểm danh không hợp lệ.'], 400);
                    }

                    $absentUser = ($attendedUserId == $booking->user_male_id)
                        ? $booking->user_female
                        : $booking->user_male;

                    // Ghi nhận Absent nếu chưa có
                    $booking->attendance()->updateOrCreate(
                        [
                            'user_id' => $absentUser->id,
                            'type'    => BookingAttendanceType::Absent->value,
                        ],
                        [] // không cập nhật gì thêm
                    );

                    // Xoá matching 2 chiều
                    $this->matchingRepository->deleteBy(['user_id' => $booking->user_male_id, 'user_loved_id' => $booking->user_female_id]);
                    $this->matchingRepository->deleteBy(['user_id' => $booking->user_female_id, 'user_loved_id' => $booking->user_male_id]);

                    // Chia cọc:
                    // - Cọc của người vắng: Forfeited
                    //   + Người còn lại nhận 2/5 cọc của người vắng
                    //   + Partner nhận 1/5 cọc của người vắng
                    // - Cọc của người đã đến: hoàn 100%
                    if (!empty($booking->deposits)) {
                        foreach ($booking->deposits as $deposit) {
                            if ($deposit->user_id === $absentUser->id) {
                                // Người vắng
                                $deposit->update(['status' => BookingDeposit::Forfeited->value]);

                                $otherDeposit = $booking->deposits->firstWhere('user_id', '!=', $deposit->user_id);
                                if ($otherDeposit) {
                                    $otherUser = $this->userRepository->find($otherDeposit->user_id);

                                    $shareOther   =  floor(((2 * $deposit->amount) / 5) +  $deposit->support_money??0);
                                    $this->transactionRepository->createTransaction(
                                        null,
                                        $otherUser,
                                        $shareOther,
                                        TransactionType::Refund->value,
                                        TransactionStatus::Success->value,
                                        null,
                                        TransactionMessage::message(TransactionType::Refund->value, [
                                            'value'   => $shareOther,
                                            'service' => 'tiền phạt của người hủy cuộc hẹn ngày ' . $booking->date,
                                        ])
                                    );
                                    $otherUser->increment('wallet', $shareOther);

                                    $partner = $booking->partner;
                                    $sharePartner =  floor($deposit->amount / 5);
                                    $this->transactionRepository->createTransaction(
                                        null,
                                        $partner,
                                        $sharePartner,
                                        TransactionType::Refund->value,
                                        TransactionStatus::Success->value,
                                        null,
                                        TransactionMessage::message(TransactionType::Refund->value, [
                                            'value'   => $sharePartner,
                                            'service' => 'tiền phạt của người hủy cuộc hẹn ngày ' . $booking->date,
                                        ])
                                    );
                                    $partner->increment('wallet', $sharePartner);
                                }
                            } else {
                                // Người đã đến: hoàn 100% cọc
                                $user = $this->userRepository->find($deposit->user_id);

                                $this->transactionRepository->createTransaction(
                                    null,
                                    $user,
                                    ($deposit->amount + $deposit->support_money??0),
                                    TransactionType::Refund->value,
                                    TransactionStatus::Success->value,
                                    null,
                                    TransactionMessage::message(TransactionType::Refund->value, [
                                        'value'   => ($deposit->amount + $deposit->support_money??0),
                                        'service' => 'có người không tham gia cuộc hẹn ngày ' . $booking->date,
                                    ])
                                );
                                $user->increment('wallet', ($deposit->amount + $deposit->support_money??0));

                                $deposit->update([
                                    'status'          => BookingDeposit::Refunded->value,
                                    'refunded_at'     => now(),
                                    'refunded_amount' => ($deposit->amount + $deposit->support_money??0),
                                ]);
                            }
                        }
                    }

                    DB::commit();
                    return response()->json(['status' => 200, 'message' => 'Đã hoàn thành cuộc hẹn.']);
                }

                // B3) Không ai đến -> huỷ + Partner nhận 1/4 mỗi khoản cọc
                if ($attendedCount === 0) {
                    $booking->update([
                        'status' => BookingStatus::Cancelled->value,
                        'note'   => 'Không ai đến cuộc hẹn.',
                    ]);
                    $booking->deal()?->update(['status' => DealStatus::Cancelled->value, 'updated_at' => now()]);

                    // Ghi absent cho cả hai
                    $booking->attendance()->updateOrCreate(
                        ['user_id' => $booking->user_male_id,   'type' => BookingAttendanceType::Absent->value],
                        []
                    );
                    $booking->attendance()->updateOrCreate(
                        ['user_id' => $booking->user_female_id, 'type' => BookingAttendanceType::Absent->value],
                        []
                    );

                    // Xoá matching
                    $this->matchingRepository->deleteBy(['user_id' => $booking->user_male_id, 'user_loved_id' => $booking->user_female_id]);
                    $this->matchingRepository->deleteBy(['user_id' => $booking->user_female_id, 'user_loved_id' => $booking->user_male_id]);

                    if (!empty($booking->deposits)) {
                        $partner = $booking->partner;
                        foreach ($booking->deposits as $deposit) {
                            $deposit->update(['status' => BookingDeposit::Forfeited->value]);

                            $sharePartner =  floor(($deposit->amount + $deposit->support_money??0) / 4);
                            $this->transactionRepository->createTransaction(
                                null,
                                $partner,
                                $sharePartner,
                                TransactionType::Refund->value,
                                TransactionStatus::Success->value,
                                null,
                                TransactionMessage::message(TransactionType::Refund->value, [
                                    'value'   => $sharePartner,
                                    'service' => 'tiền phạt của người hủy cuộc hẹn ngày ' . $booking->date,
                                ])
                            );
                            $partner->increment('wallet', $sharePartner);
                        }
                    }

                    DB::commit();
                    return response()->json(['status' => 200, 'message' => 'Đã hoàn thành cuộc hẹn.']);
                }

                DB::rollBack();
                return response()->json(['status' => 400, 'message' => 'Trạng thái điểm danh không hợp lệ.'], 400);
            }

            DB::rollBack();
            return response()->json(['status' => 404, 'message' => 'Không tìm thấy cuộc hẹn hoặc trạng thái không hợp lệ.'], 404);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Booking completed error: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return response()->json(['status' => 400, 'message' => 'Đã có lỗi xảy ra.'], 400);
        }
    }
}
