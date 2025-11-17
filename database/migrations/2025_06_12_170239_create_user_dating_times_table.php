<?php

use App\Enums\User\DatingTime;
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
        Schema::create('user_dating_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('dating_time', [DatingTime::From8To12->value, 
                                        DatingTime::From12To16->value, 
                                        DatingTime::From16To19->value, 
                                        DatingTime::From19To22->value, 
                                        DatingTime::After22->value, 
                                        ]);
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
        Schema::dropIfExists('user_dating_times');
    }
};
