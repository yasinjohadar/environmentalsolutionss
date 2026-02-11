@extends('admin.layouts.master')

@section('page-title')
    إعدادات الموقع
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">إعدادات الموقع العامة</h4>
                <p class="mb-0 text-muted">اسم الموقع، الشعار، وسائل التواصل، الفوتر وأكثر</p>
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
                <strong>يوجد أخطاء:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.settings.site.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-general">عام</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-logo">الشعار والأيقونة</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-social">وسائل التواصل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-contact">التواصل (هاتف، بريد، عنوان)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-footer">الفوتر</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-meta">JSON للتطوير</a>
                </li>
            </ul>

            <p class="text-muted small mb-3">لتعديل الهاتف والبريد الإلكتروني والعنوان الظاهرة في الموقع والفوتر، استخدم تبويب <strong>«التواصل (هاتف، بريد، عنوان)»</strong> أعلاه.</p>

            <div class="tab-content">
                {{-- عام --}}
                <div class="tab-pane fade show active" id="tab-general">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">اسم الموقع <span class="text-danger">*</span></label>
                                <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror"
                                       value="{{ old('site_name', $settings->site_name) }}" required>
                                @error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- الشعار --}}
                <div class="tab-pane fade" id="tab-logo">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">الشعار والأيقونات</h6></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">الشعار الرئيسي</label>
                                    @if($settings->logo)
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <img src="{{ $settings->logo_url }}" alt="" class="img-fluid rounded d-block" style="max-height: 80px;">
                                            <label class="form-check mb-0">
                                                <input type="checkbox" name="clear_logo" value="1" class="form-check-input">
                                                <span class="form-check-label text-danger small">إزالة الشعار</span>
                                            </label>
                                        </div>
                                    @endif
                                    <input type="file" name="logo" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">الشعار للنمط الداكن</label>
                                    @if($settings->logo_dark)
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <img src="{{ $settings->logo_dark_url }}" alt="" class="img-fluid rounded d-block" style="max-height: 80px;">
                                            <label class="form-check mb-0">
                                                <input type="checkbox" name="clear_logo_dark" value="1" class="form-check-input">
                                                <span class="form-check-label text-danger small">إزالة الشعار</span>
                                            </label>
                                        </div>
                                    @endif
                                    <input type="file" name="logo_dark" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">أيقونة المفضلة (Favicon)</label>
                                    @if($settings->favicon)
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <img src="{{ $settings->favicon_url }}" alt="" class="img-fluid d-block" style="max-height: 32px;">
                                            <label class="form-check mb-0">
                                                <input type="checkbox" name="clear_favicon" value="1" class="form-check-input">
                                                <span class="form-check-label text-danger small">إزالة الأيقونة</span>
                                            </label>
                                        </div>
                                    @endif
                                    <input type="file" name="favicon" class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- وسائل التواصل --}}
                <div class="tab-pane fade" id="tab-social">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">روابط وسائل التواصل الاجتماعي</h6></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Facebook</label>
                                    <input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $settings->facebook_url) }}" placeholder="https://facebook.com/...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Twitter / X</label>
                                    <input type="url" name="twitter_url" class="form-control" value="{{ old('twitter_url', $settings->twitter_url) }}" placeholder="https://twitter.com/...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Instagram</label>
                                    <input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url', $settings->instagram_url) }}" placeholder="https://instagram.com/...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $settings->linkedin_url) }}" placeholder="https://linkedin.com/...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">YouTube</label>
                                    <input type="url" name="youtube_url" class="form-control" value="{{ old('youtube_url', $settings->youtube_url) }}" placeholder="https://youtube.com/...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">WhatsApp (رقم فقط، مثال: 966501234567)</label>
                                    <input type="text" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $settings->whatsapp_number) }}" placeholder="966501234567">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pinterest</label>
                                    <input type="url" name="pinterest_url" class="form-control" value="{{ old('pinterest_url', $settings->pinterest_url) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">TikTok</label>
                                    <input type="url" name="tiktok_url" class="form-control" value="{{ old('tiktok_url', $settings->tiktok_url) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Snapchat</label>
                                    <input type="url" name="snapchat_url" class="form-control" value="{{ old('snapchat_url', $settings->snapchat_url) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Telegram</label>
                                    <input type="url" name="telegram_url" class="form-control" value="{{ old('telegram_url', $settings->telegram_url) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- التواصل --}}
                <div class="tab-pane fade" id="tab-contact">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">معلومات التواصل</h6></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">رقم الهاتف</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $settings->phone) }}" placeholder="+966 50 123 4567">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">رقم هاتف ثانوي</label>
                                    <input type="text" name="phone_2" class="form-control" value="{{ old('phone_2', $settings->phone_2) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">البريد الإلكتروني</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $settings->email) }}" placeholder="info@example.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">بريد إلكتروني ثانوي</label>
                                    <input type="email" name="email_2" class="form-control" value="{{ old('email_2', $settings->email_2) }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">العنوان</label>
                                    <textarea name="address" class="form-control" rows="2">{{ old('address', $settings->address) }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">رابط تضمين خريطة الموقع (Google Maps Embed)</label>
                                    <input type="text" name="map_embed_src" class="form-control" value="{{ old('map_embed_src', $settings->getMeta('map_embed_src')) }}" placeholder="https://www.google.com/maps/embed?pb=...">
                                    <small class="text-muted">من Google Maps: مشاركة → تضمين خريطة → نسخ رابط iframe (src)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- الفوتر --}}
                <div class="tab-pane fade" id="tab-footer">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">إعدادات الفوتر</h6></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">خلفية الفوتر</label>
                                @if($settings->footer_background)
                                    <img src="{{ $settings->footer_background_url }}" alt="" class="img-fluid rounded mb-2 d-block" style="max-height: 100px;">
                                @endif
                                <input type="file" name="footer_background" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">وصف الفوتر</label>
                                <textarea name="footer_description" class="form-control" rows="3">{{ old('footer_description', $settings->footer_description) }}</textarea>
                                <small class="text-muted">يظهر تحت الشعار في الفوتر</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- JSON للتطوير --}}
                <div class="tab-pane fade" id="tab-meta">
                    <div class="card mb-4">
                        <div class="card-header"><h6 class="mb-0">بيانات إضافية (JSON)</h6></div>
                        <div class="card-body">
                            <label class="form-label">حقل meta - لتخزين بيانات مخصصة للتطوير المستقبلي</label>
                            <textarea name="meta" class="form-control font-monospace" rows="8" placeholder='{"key": "value"}'>{{ old('meta', $settings->meta ? json_encode($settings->meta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : '') }}</textarea>
                            <small class="text-muted">أدخل كائن JSON صحيح، مثال: {"custom_field": "value"}</small>
                            @error('meta')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line me-1"></i> حفظ الإعدادات
                </button>
            </div>
        </form>
    </div>
</div>
@stop
