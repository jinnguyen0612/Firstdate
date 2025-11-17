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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('code', 50);

            //Thông tin cá nhân
            $table->string('fullname');
            $table->tinyInteger('gender');
            $table->date('birthday')->nullable();
            $table->enum('zodiac_sign', [ZodiacSign::Aries->value, 
                                        ZodiacSign::Taurus->value, 
                                        ZodiacSign::Gemini->value, 
                                        ZodiacSign::Cancer->value, 
                                        ZodiacSign::Leo->value, 
                                        ZodiacSign::Virgo->value, 
                                        ZodiacSign::Libra->value, 
                                        ZodiacSign::Scorpio->value, 
                                        ZodiacSign::Sagittarius->value, 
                                        ZodiacSign::Capricorn->value, 
                                        ZodiacSign::Aquarius->value, 
                                        ZodiacSign::Pisces->value])
                    ->default(ZodiacSign::Aries->value);

            $table->string("bank_name")->nullable(); // Tên ngân hàng
            $table->string("bank_acc_name")->nullable(); // Tên chủ tài khoản
            $table->string("bank_acc_number")->nullable(); // Số tài khoản

            $table->char('pin',6)->nullable();
            
            $table->tinyInteger('reroll')->default(5);

            //Vị trí hẹn hò
            $table->foreignId('province_id')->constrained('provinces')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade');
            $table->double('lat', 10, 6)->nullable();
            $table->double('lng', 10, 6)->nullable();
            //Đối tượng tìm kiếm
            $table->unsignedTinyInteger('max_age_find')->nullable();
            $table->enum('looking_for', [LookingFor::Male->value, 
                                        LookingFor::Female->value, 
                                        LookingFor::Both->value]);     

            $table->text('avatar')->nullable();
            $table->longText('thumbnails')->nullable(); //Max 9
            $table->text('description')->nullable();
            
            //Thanh toan
            $table->decimal('wallet', 15, 2)->default(0);
            
            //Tai Khoan
            $table->string('email')->unique()->nullable();
            $table->char('phone', 20)->unique()->nullable();

            $table->boolean('is_hide')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_subsidy_offer')->default(0); // có trợ cấp hay không?
            $table->rememberToken();
            
            //KHÔNG CÓ PASSWORD ĐĂNG NHẬP BẰNG OTP
            
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
        Schema::dropIfExists('users');
    }
};
