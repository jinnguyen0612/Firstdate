<?php

namespace App\Admin\Http\Requests\Notification;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Notification\NotificationObject;
use Illuminate\Validation\Rule;

class NotificationRequest extends BaseRequest
{
    protected function methodPost(): array
    {
        return [
            'title' => ['required', 'string'],
            'notification_object' => ['required', Rule::enum(NotificationObject::class)],
            'short_message' => ['required', 'string'],
            'message' => ['required'],
            'image' => ['nullable', 'string'],
            'user_ids' => ['nullable', 'array'],
            'user_ids.*' => ['nullable', 'exists:App\Models\User,id'],
            'partner_ids' => ['nullable', 'array'],
            'partner_ids.*' => ['nullable', 'exists:App\Models\Partner,id'],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Notification,id'],
            'title' => ['required', 'string'],
            'short_message' => ['required'],
            'message' => ['required'],
            'image' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Yêu cầu nhập Tiêu đề',
            'short_message.required' => 'Yêu cầu nhập Mô tả ngắn',
            'message.required' => 'Yêu cầu nhập Nội dung',
        ];
    }
}
