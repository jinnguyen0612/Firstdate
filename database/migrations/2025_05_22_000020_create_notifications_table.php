<?php

use App\Enums\Notification\NotificationContactType;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Notification\NotificationType;
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->string('title');
            $table->longText('message');
            $table->text('short_message');
            $table->tinyInteger('status')->default(NotificationStatus::NOT_READ->value);
            $table->timestamp('read_at')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
