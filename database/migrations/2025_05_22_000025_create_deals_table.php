<?php

use App\Enums\Deal\DealStatus;
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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_female_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_male_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', [DealStatus::Pending->value, 
                                    DealStatus::Confirmed->value, 
                                    DealStatus::Cancelled->value, 
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
        Schema::dropIfExists('deals');
    }
};
