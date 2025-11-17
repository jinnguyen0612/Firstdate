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
        Schema::create('app_categories', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->string('title');
            $table->string('field_name');
            $table->string('variable');
            $table->tinyInteger('is_show')->default(0);
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
        Schema::dropIfExists('app_categories');
    }
};
