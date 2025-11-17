<?php

namespace App\Api\V1\Http\Requests\Deal;

use App\Api\V1\Http\Requests\BaseRequest;
use Carbon\Carbon;

class ChooseDateOptionsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'id' => ['required', 'exists:App\Models\Deal,id'],
            'dates' => ['required', 'array'],
            'dates.*.date' => ['required'],
            'dates.*.from' => ['required'],
            'dates.*.to' => ['required'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $dates = $this->input('dates');

            if (!is_array($dates) || count($dates) != 5) {
                $validator->errors()->add("dates", "Số lượng ngày chọn phải là 5.");
                return; // không cần kiểm tiếp nếu sai cấu trúc
            }

            $now   = Carbon::now();                  // thời điểm hiện tại
            $today = $now->copy()->startOfDay();     // 00:00 hôm nay
            $noon  = $today->copy()->setTime(12, 0); // 12:00 hôm nay
            $five  = $today->copy()->setTime(17, 0); // 17:00 hôm nay

            foreach ($dates as $index => $item) {
                try {
                    // Parse ngày (không kèm giờ)
                    $selectedDate = Carbon::parse(data_get($item, 'date'))->startOfDay();
                } catch (\Exception $e) {
                    $validator->errors()->add("dates.$index.date", "Ngày không hợp lệ.");
                    continue;
                }

                // 1) Không cho phép ngày quá khứ
                if ($selectedDate->lt($today)) {
                    $validator->errors()->add("dates.$index.date", "Chỉ được chọn ngày từ hôm nay trở đi.");
                    continue;
                }

                // 2) Xử lý riêng ngày hôm nay
                if ($selectedDate->equalTo($today)) {
                    // Nếu sau/đúng 12h trưa thì không cho chọn hôm nay
                    if ($now->greaterThanOrEqualTo($noon)) {
                        $validator->errors()->add("dates.$index.date", "Sau 12:00 trưa, không được chọn ngày hôm nay.");
                        continue;
                    }

                    // Trước 12h trưa: bắt buộc 'from' >= 17:00
                    $fromStr = data_get($item, 'from');
                    if (empty($fromStr)) {
                        $validator->errors()->add("dates.$index.from", "Vui lòng nhập giờ bắt đầu ('from') từ 17:00 trở đi cho ngày hôm nay.");
                        continue;
                    }

                    try {
                        // Parse giờ 'from' và gắn vào ngày đã chọn
                        $fromTime = Carbon::parse($fromStr);
                        $fromDateTime = $selectedDate->copy()->setTime($fromTime->hour, $fromTime->minute, $fromTime->second);

                        if ($fromDateTime->lt($five)) {
                            $validator->errors()->add("dates.$index.from", "Giờ bắt đầu ('from') cho hôm nay phải từ 17:00 trở đi.");
                        }
                    } catch (\Exception $e) {
                        $validator->errors()->add("dates.$index.from", "Giờ bắt đầu ('from') không hợp lệ.");
                    }

                    continue;
                }

                // 3) Ngày lớn hơn hôm nay thì hợp lệ (không cần ràng buộc 17:00)
                // Nếu bạn vẫn muốn cấm hôm nay hoàn toàn (ngoại lệ 12h), có thể thêm check khác ở đây.
            }
        });
    }
}
