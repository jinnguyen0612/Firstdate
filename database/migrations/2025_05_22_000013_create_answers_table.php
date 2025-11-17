<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->text('answer')->nullable();
            $table->timestamps();
        });
        DB::table('questions')->insert([
            ['id'=> 1, 'content' => 'Nghề nghiệp hiện tại của bạn là gì?', 'is_required' => 1],
            ['id'=> 2, 'content' => 'Mức thu nhập trung bình hàng tháng của bạn?', 'is_required' => 0],
            ['id'=> 3, 'content' => 'Bạn thường sử dụng thiết bị nào để truy cập internet?', 'is_required' => 1],
            ['id'=> 4, 'content' => 'Bạn quan tâm đến lĩnh vực nào nhiều nhất?', 'is_required' => 1],
            ['id'=> 5, 'content' => 'Mức độ sẵn sàng chia sẻ thông tin cá nhân để được cá nhân hóa trải nghiệm là?', 'is_required' => 0],
            ['id'=> 6, 'content' => 'Bạn mô tả tính cách bản thân như thế nào?', 'is_required' => 0],
            ['id'=> 7, 'content' => 'Bạn thích kiểu hẹn hò nào nhất?', 'is_required' => 0],
        ]);
        DB::table('answers')->insert([
            ['question_id' => 1, 'answer' => 'Học sinh/Sinh viên'],
            ['question_id' => 1, 'answer' => 'Nhân viên văn phòng'],
            ['question_id' => 1, 'answer' => 'Tự doanh/Kinh doanh'],
            ['question_id' => 1, 'answer' => 'Nội trợ'],
            ['question_id' => 1, 'answer' => 'Khác'],
            ['question_id' => 2, 'answer' => 'Dưới 5 triệu VNĐ'],
            ['question_id' => 2, 'answer' => '5 – 10 triệu VNĐ'],
            ['question_id' => 2, 'answer' => '10 – 20 triệu VNĐ'],
            ['question_id' => 2, 'answer' => 'Trên 20 triệu VNĐ'],
            ['question_id' => 2, 'answer' => 'Không muốn tiết lộ'],
            ['question_id' => 3, 'answer' => 'Điện thoại di động'],
            ['question_id' => 3, 'answer' => 'Máy tính cá nhân/laptop'],
            ['question_id' => 3, 'answer' => 'Máy tính bảng'],
            ['question_id' => 3, 'answer' => 'Khác'],
            ['question_id' => 4, 'answer' => 'Công nghệ'],
            ['question_id' => 4, 'answer' => 'Thời trang/Làm đẹp'],
            ['question_id' => 4, 'answer' => 'Sức khỏe/Thể thao'],
            ['question_id' => 4, 'answer' => 'Giáo dục'],
            ['question_id' => 4, 'answer' => 'Giải trí/Phim ảnh'],
            ['question_id' => 4, 'answer' => 'Khác'],
            ['question_id' => 5, 'answer' => 'Rất sẵn sàng'],
            ['question_id' => 5, 'answer' => 'Có thể, nếu biết rõ mục đích'],
            ['question_id' => 5, 'answer' => 'Không sẵn sàng'],
            ['question_id' => 5, 'answer' => 'Phụ thuộc vào tình huống'],
            ['question_id' => 6, 'answer' => 'Hướng nội – trầm tính'],
            ['question_id' => 6, 'answer' => 'Hướng ngoại – năng động'],
            ['question_id' => 6, 'answer' => 'Lãng mạn – cảm xúc'],
            ['question_id' => 6, 'answer' => 'Hài hước – vui vẻ'],
            ['question_id' => 7, 'answer' => 'Uống cà phê, trò chuyện'],
            ['question_id' => 7, 'answer' => 'Đi xem phim hoặc sự kiện'],
            ['question_id' => 7, 'answer' => 'Dã ngoại, du lịch'],
            ['question_id' => 7, 'answer' => 'Ăn tối sang trọng'],
            ['question_id' => 7, 'answer' => 'Khác'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
