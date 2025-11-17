<?php

namespace App\Enums\User;

use App\Supports\Enum;
use Carbon\Carbon;

enum ZodiacSign: string
{
    use Enum;
    case Aries = 'aries';
    case Taurus = 'taurus';
    case Gemini = 'gemini';
    case Cancer = 'cancer';
    case Leo = 'leo';
    case Virgo = 'virgo';
    case Libra = 'libra';
    case Scorpio = 'scorpio';
    case Sagittarius = 'sagittarius';
    case Capricorn = 'capricorn';
    case Aquarius = 'aquarius';
    case Pisces = 'pisces';

    public function date(): array
    {
        return match($this) {
            self::Aries => [3, 21, 4, 20],       // Bạch Dương: 21/3 - 20/4
            self::Taurus => [4, 21, 5, 20],      // Kim Ngưu: 21/4 - 20/5
            self::Gemini => [5, 21, 6, 21],      // Song Tử: 21/5 - 21/6
            self::Cancer => [6, 22, 7, 22],      // Cự Giải: 22/6 - 22/7
            self::Leo => [7, 23, 8, 22],         // Sư Tử: 23/7 - 22/8
            self::Virgo => [8, 23, 9, 22],       // Xử Nữ: 23/8 - 22/9
            self::Libra => [9, 23, 10, 23],      // Thiên Bình: 23/9 - 23/10
            self::Scorpio => [10, 24, 11, 22],   // Bọ Cạp: 24/10 - 22/11
            self::Sagittarius => [11, 23, 12, 21], // Nhân Mã: 23/11 - 21/12
            self::Capricorn => [12, 22, 1, 19],  // Ma Kết: 22/12 - 19/1
            self::Aquarius => [1, 20, 2, 18],    // Bảo Bình: 20/1 - 18/2
            self::Pisces => [2, 19, 3, 20],      // Song Ngư: 19/2 - 20/3
        };
    }

    public static function getZodiacSign(string $date): ?self
    {
        try {
            $carbonDate = Carbon::createFromFormat('Y-m-d', $date);
            $month = $carbonDate->month;
            $day = $carbonDate->day;

            foreach (self::cases() as $zodiac) {
                [$startMonth, $startDay, $endMonth, $endDay] = $zodiac->date();

                if ($startMonth > $endMonth) {
                    if (
                        ($month === $startMonth && $day >= $startDay) ||
                        ($month === $endMonth && $day <= $endDay) ||
                        ($month > $startMonth || $month < $endMonth)
                    ) {
                        return $zodiac;
                    }
                } else {
                    if (
                        ($month === $startMonth && $day >= $startDay) ||
                        ($month === $endMonth && $day <= $endDay) ||
                        ($month > $startMonth && $month < $endMonth)
                    ) {
                        return $zodiac;
                    }
                }
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

}
