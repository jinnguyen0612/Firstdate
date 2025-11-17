<?php

use App\Enums\Process\ProcessStatus;
use App\Enums\Process\ProcessType;
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
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [ProcessType::PayDeposit->value,
                                    ProcessType::MakeDeal->value])->default(ProcessType::MakeDeal->value);

            $table->foreignId('deal_id')->constrained('deals')->onDelete('cascade');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->enum('status',[ProcessStatus::Running->value, 
                                    ProcessStatus::Hold->value, 
                                    ProcessStatus::Cancelled->value, 
                                    ProcessStatus::Done->value])->default(ProcessStatus::Running->value); // running, hold, cancelled, done

            $table->unsignedTinyInteger('sent_count')->default(0);
            $table->timestamp('next_send_at');

            $table->string('title')->nullable();
            $table->string('key')->nullable();

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
        Schema::dropIfExists('processes');
    }
};
