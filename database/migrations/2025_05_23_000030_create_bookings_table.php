<?php

use App\Enums\Booking\BookingStatus;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('user_female_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_male_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('partner_id')->constrained('partners')->onDelete('cascade');
            $table->foreignId('deal_id')->constrained('deals')->onDelete('set null');
            $table->foreignId('partner_table_id')->constrained('partner_tables')->onDelete('set null');

            $table->date('date')->nullable();
            $table->time('time')->nullable();

            $table->enum('status', [
                BookingStatus::Pending->value,      
                BookingStatus::Confirmed->value,
                BookingStatus::Processing->value,
                BookingStatus::Cancelled->value,
                BookingStatus::Completed->value
            ])->default(BookingStatus::Pending->value);

            $table->text('note')->nullable();

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
        Schema::dropIfExists('bookings');
    }
};
