<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'subject' => 'required|in:استفسار,شكوى,اقتراح',
            'message' => 'required|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'أدخل بريداً إلكترونياً صحيحاً',
            'subject.required' => 'نوع الرسالة مطلوب',
            'subject.in' => 'نوع الرسالة غير صحيح',
            'message.required' => 'نص الرسالة مطلوب',
        ];
    }
}
