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
        Schema::create('deal_partner_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained('deals')->onDelete('cascade');
            $table->foreignId('partner_id')->constrained('partners')->onDelete('cascade');
            $table->boolean('is_chosen')->default(0);
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
        Schema::dropIfExists('deal_partner_options');
    }
};
