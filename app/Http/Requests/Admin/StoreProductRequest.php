<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'barcode' => 'nullable|string|max:255|unique:products,barcode',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'wholesale_price' => 'nullable|numeric|min:0',
            
            'stock_quantity' => 'nullable|integer|min:0',
            'min_order_quantity' => 'nullable|integer|min:1',
            
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            
            'category_id' => 'nullable|exists:categories,id',
            
            'status' => 'required|in:active,inactive,draft',
            'featured' => 'nullable|boolean',
            
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            
            // Colors
            'colors' => 'nullable|array',
            'colors.*.name' => 'nullable|string|max:255',
            'colors.*.hex_code' => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'colors.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            
            // Sizes
            'sizes' => 'nullable|array',
            'sizes.*.name' => 'nullable|string|max:255',
            'sizes.*.order' => 'nullable|integer|min:0',
            
            // Variants
            'variants' => 'nullable|array',
            'variants.*.color_id' => 'nullable|exists:product_colors,id',
            'variants.*.size_id' => 'nullable|exists:product_sizes,id',
            'variants.*.sku' => 'nullable|string|max:255',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.sale_price' => 'nullable|numeric|min:0',
            'variants.*.stock_quantity' => 'nullable|integer|min:0',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم المنتج مطلوب',
            'name.max' => 'اسم المنتج يجب أن يكون أقل من 255 حرف',
            'slug.unique' => 'الرابط مستخدم بالفعل',
            'sku.unique' => 'رمز المنتج مستخدم بالفعل',
            'barcode.unique' => 'الباركود مستخدم بالفعل',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقماً',
            'price.min' => 'السعر يجب أن يكون أكبر من أو يساوي 0',
            'sale_price.lt' => 'سعر التخفيض يجب أن يكون أقل من السعر الأساسي',
            'category_id.exists' => 'التصنيف المحدد غير موجود',
            'status.required' => 'حالة المنتج مطلوبة',
            'status.in' => 'حالة المنتج غير صحيحة',
            'main_image.image' => 'يجب أن يكون الملف صورة',
            'main_image.mimes' => 'نوع الصورة غير مدعوم. يجب أن يكون: jpeg, png, jpg, gif, webp',
            'main_image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
            'images.*.image' => 'يجب أن يكون الملف صورة',
            'images.*.mimes' => 'نوع الصورة غير مدعوم',
            'images.*.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
            'colors.*.hex_code.regex' => 'كود اللون غير صحيح (يجب أن يكون بصيغة #RRGGBB)',
        ];
    }
}
