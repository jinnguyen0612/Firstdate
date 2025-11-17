<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResetRerollUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:reset-reroll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset reroll back 5 for user if smaller than 5';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('users')
        ->where('reroll', '<', 5)
        ->update(['reroll' => 5]);

        Log::info('[Schedule] Reset reroll về 5 lúc: ' . now());

        return Command::SUCCESS;
    }
}
