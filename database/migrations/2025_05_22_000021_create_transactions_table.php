<?php

use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->char('code', 50);
            $table->nullableMorphs('from'); // from_type, from_id
            $table->nullableMorphs('to');   // to_type, to_id

            $table->string('from_name')->nullable();
            $table->string('to_name')->nullable();

            $table->decimal('amount', 15, 2);
            
            $table->enum('type', [TransactionType::Send->value, 
                                TransactionType::Receive->value, 
                                TransactionType::Deposit->value, 
                                TransactionType::Withdraw->value, 
                                TransactionType::Payment->value, 
                                TransactionType::Refund->value]);
            $table->enum('status', [TransactionStatus::Pending->value,
                                    TransactionStatus::Success->value,
                                    TransactionStatus::Failed->value])
                    ->default(TransactionStatus::Pending->value);

            $table->text('image')->nullable(); //chi danh cho nap

            $table->text('description')->nullable();
            $table->text('payos_order_code')->nullable();

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
        Schema::dropIfExists('transactions');
    }
};
