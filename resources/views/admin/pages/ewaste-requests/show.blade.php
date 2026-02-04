@extends('admin.layouts.master')

@section('page-title')
    تفاصيل الطلب #{{ $ewasteRequest->id }}
@stop

@section('css')
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    @endif

    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div class="my-auto">
                    <h5 class="page-title fs-21 mb-1">طلب #{{ $ewasteRequest->id }} - {{ $ewasteRequest->request_type_label }}</h5>
                </div>
                <div>
                    <a href="{{ route('admin.ewaste-requests.index') }}" class="btn btn-secondary btn-sm">العودة للقائمة</a>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">معلومات عامة</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>نوع الطلب:</strong>
                                    <p>{{ $ewasteRequest->request_type_label }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>التاريخ:</strong>
                                    <p>{{ $ewasteRequest->request_date->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">معلومات الجهة / الشخص</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>نوع الجهة:</strong>
                                    <p>{{ $ewasteRequest->entity_type_label }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>اسم الجهة/الشخص:</strong>
                                    <p>{{ $ewasteRequest->entity_name }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>المسؤول:</strong>
                                    <p>{{ $ewasteRequest->responsible_name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>الهاتف:</strong>
                                    <p>{{ $ewasteRequest->phone }}</p>
                                </div>
                            </div>
                            @if($ewasteRequest->whatsapp)
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>واتساب:</strong>
                                        <p>{{ $ewasteRequest->whatsapp }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($ewasteRequest->email)
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>البريد الإلكتروني:</strong>
                                        <p><a href="mailto:{{ $ewasteRequest->email }}">{{ $ewasteRequest->email }}</a></p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">الموقع الجغرافي</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>المدينة:</strong>
                                    <p>{{ $ewasteRequest->city }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>الحي/المنطقة:</strong>
                                    <p>{{ $ewasteRequest->district }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>العنوان:</strong>
                                    <p>{{ $ewasteRequest->address }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>سهولة الوصول:</strong>
                                    <p>{{ \App\Models\EwasteRequest::ACCESSIBILITY_OPTIONS[$ewasteRequest->accessibility] ?? $ewasteRequest->accessibility }}</p>
                                </div>
                            </div>
                            @if($ewasteRequest->latitude && $ewasteRequest->longitude)
                                <div class="row">
                                    <div class="col-12">
                                        <strong>الإحداثيات:</strong>
                                        <p>خط العرض: {{ $ewasteRequest->latitude }} | خط الطول: {{ $ewasteRequest->longitude }}</p>
                                        @if($ewasteRequest->altitude)
                                            <p>الارتفاع: {{ $ewasteRequest->altitude }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">معلومات النفايات</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong>أنواع النفايات:</strong>
                                    <p>
                                        @if(is_array($ewasteRequest->waste_types))
                                            @foreach($ewasteRequest->waste_types as $wt)
                                                <span class="badge bg-secondary me-1">{{ \App\Models\EwasteRequest::WASTE_TYPES[$wt] ?? $wt }}</span>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>عدد الأجهزة:</strong>
                                    <p>{{ $ewasteRequest->device_count }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>حالة الأجهزة:</strong>
                                    <p>{{ \App\Models\EwasteRequest::DEVICE_CONDITIONS[$ewasteRequest->device_condition] ?? $ewasteRequest->device_condition }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>بيانات شخصية:</strong>
                                    <p>{{ \App\Models\EwasteRequest::PERSONAL_DATA_OPTIONS[$ewasteRequest->has_personal_data] ?? $ewasteRequest->has_personal_data }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>طريقة التسليم:</strong>
                                    <p>{{ \App\Models\EwasteRequest::DELIVERY_METHODS[$ewasteRequest->delivery_method] ?? $ewasteRequest->delivery_method }}</p>
                                </div>
                            </div>
                            @if($ewasteRequest->suggested_date)
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>التاريخ المقترح للجمع:</strong>
                                        <p>{{ $ewasteRequest->suggested_date->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($ewasteRequest->notes)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">ملاحظات إضافية</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{!! nl2br(e($ewasteRequest->notes)) !!}</p>
                            </div>
                        </div>
                    @endif

                    @if(!empty($ewasteRequest->image_urls))
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">الصور المرفقة</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($ewasteRequest->image_urls as $url)
                                        <a href="{{ $url }}" target="_blank" rel="noopener">
                                            <img src="{{ $url }}" alt="صورة" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-xl-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">تحديث الحالة</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.ewaste-requests.update-status', $ewasteRequest->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">الحالة</label>
                                    <select name="status" class="form-select" required>
                                        @foreach(\App\Models\EwasteRequest::STATUSES as $key => $label)
                                            <option value="{{ $key }}" {{ $ewasteRequest->status == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ملاحظات الإدارة</label>
                                    <textarea name="admin_notes" class="form-control" rows="4">{{ old('admin_notes', $ewasteRequest->admin_notes) }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">حفظ التحديث</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">معلومات النظام</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered small">
                                <tr>
                                    <th style="width: 120px;">تاريخ الإنشاء</th>
                                    <td>{{ $ewasteRequest->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>آخر تحديث</th>
                                    <td>{{ $ewasteRequest->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
