<?php

namespace App\Admin\Http\Requests\Partner;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class PartnerRequest extends BaseRequest
{
    protected function methodPost(): array
    {
        return [
            'email' => ['required', 'email', 'unique:App\Models\User,email'],
            'phone' => ['required', 'string', 'unique:App\Models\User,phone'],
            'password' => ['required', 'string', 'confirmed'],
            'name' => ['required', 'string'],
            'description' => ['nullable'],
            'address' => ['required'],
            'province' => ['required'],
            'district' => ['required'],
            'lat' => ['required'],
            'lng' => ['required'],
            'avatar' => ['nullable', 'string'],
            'gallery' => ['required'],
            'partner_category_id' => ['required', 'exists:App\Models\PartnerCategory,id'],
        ];
    }

    protected function methodPut(): array
    {
        $id = request()->route('id') ?? request()->get('id');

        return [
            'id' => ['required', 'exists:App\Models\Partner,id'],
            'partner_category_id' => ['required', 'exists:App\Models\PartnerCategory,id'],
            'name' => ['required', 'string'],
            'description' => ['nullable'],
            'address' => ['nullable'],
            'province' => ['nullable'],
            'district' => ['nullable'],
            'lat' => ['nullable'],
            'lng' => ['nullable'],
            'avatar' => ['nullable', 'string'],
            'gallery' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', Rule::unique('users', 'phone')->ignore($id)],
            'password' => ['nullable', 'string', 'confirmed'],
        ];
    }

    
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $gallery = $this->gallery;
            if ($gallery) {
                $galleryArray = explode(",", $gallery);
                if (count($galleryArray) < 3) {
                    $validator->errors()->add('gallery', 'Gallery phải chứa tối thiểu 3 phần tử.');
                }
            }
        });
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Fullname is required',
            'email.unique' => 'Email already exists',
            'phone.regex' => 'Phone number format is invalid',
            'gender.required' => 'Gender is required',
            'password.confirmed' => 'Password confirmation does not match',
            'active.required' => 'Active status is required',
        ];
    }
}