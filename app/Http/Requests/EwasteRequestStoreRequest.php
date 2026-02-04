<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EwasteRequestStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $wasteTypeKeys = array_keys(\App\Models\EwasteRequest::WASTE_TYPES);

        return [
            'request_type' => 'required|in:donation,collection,campaign',
            'request_date' => 'required|date',
            'entity_type' => 'required|in:individual,education,company,local_org,intl_org,government,other',
            'entity_name' => 'required|string|max:255',
            'responsible_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'accessibility' => 'required|in:easy,needs_coordination,hard',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'altitude' => 'nullable|numeric',
            'accuracy' => 'nullable|numeric',
            'waste_types' => 'required|array|min:1',
            'waste_types.*' => 'in:' . implode(',', $wasteTypeKeys),
            'device_count' => 'required|integer|min:1',
            'device_condition' => 'required|in:working,broken,mixed',
            'has_personal_data' => 'required|in:yes,no,unknown',
            'delivery_method' => 'required|in:self_deliver,need_pickup',
            'suggested_date' => 'nullable|date',
            'images' => 'nullable|array|max:2',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'notes' => 'nullable|string|max:2000',
            'consent' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'request_type.required' => 'نوع الطلب مطلوب',
            'request_date.required' => 'التاريخ مطلوب',
            'entity_type.required' => 'نوع الجهة مطلوب',
            'entity_name.required' => 'اسم الشخص أو الجهة مطلوب',
            'responsible_name.required' => 'اسم الشخص المسؤول مطلوب',
            'phone.required' => 'رقم الهاتف مطلوب',
            'city.required' => 'المدينة مطلوبة',
            'district.required' => 'الحي / المنطقة مطلوب',
            'address.required' => 'العنوان التقريبي مطلوب',
            'accessibility.required' => 'هل الموقع سهل الوصول مطلوب',
            'waste_types.required' => 'يجب اختيار نوع واحد على الأقل من النفايات',
            'device_count.required' => 'العدد التقريبي للأجهزة مطلوب',
            'device_condition.required' => 'حالة الأجهزة مطلوبة',
            'has_personal_data.required' => 'هل تحتوي الأجهزة على بيانات شخصية مطلوب',
            'delivery_method.required' => 'طريقة التعامل مع النفايات مطلوبة',
            'consent.required' => 'يجب الموافقة على الإقرار',
            'consent.accepted' => 'يجب الموافقة على الإقرار',
        ];
    }
}
