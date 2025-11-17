<?php

use App\Enums\Booking\BookingDeposit;
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
        Schema::create('booking_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->decimal('amount', 15, 2);
            $table->enum('status', [BookingDeposit::Pending->value, //chi khi chuyen khoan truc tiep ve QR he thong
                                    BookingDeposit::Paid->value,
                                    BookingDeposit::Refunded->value,
                                    BookingDeposit::Forfeited->value])
                    ->default(BookingDeposit::Pending->value);

            $table->dateTime('paid_at')->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->decimal('refunded_amount', 15, 2)->nullable();
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
        Schema::dropIfExists('booking_deposits');
    }
};
