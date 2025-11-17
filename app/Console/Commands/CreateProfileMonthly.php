<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateProfileMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:monthly-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create profile_monthly for statistics by month.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now()->format('Y-m'); // VD: 2025-07

        $exists = DB::table('profile_monthly')->where('month', $now)->exists();

        if (!$exists) {
            DB::table('profile_monthly')->insert([
                'month' => $now,
                'total_profiles' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info("Đã tạo dòng mới trong profile_monthly cho tháng $now");
        } else {
            Log::info("Đã có dòng profile_monthly cho tháng $now, không tạo lại");
        }
    }
}
