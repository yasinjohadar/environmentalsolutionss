@extends('frontend.layouts.app')

@section('title', 'طلب جمع / التبرع بالنفايات الإلكترونية')
@section('content')
<section class="space py-60">
    <div class="container">
        <div class="section-heading max-w-804 mx-auto text-center mb-50">
            <h2 class="mb-24">طلب جمع أو التبرع بالنفايات الإلكترونية</h2>
            <p class="mb-0">املأ النموذج أدناه وسنتواصل معك في أقرب وقت</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        @endif

        <form action="{{ route('frontend.ewaste.store') }}" method="POST" enctype="multipart/form-data" class="max-w-900 mx-auto">
            @csrf

            {{-- القسم الأول: معلومات عامة --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">1. معلومات عامة</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">نوع الطلب <span class="text-danger">*</span></label>
                            <select name="request_type" class="form-select" required>
                                @foreach(\App\Models\EwasteRequest::REQUEST_TYPES as $key => $label)
                                    <option value="{{ $key }}" {{ old('request_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">التاريخ <span class="text-danger">*</span></label>
                            <input type="date" name="request_date" class="form-control" value="{{ old('request_date', date('Y-m-d')) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- القسم الثاني: نوع الجهة --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">2. نوع الجهة</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">نوع الجهة المقدِّمة للطلب <span class="text-danger">*</span></label>
                    <select name="entity_type" class="form-select" required>
                        @foreach(\App\Models\EwasteRequest::ENTITY_TYPES as $key => $label)
                            <option value="{{ $key }}" {{ old('entity_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- القسم الثالث: معلومات الجهة / الشخص --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">3. معلومات الجهة / الشخص</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">اسم الشخص أو اسم الجهة <span class="text-danger">*</span></label>
                            <input type="text" name="entity_name" class="form-control" value="{{ old('entity_name') }}" required maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">اسم الشخص المسؤول <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_name" class="form-control" value="{{ old('responsible_name') }}" required maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم الهاتف للتواصل <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required maxlength="30">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم واتساب (إن وجد)</label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}" maxlength="30">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني (اختياري)</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" maxlength="255">
                        </div>
                    </div>
                </div>
            </div>

            {{-- القسم الرابع: الموقع الجغرافي --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">4. الموقع الجغرافي</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">المدينة <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', 'حلب') }}" required maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الحي / المنطقة <span class="text-danger">*</span></label>
                            <input type="text" name="district" class="form-control" value="{{ old('district') }}" required maxlength="255">
                        </div>
                        <div class="col-12">
                            <label class="form-label">العنوان التقريبي <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}" required maxlength="500">
                        </div>
                        <div class="col-12">
                            <label class="form-label">هل الموقع سهل الوصول؟ <span class="text-danger">*</span></label>
                            <select name="accessibility" class="form-select" required>
                                @foreach(\App\Models\EwasteRequest::ACCESSIBILITY_OPTIONS as $key => $label)
                                    <option value="{{ $key }}" {{ old('accessibility') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <p class="text-muted small mb-2">تحديد الموقع على الخريطة (اختياري)</p>
                            <div class="row g-2">
                                <div class="col-md-3"><input type="number" step="any" name="latitude" class="form-control" placeholder="خط العرض" value="{{ old('latitude') }}"></div>
                                <div class="col-md-3"><input type="number" step="any" name="longitude" class="form-control" placeholder="خط الطول" value="{{ old('longitude') }}"></div>
                                <div class="col-md-3"><input type="number" step="any" name="altitude" class="form-control" placeholder="الارتفاع" value="{{ old('altitude') }}"></div>
                                <div class="col-md-3"><input type="number" step="any" name="accuracy" class="form-control" placeholder="الدقة" value="{{ old('accuracy') }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- القسم الخامس: معلومات النفايات الإلكترونية --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">5. معلومات النفايات الإلكترونية</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">أنواع النفايات الإلكترونية <span class="text-danger">*</span> (اختيار متعدد)</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach(\App\Models\EwasteRequest::WASTE_TYPES as $key => $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="waste_types[]" value="{{ $key }}" id="wt_{{ $key }}"
                                            {{ in_array($key, old('waste_types', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wt_{{ $key }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">العدد التقريبي للأجهزة <span class="text-danger">*</span></label>
                            <input type="number" name="device_count" class="form-control" value="{{ old('device_count', 1) }}" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">حالة الأجهزة <span class="text-danger">*</span></label>
                            <select name="device_condition" class="form-select" required>
                                @foreach(\App\Models\EwasteRequest::DEVICE_CONDITIONS as $key => $label)
                                    <option value="{{ $key }}" {{ old('device_condition') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">هل تحتوي الأجهزة على بيانات شخصية؟ <span class="text-danger">*</span></label>
                            <select name="has_personal_data" class="form-select" required>
                                @foreach(\App\Models\EwasteRequest::PERSONAL_DATA_OPTIONS as $key => $label)
                                    <option value="{{ $key }}" {{ old('has_personal_data') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- القسم السادس: طريقة التسليم / الجمع --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">6. طريقة التسليم / الجمع</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">طريقة التعامل مع النفايات <span class="text-danger">*</span></label>
                            <select name="delivery_method" class="form-select" required>
                                @foreach(\App\Models\EwasteRequest::DELIVERY_METHODS as $key => $label)
                                    <option value="{{ $key }}" {{ old('delivery_method') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ مقترح للجمع</label>
                            <input type="date" name="suggested_date" class="form-control" value="{{ old('suggested_date') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- القسم السابع: صور ومرفقات --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">7. صور ومرفقات (اختياري)</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">إرفاق صورة للنفايات (1)</label>
                            <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">إرفاق صورة للنفايات (2)</label>
                            <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        </div>
                    </div>
                </div>
            </div>

            {{-- القسم الثامن: ملاحظات إضافية --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">8. ملاحظات إضافية</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="4" maxlength="2000">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- القسم التاسع: الموافقة والتأكيد --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">9. الموافقة والتأكيد</h5>
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="consent" value="1" id="consent" {{ old('consent') ? 'checked' : '' }} required>
                        <label class="form-check-label" for="consent">
                            أوافق وأؤكد أن المعلومات المقدمة صحيحة، وأوافق على التعامل مع طلبي وفق سياسة إعادة تدوير النفايات الإلكترونية <span class="text-danger">*</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg px-5">إرسال الطلب</button>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg ms-2">إلغاء</a>
            </div>
        </form>
    </div>
</section>
@endsection
