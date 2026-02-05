@extends('frontend.layouts.app')

@section('title', 'اتصل بنا')
@section('content')
@php $s = $siteSettings ?? null; @endphp
{{-- بنر الصفحة --}}
<section class="products-page-banner bg-img bg-overlay style-three position-relative z-index-2 d-flex align-items-center justify-content-center" data-background-image="{{ asset('frontend/assets/img/bg/breadcrumb-bg.png') }}" style="min-height: 320px;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-3">اتصل بنا</h1>
                <p class="text-neutral-20 mb-0">نحن هنا لمساعدتك — تواصل معنا لأي استفسار أو شكوى أو اقتراح</p>
            </div>
        </div>
    </div>
</section>

<section class="space py-60" style="padding-top: 80px !important;">
    <div class="container">

        {{-- معلومات التواصل + وسائل التواصل الاجتماعي --}}
        <div class="row g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-lg-6">
                <h2 class="h3 mb-4 fw-bold">معلومات التواصل</h2>
                <div class="d-flex flex-column gap-3">
                    @if($s?->phone)
                    <div class="d-flex align-items-center gap-3">
                        <span class="w-48-px h-48-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl flex-shrink-0">
                            <i class="fas fa-phone-volume"></i>
                        </span>
                        <div>
                            <span class="text-muted small d-block">الهاتف</span>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $s->phone) }}" class="text-dark hover-text-base-two">{{ $s->phone }}</a>
                        </div>
                    </div>
                    @endif
                    @if($s?->phone_2)
                    <div class="d-flex align-items-center gap-3">
                        <span class="w-48-px h-48-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl flex-shrink-0">
                            <i class="fas fa-phone"></i>
                        </span>
                        <div>
                            <span class="text-muted small d-block">هاتف ثانوي</span>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $s->phone_2) }}" class="text-dark hover-text-base-two">{{ $s->phone_2 }}</a>
                        </div>
                    </div>
                    @endif
                    @if($s?->email)
                    <div class="d-flex align-items-center gap-3">
                        <span class="w-48-px h-48-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl flex-shrink-0">
                            <i class="far fa-envelope-open"></i>
                        </span>
                        <div>
                            <span class="text-muted small d-block">البريد الإلكتروني</span>
                            <a href="mailto:{{ $s->email }}" class="text-dark hover-text-base-two">{{ $s->email }}</a>
                        </div>
                    </div>
                    @endif
                    @if($s?->email_2)
                    <div class="d-flex align-items-center gap-3">
                        <span class="w-48-px h-48-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl flex-shrink-0">
                            <i class="far fa-envelope"></i>
                        </span>
                        <div>
                            <span class="text-muted small d-block">بريد ثانوي</span>
                            <a href="mailto:{{ $s->email_2 }}" class="text-dark hover-text-base-two">{{ $s->email_2 }}</a>
                        </div>
                    </div>
                    @endif
                    @if($s?->address)
                    <div class="d-flex align-items-center gap-3">
                        <span class="w-48-px h-48-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl flex-shrink-0">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <div>
                            <span class="text-muted small d-block">العنوان</span>
                            <span class="text-dark">{{ $s->address }}</span>
                        </div>
                    </div>
                    @endif
                    @if(!$s?->phone && !$s?->email && !$s?->address)
                    <p class="text-neutral-600 mb-0">يمكنك إضافة معلومات التواصل من إعدادات الموقع.</p>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="h3 mb-4 fw-bold">وسائل التواصل الاجتماعي</h2>
                <p class="text-neutral-600 mb-4">تابعنا على منصاتنا</p>
                <ul class="list-unstyled d-flex flex-wrap gap-3 ps-0 mb-0">
                    @foreach($s?->social_links ?? [] as $platform => $data)
                    <li>
                        <a href="{{ $data['url'] }}" target="_blank" rel="noopener" class="w-56-px h-56-px rounded-circle border border-base-two text-base-two d-inline-flex justify-content-center align-items-center hover-bg-base-two hover-text-neutral-700" title="{{ $platform }}">
                            <i class="{{ $data['icon'] }} fa-lg"></i>
                        </a>
                    </li>
                    @endforeach
                    @if(empty($s?->social_links))
                    <li class="text-neutral-500">لم تتم إضافة روابط وسائل التواصل بعد.</li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- فورم التواصل / الشكاوى --}}
        <div class="row mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-lg-8 mx-auto">
                <div class="section-heading text-center mb-4">
                    <h2 class="h3 mb-2 fw-bold">أرسل لنا رسالة</h2>
                    <p class="text-neutral-600 mb-0">استفسار، شكوى، أو اقتراح — سنرد عليك في أقرب وقت</p>
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

                <form action="{{ route('frontend.contact.store') }}" method="POST" class="card shadow-sm border-0">
                    @csrf
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">الاسم <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required maxlength="255" placeholder="اسمك الكامل">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required maxlength="255" placeholder="example@email.com">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">رقم الهاتف (اختياري)</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" maxlength="30" placeholder="+966 50 123 4567">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">نوع الرسالة <span class="text-danger">*</span></label>
                                <select name="subject" class="form-select @error('subject') is-invalid @enderror" required>
                                    <option value="">-- اختر --</option>
                                    @foreach(\App\Models\ContactMessage::SUBJECTS as $value => $label)
                                        <option value="{{ $value }}" {{ old('subject') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">نص الرسالة <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required maxlength="2000" placeholder="اكتب رسالتك هنا...">{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-base-two btn-lg px-4">
                                    <i class="fas fa-paper-plane me-2"></i> إرسال الرسالة
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- خريطة مكان العمل --}}
        <div class="row">
            <div class="col-12">
                <h2 class="h3 mb-4 fw-bold text-center">موقعنا</h2>
                @php $mapSrc = $s?->getMeta('map_embed_src'); @endphp
                @if(!empty($mapSrc))
                <div class="rounded-3 overflow-hidden shadow-sm border" style="height: 400px;">
                    <iframe src="{{ $mapSrc }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="خريطة موقعنا"></iframe>
                </div>
                @else
                <div class="rounded-3 border bg-light d-flex align-items-center justify-content-center text-neutral-500" style="height: 280px;">
                    <div class="text-center p-4">
                        <i class="fas fa-map-marked-alt fa-3x mb-3 opacity-50"></i>
                        <p class="mb-0">يمكنك تحديد موقع العمل من إعدادات الموقع (رابط تضمين خريطة Google Maps).</p>
                        @if($s?->address)
                        <p class="mt-2 mb-0 small">العنوان الحالي: {{ $s->address }}</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection
