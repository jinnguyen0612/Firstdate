<?php

$enums = [
    'Education' => [
        'Bachelor' => 'Cử nhân',
        'UniversityStudent' => 'Sinh viên đại học',
        'HighSchool' => 'Trung học phổ thông',
        'Doctorate' => 'Tiến sĩ',
        'PostgraduateStudent' => 'Học viên sau đại học',
        'Master' => 'Thạc sĩ',
        'VocationalSchool' => 'Trường dạy nghề',
    ],
    'LookingFor' => [
        'Male' => 'Nam',
        'Female' => 'Nữ',
        'Both' => 'Cả hai',
    ],
    'ZodiacSign' => [
        'Aries' => 'Bạch Dương',
        'Taurus' => 'Kim Ngưu',
        'Gemini' => 'Song Tử',
        'Cancer' => 'Cự Giải',
        'Leo' => 'Sư Tử',
        'Virgo' => 'Xử Nữ',
        'Libra' => 'Thiên Bình',
        'Scorpio' => 'Bọ Cạp',
        'Sagittarius' => 'Nhân Mã',
        'Capricorn' => 'Ma Kết',
        'Aquarius' => 'Bảo Bình',
        'Pisces' => 'Song Ngư',
    ],
    'CommunicationStyle' => [
        'TextingAddict' => 'Nghiện nhắn tin',
        'CallLover' => 'Thích gọi điện',
        'VideoCallLover' => 'Thích gọi video',
        'RareTexter' => 'Ít nhắn tin',
        'InPersonLover' => 'Thích gặp mặt trực tiếp',
    ],
    'LoveLanguage' => [
        'ActsOfService' => 'Hành động phục vụ',
        'Gifts' => 'Quà tặng',
        'PhysicalTouch' => 'Tiếp xúc cơ thể',
        'WordsOfAffirmation' => 'Lời khẳng định',
        'QualityTime' => 'Thời gian chất lượng',
    ],
    'PetPreference' => [
        'Dog' => 'Chó',
        'Cat' => 'Mèo',
        'Reptile' => 'Bò sát',
        'Bird' => 'Chim',
        'Amphibian' => 'Lưỡng cư',
        'SmallAnimal' => 'Động vật nhỏ',
        'AquaticAnimal' => 'Động vật thủy sinh',
        'AllPets' => 'Tất cả thú cưng',
        'OtherPets' => 'Thú cưng khác',
        'LoveButNoPet' => 'Yêu thú cưng nhưng không nuôi',
        'NoPet' => 'Không nuôi thú cưng',
        'PetAllergy' => 'Dị ứng thú cưng',
    ],
    'AlcoholPreference' => [
        'NotForMe' => 'Không dành cho tôi',
        'AlwaysSober' => 'Luôn tỉnh táo',
        'ResponsibleDrinker' => 'Uống có trách nhiệm',
        'SpecialOccasions' => 'Dịp đặc biệt',
        'SocialDrinker' => 'Uống xã giao',
        'AlmostEveryNight' => 'Gần như mỗi đêm',
    ],
    'SmokingPreference' => [
        'SocialSmoker' => 'Hút thuốc xã giao',
        'PartySmoker' => 'Hút thuốc khi tiệc tùng',
        'NonSmoker' => 'Không hút thuốc',
        'RegularSmoker' => 'Hút thuốc thường xuyên',
        'TryingToQuit' => 'Đang cố gắng bỏ thuốc',
    ],
    'ExerciseHabit' => [
        'Daily' => 'Hàng ngày',
        'Regularly' => 'Thường xuyên',
        'Occasionally' => 'Thỉnh thoảng',
        'Never' => 'Không bao giờ',
    ],
    'EatingHabit' => [
        'Vegan' => 'Thuần chay',
        'Vegetarian' => 'Ăn chay',
        'Pescatarian' => 'Ăn cá',
        'MeatOnly' => 'Chỉ ăn thịt',
        'NoDiet' => 'Không ăn kiêng',
        'Kosher' => 'Kosher',
    ],
    'SleepingHabit' => [
        'EarlyBird' => 'Người dậy sớm',
        'NightOwl' => 'Cú đêm',
        'Flexible' => 'Linh hoạt',
    ],
];

$langDirPath = realpath(__DIR__ . '/../../lang/vi');
if ($langDirPath === false) {
    mkdir(__DIR__ . '/../../lang/vi', 0777, true);
    $langDirPath = realpath(__DIR__ . '/../../lang/vi');
}

$langFilePath = $langDirPath . '/enums.php';
if (!file_exists($langFilePath)) {
    file_put_contents($langFilePath, "<?php\n\nreturn [];\n");
}

$langFileContent = file_get_contents($langFilePath);

// Find the return array in the lang file
$pattern = '/return\s*\[(.*?)\];/s';
preg_match($pattern, $langFileContent, $matches);
$existingEnums = eval('return ' . $matches[0] . ';');

// Merge new enums with existing enums
foreach ($enums as $enumName => $values) {
    $enumClass = "App\\Enums\\User\\$enumName";
    if (!isset($existingEnums[$enumClass])) {
        $existingEnums[$enumClass] = [];
    }
    foreach ($values as $key => $value) {
        $existingEnums[$enumClass][$key] = $value;
    }
}

// Convert the merged enums back to PHP code
$updatedEnumsContent = "<?php\n\nreturn [\n";
foreach ($existingEnums as $enumClass => $values) {
    $updatedEnumsContent .= "    $enumClass::class => [\n";
    foreach ($values as $key => $value) {
        $updatedEnumsContent .= "        $key => '$value',\n";
    }
    $updatedEnumsContent .= "    ],\n";
}
$updatedEnumsContent .= "];\n";

// Write the updated content back to the lang file
file_put_contents($langFilePath, $updatedEnumsContent);

echo "Updated $langFilePath\n";
