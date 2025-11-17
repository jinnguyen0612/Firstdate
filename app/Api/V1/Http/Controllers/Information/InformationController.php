<?php

namespace App\Api\V1\Http\Controllers\Information;

use App\Admin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\V1\Repositories\Information\InformationRepositoryInterface;
use App\Enums\User\AlcoholPreference;
use App\Enums\User\CommunicationStyle;
use App\Enums\User\DatingTime;
use App\Enums\User\EatingHabit;
use App\Enums\User\Education;
use App\Enums\User\ExerciseHabit;
use App\Enums\User\LookingFor;
use App\Enums\User\LoveLanguage;
use App\Enums\User\PetPreference;
use App\Enums\User\Relationship;
use App\Enums\User\SleepingHabit;
use App\Enums\User\SmokingPreference;
use App\Enums\User\ZodiacSign;

/**
 * @group Thông tin
 */

class InformationController extends Controller
{
    /**
     * DS Về Thời gian hẹn hò
     *
     * Lấy danh sách các về Thời gian hẹn hò
     * 
     * @response 200 {
     *       "status": 200,
     *       "message": "Thực hiện thành công.",
     *       "data": {
     *           "08:00-12:00": "08:00 - 12:00",
     *           "12:00-16:00": "12:00 - 16:00",
     *           "16:00-19:00": "16:00 - 19:00",
     *           "19:00-22:00": "19:00 - 22:00",
     *           "After22:00": "Sau 22:00"
     *       }
     * }
	   * @response 400 {
     *      "status": 400,
     *      "message": "Thực hiện thất bại."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function datingTime(){
      try {
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => DatingTime::asSelectArray()
        ]);
      } catch (\Exception $e) {
        // Xử lý ngoại lệ nếu cần thiết
        return response()->json([
          'status' => 400,
          'message' => __('Thực hiện thất bại.')
        ], 400);
      }
    }
    
    /**
     * DS Về Đối tượng tìm kiếm
     *
     * Lấy danh sách các về Đối tượng tìm kiếm
     * 
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "aries": "Aries",
     *         "taurus": "Taurus",
     *         "gemini": "Gemini",
     *         "cancer": "Cancer",
     *         "leo": "Leo",
     *         "virgo": "Virgo",
     *         "libra": "Libra",
     *         "scorpio": "Scorpio",
     *         "sagittarius": "Sagittarius",
     *         "capricorn": "Capricorn",
     *         "aquarius": "Aquarius",
     *         "pisces": "Pisces"
     *     }
     * }
	   * @response 400 {
     *      "status": 400,
     *      "message": "Thực hiện thất bại."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function lookingFor(){
      try {
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => LookingFor::asSelectArray()
        ]);
      } catch (\Exception $e) {
        // Xử lý ngoại lệ nếu cần thiết
        return response()->json([
          'status' => 400,
          'message' => __('Thực hiện thất bại.')
        ],400);
      }
    }

    /**
     * DS Về Cung hoàng đạo
     *
     * Lấy danh sách các về Cung hoàng đạo
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *         {
     *               "value": 1,
     *               "label": "Không dành cho tôi"
     *         }
     *      ]
     * }
	   * @response 400 {
     *      "status": 400,
     *      "message": "Thực hiện thất bại."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function ZodiacSign(){
      try {
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => ZodiacSign::asSelectArray()
        ]);
      } catch (\Exception $e) {
        // Xử lý ngoại lệ nếu cần thiết
        return response()->json([
          'status' => 400,
          'message' => __('Thực hiện thất bại.')
        ],400);
      }
    }
 
    /**
     * DS Về Mối quan hệ tìm kiếm
     *
     * Lấy danh sách các về Mối quan hệ tìm kiếm
     * 
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": {
     *         "serious_dating": "Hẹn hò nghiêm túc",
     *         "casual_dating": "Hẹn hò vui vẻ",
     *         "looking_for_friends": "Tìm bạn bè"
     *     }
     * }
	   * @response 400 {
     *      "status": 400,
     *      "message": "Thực hiện thất bại."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function relationship(){
      try {
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => Relationship::asSelectArray()
        ]);
      } catch (\Exception $e) {
        // Xử lý ngoại lệ nếu cần thiết
        return response()->json([
          'status' => 400,
          'message' => __('Thực hiện thất bại.')
        ],400);
      }
    }
}