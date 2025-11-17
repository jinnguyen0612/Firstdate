<?php

use App\Enums\Booking\BookingAttendanceType;
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
        Schema::create('booking_attendance', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->enum('type', [BookingAttendanceType::Late->value,
                                    BookingAttendanceType::Absent->value,
                                    BookingAttendanceType::Attended->value])->default(BookingAttendanceType::Attended->value);
            
            
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
        Schema::dropIfExists('booking_attendance');
    }
};
