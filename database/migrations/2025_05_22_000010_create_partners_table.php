<?php

use App\Enums\User\LookingFor;
use App\Enums\User\ZodiacSign;
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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            //Tai khoan
            $table->string('email')->unique()->nullable();
            $table->char('phone', 20)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('device_token_updated_at')->nullable();
            $table->text('device_token')->nullable();
            $table->rememberToken();
            //Thong tin
            $table->string('name')->nullable();
            $table->text('avatar')->nullable();
            $table->longText('gallery')->nullable();
            $table->text('description')->nullable();

            //Thong tin ngan hang
            $table->string("bank_name")->nullable(); // Tên ngân hàng
            $table->string("bank_acc_name")->nullable(); // Tên chủ tài khoản
            $table->string("bank_acc_number")->nullable(); // Số tài khoản

            //Thanh toan
            $table->decimal('wallet', 15, 2)->default(0);
            //Dia chi
            $table->text('address')->nullable();
            $table->foreignId('province_id')->constrained('provinces')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade');
            $table->double('lat', 10, 6)->nullable();
            $table->double('lng', 10, 6)->nullable();

            $table->unsignedBigInteger('partner_category_id')->nullable();
            $table->foreign('partner_category_id')
                ->references('id')
                ->on('partner_categories')
                ->onDelete('set null');
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('partners');
    }
};
