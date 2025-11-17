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
        Schema::create('price_list', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->integer('value');
            $table->timestamps();
        });

        DB::table('price_list')->insert([
            [
                'price' => 56000,
                'value' => 50
            ],
            [
                'price' => 120000,
                'value' => 100
            ],
            [
                'price' => 230000,
                'value' => 200
            ],
            [
                'price' => 570000,
                'value' => 500
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_list');
    }
};
