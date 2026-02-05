@extends('admin.layouts.master')

@section('page-title')
    محتوى الصفحة الرئيسية
@stop

@section('content')
@php
    $c = $content ?? [];
    $url = fn($path) => $path ? \App\Models\HomePageSetting::imageUrl($path) : null;
@endphp
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">محتوى الصفحة الرئيسية</h4>
                <p class="mb-0 text-muted">تعديل الصور والنصوص المعروضة في الصفحة الرئيسية للموقع</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.home-page.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-banner">البانر الافتراضي</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-sidemenu">معرض السايدبار</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-services">الخدمات</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-choose">لماذا نحن</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-portfolio">معرض الأعمال</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-about">من نحن</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-team">فريق العمل</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-work">خطوات العمل</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-testimonial">آراء العملاء</a></li>
            </ul>

            <div class="tab-content">
                {{-- البانر الافتراضي --}}
                <div class="tab-pane fade show active" id="tab-banner">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">بانر الصفحة الرئيسية (يُستخدم عند عدم وجود شرائح هيرو)</h6></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">صورة الخلفية</label>
                                    @if($url(data_get($c, 'banner_fallback.image')))
                                        <img src="{{ $url(data_get($c, 'banner_fallback.image')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:120px">
                                    @endif
                                    <input type="file" name="content[banner_fallback][image]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6"><label class="form-label">العنوان الفرعي</label><input type="text" name="content[banner_fallback][subtitle]" class="form-control" value="{{ old('content.banner_fallback.subtitle', data_get($c, 'banner_fallback.subtitle')) }}"></div>
                                <div class="col-md-6"><label class="form-label">العنوان الرئيسي</label><input type="text" name="content[banner_fallback][title]" class="form-control" value="{{ old('content.banner_fallback.title', data_get($c, 'banner_fallback.title')) }}"></div>
                                <div class="col-12"><label class="form-label">الوصف</label><textarea name="content[banner_fallback][description]" class="form-control" rows="2">{{ old('content.banner_fallback.description', data_get($c, 'banner_fallback.description')) }}</textarea></div>
                                <div class="col-md-3"><label class="form-label">نص الزر 1</label><input type="text" name="content[banner_fallback][button1_text]" class="form-control" value="{{ old('content.banner_fallback.button1_text', data_get($c, 'banner_fallback.button1_text')) }}"></div>
                                <div class="col-md-3"><label class="form-label">رابط الزر 1</label><input type="text" name="content[banner_fallback][button1_url]" class="form-control" value="{{ old('content.banner_fallback.button1_url', data_get($c, 'banner_fallback.button1_url')) }}"></div>
                                <div class="col-md-3"><label class="form-label">نص الزر 2</label><input type="text" name="content[banner_fallback][button2_text]" class="form-control" value="{{ old('content.banner_fallback.button2_text', data_get($c, 'banner_fallback.button2_text')) }}"></div>
                                <div class="col-md-3"><label class="form-label">رابط الزر 2</label><input type="text" name="content[banner_fallback][button2_url]" class="form-control" value="{{ old('content.banner_fallback.button2_url', data_get($c, 'banner_fallback.button2_url')) }}" placeholder="مثال: /about"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- معرض السايدبار --}}
                <div class="tab-pane fade" id="tab-sidemenu">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">صور معرض السايدبار (4 صور)</h6></div>
                        <div class="card-body">
                            <div class="row g-3">
                                @for($i = 0; $i < 4; $i++)
                                <div class="col-md-6">
                                    <label class="form-label">صورة {{ $i + 1 }}</label>
                                    @if($url(data_get($c, "sidemenu_gallery.$i")))
                                        <img src="{{ $url(data_get($c, "sidemenu_gallery.$i")) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:80px">
                                    @endif
                                    <input type="file" name="content[sidemenu_gallery][{{ $i }}]" class="form-control" accept="image/*">
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                {{-- الخدمات --}}
                <div class="tab-pane fade" id="tab-services">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">قسم الخدمات</h6></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">العنوان الفرعي</label>
                                <input type="text" name="content[services][section_subtitle]" class="form-control" value="{{ old('content.services.section_subtitle', data_get($c, 'services.section_subtitle')) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">العنوان الرئيسي</label>
                                <input type="text" name="content[services][section_title]" class="form-control" value="{{ old('content.services.section_title', data_get($c, 'services.section_title')) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الوصف</label>
                                <textarea name="content[services][section_description]" class="form-control" rows="2">{{ old('content.services.section_description', data_get($c, 'services.section_description')) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- لماذا نحن --}}
                <div class="tab-pane fade" id="tab-choose">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">قسم لماذا نحن</h6></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">الصورة الرئيسية 1</label>
                                    @if($url(data_get($c, 'choose_us.image1')))<img src="{{ $url(data_get($c, 'choose_us.image1')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:80px">@endif
                                    <input type="file" name="content[choose_us][image1]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">الصورة الرئيسية 2</label>
                                    @if($url(data_get($c, 'choose_us.image2')))<img src="{{ $url(data_get($c, 'choose_us.image2')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:80px">@endif
                                    <input type="file" name="content[choose_us][image2]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">صور الأشخاص (5)</label>
                                    <div class="row g-2">
                                        @for($i = 0; $i < 5; $i++)
                                        <div class="col"><input type="file" name="content[choose_us][people_images][{{ $i }}]" class="form-control form-control-sm" accept="image/*"></div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="col-12"><label class="form-label">العنوان</label><input type="text" name="content[choose_us][section_title]" class="form-control" value="{{ old('content.choose_us.section_title', data_get($c, 'choose_us.section_title')) }}"></div>
                                <div class="col-12"><label class="form-label">الوصف</label><textarea name="content[choose_us][description]" class="form-control" rows="2">{{ old('content.choose_us.description', data_get($c, 'choose_us.description')) }}</textarea></div>
                                <div class="col-md-6">
                                    <label class="form-label">صورة الفيديو</label>
                                    @if($url(data_get($c, 'choose_us.video_image')))<img src="{{ $url(data_get($c, 'choose_us.video_image')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:60px">@endif
                                    <input type="file" name="content[choose_us][video_image]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6"><label class="form-label">رابط الفيديو (YouTube)</label><input type="url" name="content[choose_us][video_url]" class="form-control" value="{{ old('content.choose_us.video_url', data_get($c, 'choose_us.video_url')) }}"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- معرض الأعمال --}}
                <div class="tab-pane fade" id="tab-portfolio">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">قسم المعرض / المنتجات</h6></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">خلفية القسم</label>
                                    @if($url(data_get($c, 'portfolio.bg_image')))<img src="{{ $url(data_get($c, 'portfolio.bg_image')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:80px">@endif
                                    <input type="file" name="content[portfolio][bg_image]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-12"><label class="form-label">النص بجانب المعرض</label><textarea name="content[portfolio][description]" class="form-control" rows="2">{{ old('content.portfolio.description', data_get($c, 'portfolio.description')) }}</textarea></div>
                                <div class="col-md-4">
                                    <label class="form-label">صورة 1</label>
                                    @if($url(data_get($c, 'portfolio.image1')))<img src="{{ $url(data_get($c, 'portfolio.image1')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:60px">@endif
                                    <input type="file" name="content[portfolio][image1]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">صورة 2</label>
                                    @if($url(data_get($c, 'portfolio.image2')))<img src="{{ $url(data_get($c, 'portfolio.image2')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:60px">@endif
                                    <input type="file" name="content[portfolio][image2]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">صورة 3</label>
                                    @if($url(data_get($c, 'portfolio.image3')))<img src="{{ $url(data_get($c, 'portfolio.image3')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:60px">@endif
                                    <input type="file" name="content[portfolio][image3]" class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- من نحن --}}
                <div class="tab-pane fade" id="tab-about">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">قسم من نحن (CTA)</h6></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">صورة الخلفية</label>
                                @if($url(data_get($c, 'about_section.bg_image')))<img src="{{ $url(data_get($c, 'about_section.bg_image')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:100px">@endif
                                <input type="file" name="content[about_section][bg_image]" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3"><label class="form-label">العنوان الفرعي</label><input type="text" name="content[about_section][subtitle]" class="form-control" value="{{ old('content.about_section.subtitle', data_get($c, 'about_section.subtitle')) }}"></div>
                            <div class="mb-3"><label class="form-label">العنوان</label><input type="text" name="content[about_section][title]" class="form-control" value="{{ old('content.about_section.title', data_get($c, 'about_section.title')) }}"></div>
                            <div class="mb-3"><label class="form-label">الوصف</label><textarea name="content[about_section][description]" class="form-control" rows="2">{{ old('content.about_section.description', data_get($c, 'about_section.description')) }}</textarea></div>
                        </div>
                    </div>
                </div>

                {{-- فريق العمل --}}
                <div class="tab-pane fade" id="tab-team">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">قسم فريق العمل</h6></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">الصورة الافتراضية (عند عدم وجود أعضاء)</label>
                                @if($url(data_get($c, 'team.default_image')))<img src="{{ $url(data_get($c, 'team.default_image')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:80px">@endif
                                <input type="file" name="content[team][default_image]" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3"><label class="form-label">العنوان الفرعي</label><input type="text" name="content[team][subtitle]" class="form-control" value="{{ old('content.team.subtitle', data_get($c, 'team.subtitle')) }}"></div>
                            <div class="mb-3"><label class="form-label">العنوان</label><input type="text" name="content[team][title]" class="form-control" value="{{ old('content.team.title', data_get($c, 'team.title')) }}"></div>
                            <div class="mb-3"><label class="form-label">الوصف</label><textarea name="content[team][description]" class="form-control" rows="2">{{ old('content.team.description', data_get($c, 'team.description')) }}</textarea></div>
                        </div>
                    </div>
                </div>

                {{-- خطوات العمل --}}
                <div class="tab-pane fade" id="tab-work">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">قسم خطوات العمل</h6></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">الصورة الرئيسية</label>
                                @if($url(data_get($c, 'work_process.main_image')))<img src="{{ $url(data_get($c, 'work_process.main_image')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:80px">@endif
                                <input type="file" name="content[work_process][main_image]" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3"><label class="form-label">العنوان الفرعي</label><input type="text" name="content[work_process][subtitle]" class="form-control" value="{{ old('content.work_process.subtitle', data_get($c, 'work_process.subtitle')) }}"></div>
                            <div class="mb-3"><label class="form-label">العنوان</label><input type="text" name="content[work_process][title]" class="form-control" value="{{ old('content.work_process.title', data_get($c, 'work_process.title')) }}"></div>
                            <div class="mb-3"><label class="form-label">الوصف</label><textarea name="content[work_process][description]" class="form-control" rows="2">{{ old('content.work_process.description', data_get($c, 'work_process.description')) }}</textarea></div>
                        </div>
                    </div>
                </div>

                {{-- آراء العملاء --}}
                <div class="tab-pane fade" id="tab-testimonial">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">قسم آراء العملاء</h6></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">صورة افتراضية (عند عدم وجود آراء)</label>
                                    @if($url(data_get($c, 'testimonial.fallback_image')))<img src="{{ $url(data_get($c, 'testimonial.fallback_image')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:80px">@endif
                                    <input type="file" name="content[testimonial][fallback_image]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">صورة المستخدم الافتراضية</label>
                                    @if($url(data_get($c, 'testimonial.user_placeholder')))<img src="{{ $url(data_get($c, 'testimonial.user_placeholder')) }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height:60px">@endif
                                    <input type="file" name="content[testimonial][user_placeholder]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-12"><label class="form-label">العنوان الفرعي</label><input type="text" name="content[testimonial][subtitle]" class="form-control" value="{{ old('content.testimonial.subtitle', data_get($c, 'testimonial.subtitle')) }}"></div>
                                <div class="col-12"><label class="form-label">العنوان</label><input type="text" name="content[testimonial][title]" class="form-control" value="{{ old('content.testimonial.title', data_get($c, 'testimonial.title')) }}"></div>
                                <div class="col-12"><label class="form-label">الوصف</label><textarea name="content[testimonial][description]" class="form-control" rows="2">{{ old('content.testimonial.description', data_get($c, 'testimonial.description')) }}</textarea></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i> حفظ المحتوى</button>
            </div>
        </form>
    </div>
</div>
@stop
