<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_monthly', function (Blueprint $table) {
            $table->id();
            $table->string('month', 7); // dạng '2025-07'
            $table->unsignedInteger('total_profiles')->default(0);
            $table->timestamps();

            $table->unique('month');
        });

        DB::table('profile_monthly')->insert([
            ['month' => '2025-07', 'total_profiles' => 0],
        ]);
        DB::table('profile_monthly')->insert([
            ['month' => '2025-08', 'total_profiles' => 0],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_monthly');
    }
};
