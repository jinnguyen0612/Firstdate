<?php

namespace App\Console\Commands;

use App\Enums\User\Gender;
use App\Enums\User\LookingFor;
use App\Enums\User\Relationship;
use App\Enums\User\ZodiacSign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

class GenerateFakeUsersCommand extends Command
{
    protected $signature = 'users:generate {count=1}';
    protected $description = 'Tạo user giả lập để test hệ thống';

    public function handle()
    {
        $faker = Faker::create('vi_VN');
        $count = (int) $this->argument('count');

        for ($i = 0; $i < $count; $i++) {
            $genderEnum = $faker->randomElement([Gender::Male, Gender::Female]);
            $genderValue = $genderEnum->value;
            $birthday = $faker->dateTimeBetween('-28 years', '-18 years')->format('Y-m-d');
            $zodiac = ZodiacSign::getZodiacSign($birthday)?->value;
            $lookingFor = collect(LookingFor::cases())->random()->value;

            $malePath = public_path('assets/images/demo/male/');
            $maleNumFile = 16;
            $female = public_path('assets/images/demo/female/');
            $femaleNumFile = 9;

            if ($genderEnum === Gender::Male) {
                $fileNumber = rand(1, $maleNumFile);
                $avatarPath = $malePath . $fileNumber . '.jpg';
            } else {
                $fileNumber = rand(1, $femaleNumFile);
                $avatarPath = $female . $fileNumber . '.jpg';
            }

            // Kiểm tra file tồn tại, nếu không thì set null
            if (!File::exists($avatarPath)) {
                $avatarPath = null;
            }


            $multipart = [
                ['name' => 'fullname', 'contents' => $faker->lastName . ' ' . $faker->firstName($genderEnum === Gender::Male ? 'male' : 'female')],
                ['name' => 'gender', 'contents' => $genderValue],
                ['name' => 'birthday', 'contents' => $birthday],
                ['name' => 'zodiac_sign', 'contents' => $zodiac],
                ['name' => 'province_id', 'contents' => 50],
                ['name' => 'district_id', 'contents' => rand(536, 557)],
                ['name' => 'lat', 'contents' => $faker->latitude(10.7, 11)],
                ['name' => 'lng', 'contents' => $faker->longitude(106.6, 106.8)],
                ['name' => 'max_age_find', 'contents' => rand(24, 32)],
                ['name' => 'looking_for', 'contents' => $lookingFor],
                ['name' => 'email', 'contents' => $faker->unique()->safeEmail],
                ['name' => 'phone', 'contents' => '09' . rand(10000000, 99999999)],
                ['name' => 'is_hide', 'contents' => 0],
                ['name' => 'is_subsidy_offer', 'contents' => 1],
            ];

            // Các field array
            foreach ([Relationship::SeriousDating->value, Relationship::LookingForFriends->value] as $item) {
                $multipart[] = ['name' => 'relationship[]', 'contents' => $item];
            }
            foreach ([14, 19, 24, 27, 30] as $item) {
                $multipart[] = ['name' => 'answer[]', 'contents' => $item];
            }
            foreach (['08:00-12:00', '19:00-22:00'] as $item) {
                $multipart[] = ['name' => 'dating_time[]', 'contents' => $item];
            }

            // Random thumbnails
            $thumbnailCount = rand(2, 4); // số lượng ảnh thumbnails muốn random
            for ($j = 0; $j < $thumbnailCount; $j++) {
                if ($genderEnum === Gender::Male) {
                    $fileNumber = rand(1, $maleNumFile);
                    $thumbPath = $malePath . $fileNumber . '.jpg';
                } else {
                    $fileNumber = rand(1, $femaleNumFile);
                    $thumbPath = $female . $fileNumber . '.jpg';
                }

                if (File::exists($thumbPath)) {
                    $multipart[] = [
                        'name' => 'thumbnails[]',
                        'contents' => fopen($thumbPath, 'r'),
                        'filename' => basename($thumbPath),
                    ];
                }
            }


            // Gắn avatar nếu có
            if ($avatarPath) {
                $multipart[] = [
                    'name' => 'avatar',
                    'contents' => fopen($avatarPath, 'r'),
                    'filename' => basename($avatarPath),
                ];
            }

            // Gửi HTTP POST như client thật
            $response = Http::asMultipart()
                ->post('http://localhost:8080/3131-Firstdate/api/v1/users/register', $multipart);

            $body = $response->json();
            Log::info('Message: ' . json_encode($body));
        }
    }
}
