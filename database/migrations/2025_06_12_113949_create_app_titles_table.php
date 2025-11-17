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
        Schema::create('app_titles', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name')->nullable();
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        DB::table('app_titles')->insert([
            ['key'=> 'home', 'name' => 'Tiêu đề trang chủ', 'value' => ''],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_titles');
    }
};
