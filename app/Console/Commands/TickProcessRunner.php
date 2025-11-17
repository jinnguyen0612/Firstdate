<?php

namespace App\Console\Commands;

use App\Enums\Booking\BookingStatus;
use App\Enums\Deal\DealStatus;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Process\ProcessStatus;
use App\Enums\Process\ProcessType;
use App\Enums\User\Gender;
use App\Models\Deal;
use App\Models\Matching;
use App\Models\Notification;
use App\Models\Process;
use App\Models\User;
use App\Traits\SendMail;
use App\Traits\SendNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TickProcessRunner extends Command
{
    use SendNotification;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tick:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra và xử lý các tiến trình gửi thông báo';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now();

        $dueProcesses = Process::whereIn('status', ['running', 'hold'])
            ->where('next_send_at', '<=', $now)
            ->get();

        foreach ($dueProcesses as $process) {

            $user = User::find($process->user_id);
            $deal = Deal::find($process->deal_id);

            if ($process->status == ProcessStatus::Hold->value) {

                $deal->update([
                    'status' => DealStatus::Cancelled->value,
                ]);

                $deal->dealCancellation()->create([
                    'cancelled_by' => $user->id,
                    'cancelled_at' => now(),
                    'reason' => 'Quá thời gian chờ phản hồi sau match',
                ]);

                if ($process->type == ProcessType::PayDeposit->value) {
                    $deal->booking()->update([
                        'status' => BookingStatus::Cancelled->value,
                    ]);
                }

                $log = Matching::whereIn('user_id', [$deal->user_male_id, $deal->user_female_id])
                    ->whereIn('user_loved_id', [$deal->user_male_id, $deal->user_female_id])->get();


                $log->each(function ($item) {
                    $item->delete();
                    Log::info("[Matching] Xóa tương hợp #{$item->id}");
                });

                $process->delete();

                Log::info("[Process] Hủy tiến trình #{$process->id}");
                continue;
            }

            // Cập nhật tiến trình
            $process->increment('sent_count');

            // Gửi thông báo nhắc nhở
            if ($user) {
                $time = (8 - $process->sent_count) + 1;
                if ($process->type == ProcessType::PayDeposit->value) {
                    $message = 'Bạn có yêu cầu đặt cọc cho cuộc hẹn có mã #' . $deal->id . '. Vui lòng đặt cọc sớm nhất có thể để tiến hành cuộc hẹn. Sau ' . $time . ' tiếng nếu bạn không đặt cọc, hệ thống sẽ tự động hủy tương hợp và hủy cuộc hẹn.';
                    $short_message = 'Yêu cầu đặt cọc cho cuộc hẹn có mã #' . $deal->id;
                } else {
                    if ($user->id == $deal->user_male_id) {
                        $message = 'Bạn ghép cặp của bạn đã hoàn thành chọn các ' . $process->key . '. Vui lòng chọn một trong 5 ' . $process->key . ' đó. Sau ' . $time . ' tiếng nếu bạn không chọn, hệ thống sẽ tự động hủy tương hợp và hủy cuộc hẹn.';
                        $short_message = 'Bạn ghép cặp của bạn đã hoàn thành chọn các ' . $process->key . '. Vui lòng chọn một trong 5 ' . $process->key . ' đó.';
                    } else {
                        $message = 'Vui lòng chọn 5 ' . $process->key . ' để lên kèo hẹn hò. Sau ' . $time . ' tiếng nếu bạn không chọn, hệ thống sẽ tự động hủy tương hợp và hủy cuộc hẹn.';
                        $short_message = 'Vui lòng chọn 5 ' . $process->key . ' để lên kèo hẹn hò.';
                    }
                }

                $notification = Notification::create([
                    'user_id' => $user->id,
                    'title' => $process->title,
                    'short_message' => $short_message,
                    'message' => $message,
                    'status' => NotificationStatus::NOT_READ->value
                ]);

                // //push notification
                // $this->sendNotificationRecord($notification, $user->device_token);
                Log::info("[Process] Đã gửi thông báo nhắc nhở #{$notification->id} cho người dùng #{$user->id}");
            }
            $after1Hours = $now->copy()->addHours(1);
            $nextSendAt = $now->copy()->addDay()->startOfDay()->addHours(9);
            if ($process->sent_count >= 8) {
                if ($after1Hours->isSameDay($now)) {
                    $process->update([
                        'status' => 'hold',
                        // 'next_send_at' => $now->addHour(), // Giữ thêm 1h
                        'next_send_at' => $after1Hours,
                    ]);
                } else if ($user->gender == Gender::Female->value) {
                    $process->update([
                        'status' => 'hold',
                        'next_send_at' => $nextSendAt,
                    ]);
                }
            } else {
                if ($after1Hours->isSameDay($now)) {
                    $process->update([
                        'next_send_at' => $after1Hours,
                    ]);
                } else if ($user->gender == Gender::Female->value) {
                    $process->update([
                        'next_send_at' => $nextSendAt,
                    ]);
                }
            }
        }
    }
}
