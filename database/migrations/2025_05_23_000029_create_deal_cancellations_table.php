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
        Schema::create('deal_cancellations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('deal_id')->constrained('deals')->onDelete('cascade');
            $table->foreignId('canceled_by')->constrained('users')->onDelete('cascade');

            $table->dateTime('canceled_at');
            $table->text('reason')->nullable();
            
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
        Schema::dropIfExists('deal_cancellations');
    }
};
