<?php

namespace App\Http\Controllers\Partner\Booking;

use App\Admin\Http\Requests\Auth\LoginRequest;
use App\Admin\Repositories\Booking\BookingRepositoryInterface;
use App\Admin\Repositories\Deal\DealRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\RejectReason\RejectReasonRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Slider\SliderRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\AuthService;
use App\Api\V1\Http\Resources\Transaction\TransactionMessage;
use App\Api\V1\Repositories\Matching\MatchingRepositoryInterface;
use App\Enums\Booking\BookingDeposit;
use App\Enums\Booking\BookingStatus;
use App\Enums\Deal\DealStatus;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Http\Requests\Partner\Booking\AcceptCancelRequest;
use App\Http\Requests\Partner\Booking\AcceptRequest;
use App\Http\Requests\Partner\Booking\CompletedRequest;
use App\Http\Requests\Partner\Booking\RejectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    use AuthService;
    private $login;

    protected SettingRepositoryInterface $settingRepository;
    protected SliderRepositoryInterface $sliderRepository;
    public function __construct(
        SettingRepositoryInterface $settingRepository,
        SliderRepositoryInterface $sliderRepository,
        protected BookingRepositoryInterface $bookingRepository,
        protected DealRepositoryInterface $dealRepository,
        protected MatchingRepositoryInterface $matchingRepository,
        protected NotificationRepositoryInterface $notificationRepository,
        protected UserRepositoryInterface $userRepository,
        protected TransactionRepositoryInterface $transactionRepository,
        protected RejectReasonRepositoryInterface $rejectReasonRepository,
        private FileService $fileService,
    ) {
        parent::__construct();
        $this->settingRepository = $settingRepository;
        $this->sliderRepository = $sliderRepository;
    }
    public function getView()
    {
        return [
            'index' => 'partner.home.index',
            'detail' => 'partner.booking.index',
        ];
    }
    public function home()
    {
        $settings = $this->settingRepository->getAll();
        $currentPartnerId = $this->getCurrentPartnerId();
        $newBookings = $this->bookingRepository->getNewBookingPartner();
        $confirmBookings = $this->bookingRepository->getComfirmBookingPartner();
        $rejectReason = $this->rejectReasonRepository->getAll();

        return view($this->view['index'], [
            'settings' => $settings,
            'title' => 'Trang chủ',
            'bookingStatus' => BookingStatus::asSelectArray(),
            'newBookings' => $newBookings,
            'confirmBookings' => $confirmBookings,
            'rejectReason' => $rejectReason,
        ]);
    }

    public function detail($code)
    {
        $settings = $this->settingRepository->getAll();
        $booking = $this->bookingRepository->findByCodePartner($code);
        $rejectReason = $this->rejectReasonRepository->getAll();
        return view($this->view['detail'], [
            'settings' => $settings,
            'title' => 'Chi tiết cuộc hẹn',
            'booking' => $booking,
            'rejectReason' => $rejectReason,
        ]);
    }

    public function reject(RejectRequest $request)
    {
        $data = $request->validated();
        $booking = $this->bookingRepository->findOrFail($data['id']);
        DB::beginTransaction();
        try {
            if ($booking->status == BookingStatus::Pending->value) {

                $this->bookingRepository->update($booking->id, ['status' => BookingStatus::Cancelled->value, 'note' => $data['note']]);
                $this->dealRepository->update($booking->deal_id, ['status' => DealStatus::Cancelled->value]);

                $this->matchingRepository->deleteBy(['user_id' => $booking->user_male_id, 'user_loved_id' => $booking->user_female_id]);
                $this->matchingRepository->deleteBy(['user_id' => $booking->user_female_id, 'user_loved_id' => $booking->user_male_id]);

                $this->notificationRepository->create([
                    'user_id' => $booking->user_male_id,
                    'title' => 'Cuộc hẹn có mã #' . $booking->code . ' đã bị hủy',
                    'short_message' => 'Đối tác đã từ chối cuộc hẹn của bạn với lý do: ' . $data['note'],
                    'message' => 'Đối tác đã từ chối cuộc hẹn của bạn với lý do: ' . $data['note'] . '. ',
                ]);

                $this->notificationRepository->create([
                    'user_id' => $booking->user_female_id,
                    'title' => 'Cuộc hẹn có mã #' . $booking->code . ' đã bị hủy',
                    'short_message' => 'Đối tác đã từ chối cuộc hẹn của bạn với lý do: ' . $data['note'],
                    'message' => 'Đối tác đã từ chối cuộc hẹn của bạn với lý do: ' . $data['note'] . '. ',
                ]);

                if (!empty($booking->deposits)) {

                    foreach ($booking->deposits as $deposit) {
                        $user = $this->userRepository->find($deposit->user_id);
                        $message = [
                            'value' => $deposit->amount,
                            'service' => 'đối tác đã không xác nhận cuộc hẹn ngày ' . $booking->date,
                        ];
                        $this->transactionRepository->createTransaction(
                            null,
                            $user,
                            $deposit->amount,
                            TransactionType::Refund->value,
                            TransactionStatus::Success->value,
                            null,
                            TransactionMessage::message(TransactionType::Refund->value, $message)
                        );
                        $user->increment('wallet', $deposit->amount);
                        $deposit->update(['status' => BookingDeposit::Refunded->value, 'refunded_at' => now(), 'refunded_amount' => $deposit->amount]);
                    }
                }
                DB::commit();
                return response()->json(['status' => 200, 'message' => 'Hủy cuộc hẹn thành công.']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error('Error: ' . $th->getMessage());
            return response()->json([
                'status' => 400,
                'message' => 'Thực hiện thất bại. Hãy kiểm tra lại.'
            ], 400);
        }
    }

    public function accept(AcceptRequest $request)
    {
        $data = $request->validated();
        $booking = $this->bookingRepository->findByCode($data['code']);
        DB::beginTransaction();
        try {

            if ($booking->status == BookingStatus::Pending->value) {
                $this->bookingRepository->update($booking->id, ['status' => BookingStatus::Confirmed->value, 'time' => $data['time'], 'partner_table_id' => $data['partner_table_id'] ?? null]);
                $this->dealRepository->update($booking->deal_id, ['status' => DealStatus::Confirmed->value]);
                DB::commit();
                return response()->json(['status' => 200, 'message' => 'Xác nhận thành công.']);
            } else {
                if ($booking->status != BookingStatus::Pending->value) {
                    return response()->json([
                        'status' => 409,
                        'message' => 'Trạng thái không hợp lệ.'
                    ], 409);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error: ' . $th->getMessage());
            return response()->json([
                'status' => 400,
                'message' => 'Thực hiện thất bại. Hãy kiểm tra lại.'
            ], 400);
        }
    }

    public function acceptCancel(AcceptCancelRequest $request)
    {
        $data = $request->validated();

        $booking = $this->bookingRepository->findOrFail($data['id']);
        $deal = $this->dealRepository->findOrFail($booking['deal_id']);
        DB::beginTransaction();
        try {

            $deal->update([
                'status' => DealStatus::Cancelled->value,
                'updated_at' => now(),
            ]);

            foreach ($data['checkbox'] as $id) {
                $deal->dealCancellation()->create([
                    'reason' => $data['reason'],
                    'canceled_by' => $id,
                    'canceled_at' => now(),
                ]);
            }

            $booking->update([
                'status' => BookingStatus::Cancelled->value,
                'updated_at' => now(),
            ]);

            $this->matchingRepository->deleteBy(['user_id' => $booking->user_male_id, 'user_loved_id' => $booking->user_female_id]);
            $this->matchingRepository->deleteBy(['user_id' => $booking->user_female_id, 'user_loved_id' => $booking->user_male_id]);

            if (!empty($booking->deposits)) {

                foreach ($booking->deposits as $deposit) {
                    if (count($data['checkbox']) == 2) {

                        $deposit->update(['status' => BookingDeposit::Forfeited->value]);

                        $partner = $this->getCurrentPartner();

                        $message = [
                            'value' => $deposit->amount / 5,
                            'service' => 'tiền phạt của người hủy cuộc hẹn ngày ' . $booking->date,
                        ];

                        $this->transactionRepository->createTransaction(
                            null,
                            $partner,
                            $deposit->amount / 5,
                            TransactionType::Refund->value,
                            TransactionStatus::Success->value,
                            null,
                            TransactionMessage::message(TransactionType::Refund->value, $message)
                        );
                        $partner->increment('wallet', $deposit->amount / 5);
                    } elseif (in_array($deposit->user->id, $data['checkbox'])) {
                        $deposit->update(['status' => BookingDeposit::Forfeited->value]);

                        $ortherDeposit = $booking->deposits->firstWhere('user_id', '!=', $deposit->user_id);

                        if ($ortherDeposit != null) {
                            $ortherUser = $this->userRepository->find($ortherDeposit->user_id);
                            $message = [
                                'value' => (2 * $deposit->amount) / 5,
                                'service' => 'tiền phạt của người hủy cuộc hẹn ngày ' . $booking->date,
                            ];
                            $this->transactionRepository->createTransaction(
                                null,
                                $ortherUser,
                                (2 * $deposit->amount) / 5,
                                TransactionType::Refund->value,
                                TransactionStatus::Success->value,
                                null,
                                TransactionMessage::message(TransactionType::Refund->value, $message)
                            );
                            $ortherUser->increment('wallet', (2 * $deposit->amount) / 5);

                            $partner = $this->getCurrentPartner();

                            $message = [
                                'value' => $deposit->amount / 5,
                                'service' => 'tiền phạt của người hủy cuộc hẹn ngày ' . $booking->date,
                            ];

                            $this->transactionRepository->createTransaction(
                                null,
                                $partner,
                                $deposit->amount / 5,
                                TransactionType::Refund->value,
                                TransactionStatus::Success->value,
                                null,
                                TransactionMessage::message(TransactionType::Refund->value, $message)
                            );
                            $partner->increment('wallet', $deposit->amount / 5);
                        }
                    } else {
                        $user = $this->userRepository->find($deposit->user_id);
                        $message = [
                            'value' => $deposit->amount,
                            'service' => 'có người không tham gia cuộc hẹn ngày ' . $booking->date,
                        ];
                        $this->transactionRepository->createTransaction(
                            null,
                            $user,
                            $deposit->amount,
                            TransactionType::Refund->value,
                            TransactionStatus::Success->value,
                            null,
                            TransactionMessage::message(TransactionType::Refund->value, $message)
                        );
                        $user->increment('wallet', $deposit->amount);
                        $deposit->update(['status' => BookingDeposit::Refunded->value, 'refunded_at' => now(), 'refunded_amount' => $deposit->amount]);
                    }
                }
            }
            Db::commit();
            return response()->json(['status' => 200, 'message' => 'Huỷ cuộc hẹn thành công.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error: ' . $th->getMessage());
            return response()->json([
                'status' => 400,
                'message' => 'Thực hiện thất bại. Hãy kiểm tra lại.'
            ], 400);
        }
    }

    public function toProcessing($id)
    {
        $booking = $this->bookingRepository->findOrFail($id);
        $currentPartner = $this->getCurrentPartner();
        DB::beginTransaction();
        try {
            if ($booking->partner_id == $currentPartner->id && $booking->status == BookingStatus::Confirmed->value) {
                $this->bookingRepository->update($booking->id, ['status' => BookingStatus::Processing->value]);
                DB::commit();
                return response()->json(['status' => 200, 'message' => 'Đã chuyển sang trạng thái đang diễn ra.']);
            }
            return response()->json(['status' => 404, 'message' => 'Không tìm thấy cuộc hẹn hoặc trạng thái không hợp lệ.'], 404);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error: ' . $th->getMessage());
            return response()->json(['status' => 400, 'message' => 'Đã có lỗi xảy ra.'], 400);
        }
    }

    public function completed(CompletedRequest $request)
    {
        $data = $request->validated();
        $currentPartner = $this->getCurrentPartner();
        $profit_percent = $this->settingRepository->getQueryBuilder()->where('setting_key', 'profit_split')->pluck('plain_value')->first();
        $booking = $this->bookingRepository->findOrFail($data['id']);
        $data['total'] = str_replace(',', '', $data['total']);
        $data['profit_split'] = round(((float)$data['total']) * ((float)$profit_percent) / 100);

        if ($data['invoice']) {
            $data['invoice'] = $this->fileService->uploadAvatar('partner/invoice', $data['invoice']);;
        }

        $currentPartner = $this->getCurrentPartner();
        DB::beginTransaction();
        try {
            if ($booking->partner_id == $currentPartner->id && $booking->status == BookingStatus::Processing->value) {
                $this->bookingRepository->update($booking->id, ['status' => BookingStatus::Completed->value]);
                $booking->invoice()->updateOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'total' => $data['total'],
                        'invoice' => $data['invoice'] ?? null,
                        'profit_split' => $data['profit_split'],
                    ]
                );
                $currentPartner->decrement('wallet', $data['profit_split']);

                $this->transactionRepository->createTransaction(
                    null,
                    $currentPartner,
                    $data['profit_split'],
                    TransactionType::Payment->value,
                    TransactionStatus::Success->value,
                    null,
                    TransactionMessage::message(TransactionType::Payment->value, [
                        'value' => $data['profit_split'],
                        'service' => 'phí dịch vụ cuộc hẹn có mã #' . $booking->code,
                    ])
                );

                $this->matchingRepository->deleteBy(['user_id' => $booking->user_male_id, 'user_loved_id' => $booking->user_female_id]);
                $this->matchingRepository->deleteBy(['user_id' => $booking->user_female_id, 'user_loved_id' => $booking->user_male_id]);

                $booking->user_male->increment('wallet', $booking->depositForUser($booking->user_male_id));
                $this->transactionRepository->createTransaction(
                    null,
                    $booking->user_male,
                    $booking->depositForUser($booking->user_male_id),
                    TransactionType::Refund->value,
                    TransactionStatus::Success->value,
                    null,
                    TransactionMessage::message(TransactionType::Refund->value, [
                        'value' => $booking->depositForUser($booking->user_male_id),
                        'service' => 'hoàn cọc cuộc hẹn có mã #' . $booking->code,
                    ])
                );
                
                $booking->user_female->increment('wallet', $booking->depositForUser($booking->user_female_id));
                $this->transactionRepository->createTransaction(
                    null,
                    $booking->user_female,
                    $booking->depositForUser($booking->user_female_id),
                    TransactionType::Refund->value,
                    TransactionStatus::Success->value,
                    null,
                    TransactionMessage::message(TransactionType::Refund->value, [
                        'value' => $booking->depositForUser($booking->user_female_id),
                        'service' => 'hoàn cọc cuộc hẹn có mã #' . $booking->code,
                    ])
                );

                DB::commit();
                return response()->json(['status' => 200, 'message' => 'Đã hoàn thành cuộc hẹn.']);
            }
            return response()->json(['status' => 404, 'message' => 'Không tìm thấy cuộc hẹn hoặc trạng thái không hợp lệ.'], 404);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error: ' . $th->getMessage());
            return response()->json(['status' => 400, 'message' => 'Đã có lỗi xảy ra.'], 400);
        }
    }

    public function ajaxNewBooking(Request $request)
    {
        $search = $request->get('search');
        $date = $request->get('date');

        $newBookings = $this->bookingRepository
            ->getNewBookingPartner($search, $date);

        return view('partner.home.tabs.new_deal', [
            'newBookings' => $newBookings
        ])->render();
    }


    public function ajaxConfirmBooking(Request $request)
    {
        $search = $request->get('search');
        $date = $request->get('date');
        $status = $request->get('status');

        $confirmBookings = $this->bookingRepository
            ->getComfirmBookingPartner($status, $search, $date);

        return view('partner.home.tabs.list_booking', [
            'confirmBookings' => $confirmBookings
        ])->render();
    }
}
