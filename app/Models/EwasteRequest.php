<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EwasteRequest extends Model
{
    use HasFactory;

    const REQUEST_TYPES = [
        'donation' => 'تبرع بنفايات إلكترونية',
        'collection' => 'طلب خدمة جمع نفايات إلكترونية',
        'campaign' => 'تنسيق حملة / كمية كبيرة',
    ];

    const ENTITY_TYPES = [
        'individual' => 'فرد',
        'education' => 'مؤسسة تعليمية',
        'company' => 'شركة / محل تجاري',
        'local_org' => 'منظمة محلية',
        'intl_org' => 'منظمة دولية',
        'government' => 'جهة حكومية',
        'other' => 'أخرى',
    ];

    const ACCESSIBILITY_OPTIONS = [
        'easy' => 'نعم',
        'needs_coordination' => 'يحتاج تنسيق مسبق',
        'hard' => 'صعب الوصول',
    ];

    const WASTE_TYPES = [
        'phones' => 'هواتف محمولة',
        'desktops' => 'كمبيوترات مكتبية',
        'laptops' => 'لابتوبات',
        'screens' => 'شاشات / تلفزيونات',
        'printers' => 'طابعات',
        'batteries' => 'بطاريات',
        'chargers_cables' => 'شواحن وكابلات',
        'small_devices' => 'أجهزة إلكترونية صغيرة',
        'other' => 'أخرى',
    ];

    const DEVICE_CONDITIONS = [
        'working' => 'تعمل',
        'broken' => 'معطلة',
        'mixed' => 'مختلطة',
    ];

    const PERSONAL_DATA_OPTIONS = [
        'yes' => 'نعم',
        'no' => 'لا',
        'unknown' => 'لا أعلم',
    ];

    const DELIVERY_METHODS = [
        'self_deliver' => 'أستطيع إيصالها إلى نقطة الجمع',
        'need_pickup' => 'أحتاج خدمة جمع من الموقع',
    ];

    const STATUSES = [
        'pending' => 'قيد الانتظار',
        'in_progress' => 'قيد المعالجة',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغى',
    ];

    protected $fillable = [
        'request_type',
        'request_date',
        'entity_type',
        'entity_name',
        'responsible_name',
        'phone',
        'whatsapp',
        'email',
        'city',
        'district',
        'address',
        'accessibility',
        'latitude',
        'longitude',
        'altitude',
        'accuracy',
        'waste_types',
        'device_count',
        'device_condition',
        'has_personal_data',
        'delivery_method',
        'suggested_date',
        'images',
        'notes',
        'consent',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'request_date' => 'date',
        'suggested_date' => 'date',
        'waste_types' => 'array',
        'images' => 'array',
        'consent' => 'boolean',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function getRequestTypeLabelAttribute(): string
    {
        return self::REQUEST_TYPES[$this->request_type] ?? $this->request_type;
    }

    public function getEntityTypeLabelAttribute(): string
    {
        return self::ENTITY_TYPES[$this->entity_type] ?? $this->entity_type;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getImageUrlsAttribute(): array
    {
        if (!$this->images || !is_array($this->images)) {
            return [];
        }
        return array_map(function ($path) {
            $path = ltrim($path, '/');
            if (str_starts_with($path, 'frontend/uploads/')) {
                return asset($path);
            }
            return route('storage.image.serve', ['path' => $path]);
        }, $this->images);
    }
}
