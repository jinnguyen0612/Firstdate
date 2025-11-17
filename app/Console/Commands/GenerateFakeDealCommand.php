<?php

namespace App\Console\Commands;

use App\Admin\Traits\Setup;
use App\Enums\User\Gender;
use App\Models\Matching;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateFakeDealCommand extends Command
{
    use Setup;

    protected $signature = 'deals:generate {count=1}';
    protected $description = 'Tạo deal giả lập để test hệ thống';

    /**
     * Danh sách cặp userId khả dụng để random.
     *
     * @var array<int, array{0:int,1:int}>
     */
    protected array $pairs = [];

    public function handle()
    {
        /** @var \App\Api\V1\Repositories\Deal\DealRepositoryInterface $dealRepository */
        $dealRepository = app()->make(
            \App\Api\V1\Repositories\Deal\DealRepositoryInterface::class
        );

        Log::info('[Command] Bắt đầu tạo deal giả lập');
        $count = (int) $this->argument('count');

        // Generate tất cả cặp user 1 lần
        $this->pairs = $this->generatePairs();
        if (empty($this->pairs)) {
            Log::warning('[Command] Không có user nào để tạo cặp');
            return Command::FAILURE;
        }

        // Xáo trộn để random hơn
        shuffle($this->pairs);

        for ($i = 0; $i < $count; $i++) {
            $matching = $this->randomMatch();

            if (!$matching) {
                Log::warning("[Command] Không tìm được matching cho vòng lặp #{$i}, dừng lại.");
                break;
            }

            $user1 = $matching['user1'];
            $user2 = $matching['user2'];

            if (!$user1 || !$user2) {
                Log::error('[Command] Một trong hai user không tồn tại, bỏ qua tạo deal.');
                continue;
            }

            // Guard: không cho phép 2 user giống nhau
            if ($user1->id === $user2->id) {
                Log::error("[Command] Phát hiện user1 == user2 ({$user1->id}), bỏ qua tạo deal.");
                continue;
            }

            $isSameGender = $user1->gender == $user2->gender;
            $hasOther     = in_array(Gender::Other, [$user1->gender, $user2->gender], true);

            // Xác định id nam / nữ theo rule
            if ($isSameGender || $hasOther) {
                // Không phân biệt giới tính: dùng thẳng 2 user
                $userFemaleId = $user1->id;
                $userMaleId   = $user2->id;
            } else {
                // Phân biệt nam / nữ đúng vị trí
                $userFemaleId = $user1->gender == Gender::Female ? $user1->id : $user2->id;
                $userMaleId   = $user1->gender == Gender::Male   ? $user1->id : $user2->id;
            }

            // Guard: không cho phép deal có 2 id trùng nhau
            if ($userFemaleId === $userMaleId) {
                Log::error("[Command] user_female_id == user_male_id ({$userFemaleId}), bỏ qua tạo deal.");
                continue;
            }

            // --- Tạo deal ---
            $deal = $dealRepository->create([
                'user_female_id' => $userFemaleId,
                'user_male_id'   => $userMaleId,
            ]);

            // --- District Options ---
            $districts = [545, 552, 536, 544, 547];
            foreach ($districts as $districtId) {
                $deal->dealDistrictOptions()->create([
                    'district_id' => $districtId,
                    'is_chosen'   => $districtId === 545 ? 1 : 0,
                ]);
            }

            // --- Partner Options ---
            for ($j = 1; $j <= 5; $j++) {
                $deal->dealPartnerOptions()->create([
                    'partner_id' => $j,
                    'is_chosen'  => $j === 1 ? 1 : 0,
                ]);
            }

            // --- Date Options ---
            $baseDate = now()->addWeek();
            for ($k = 0; $k < 5; $k++) {
                $deal->dealDateOptions()->create([
                    'date'      => $baseDate->copy()->addDays($k)->toDateString(),
                    'from'      => '19:00:00',
                    'to'        => '20:00:00',
                    'is_chosen' => $k === 0 ? 1 : 0,
                ]);
            }

            // --- Booking ---
            $bookingDate = $baseDate->toDateString();
            $booking = $deal->booking()->create([
                'code'           => $this->createCodeBooking(),
                'user_female_id' => $deal->user_female_id,
                'user_male_id'   => $deal->user_male_id,
                'partner_id'     => 1,
                'date'           => $bookingDate,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ]);

            Log::info("[Command] Tạo booking #{$booking->id} cho deal {$deal->id}");
        }

        Log::info('[Command] Hoàn tất tạo deal giả lập');

        return Command::SUCCESS;
    }

    /**
     * Lấy tất cả cặp userId từ 20 user đầu tiên.
     *
     * @return array<int, array{0:int,1:int}>
     */
    protected function generatePairs(): array
    {
        $ids = User::query()
            ->limit(20)
            ->pluck('id')
            ->toArray();

        $pairs = [];
        $count = count($ids);

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                // Guard: phòng trường hợp data ids có trùng (khó nhưng cứ check)
                if ($ids[$i] === $ids[$j]) {
                    continue;
                }
                $pairs[] = [$ids[$i], $ids[$j]];
            }
        }

        return $pairs;
    }

    /**
     * Random ra 1 cặp user chưa có matching.
     *
     * @return array{user1:User,user2:User}|null
     */
    protected function randomMatch(): ?array
    {
        while (!empty($this->pairs)) {
            $pair = array_pop($this->pairs);
            if (!$pair || count($pair) !== 2) {
                continue;
            }

            [$user1Id, $user2Id] = $pair;

            // Guard: không cho tự match chính mình
            if ($user1Id === $user2Id) {
                Log::warning("[Command] Bỏ qua cặp tự match {$user1Id} - {$user2Id}");
                continue;
            }

            $exists = Matching::query()
                ->where(function ($q) use ($user1Id, $user2Id) {
                    $q->where('user_id', $user1Id)
                      ->where('user_loved_id', $user2Id);
                })
                ->orWhere(function ($q) use ($user1Id, $user2Id) {
                    $q->where('user_id', $user2Id)
                      ->where('user_loved_id', $user1Id);
                })
                ->exists();

            if ($exists) {
                // Cặp này đã có matching, thử cặp khác
                continue;
            }

            Log::info("[Command] Tạo matching mới giữa user {$user1Id} và {$user2Id}");

            Matching::query()->insert([
                ['user_id' => $user1Id, 'user_loved_id' => $user2Id],
                ['user_id' => $user2Id, 'user_loved_id' => $user1Id],
            ]);

            $user1 = User::find($user1Id);
            $user2 = User::find($user2Id);

            if (!$user1 || !$user2) {
                Log::error("[Command] Không tìm thấy 1 trong 2 user {$user1Id}, {$user2Id} sau khi tạo matching.");
                return null;
            }

            return [
                'user1' => $user1,
                'user2' => $user2,
            ];
        }

        Log::warning('[Command] Không còn cặp user nào khả dụng để tạo matching');
        return null;
    }
}
