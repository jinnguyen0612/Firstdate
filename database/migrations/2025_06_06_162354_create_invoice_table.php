<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');

            $table->text('invoice')->nullable(); //Ảnh hóa đơn

            $table->double('total'); //Lưu số tiền hóa đơn
            $table->double('profit_split'); //Lưu số tiền chiết khấu cho hệ thống
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
};
