@extends('admin.layouts.master')

@section('page-title')
إضافة شريحة هيرو
@stop

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                    <h4 class="mb-0">إضافة شريحة جديدة</h4>
                    <p class="mb-0 text-muted">إضافة شريحة لقسم الهيرو في الصفحة الرئيسية</p>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right me-2"></i>رجوع للقائمة
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>يوجد أخطاء في النموذج:</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card custom-card mb-4">
                            <div class="card-header">
                                <div class="card-title">المحتوى</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">العنوان الفرعي</label>
                                    <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}">
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">العنوان الرئيسي <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">الوصف</label>
                                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">نص الزر الأول</label>
                                        <input type="text" name="button1_text" class="form-control" value="{{ old('button1_text') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رابط الزر الأول</label>
                                        <input type="text" name="button1_url" class="form-control" value="{{ old('button1_url') }}" placeholder="/project أو https://...">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">نص الزر الثاني</label>
                                        <input type="text" name="button2_text" class="form-control" value="{{ old('button2_text') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رابط الزر الثاني</label>
                                        <input type="text" name="button2_url" class="form-control" value="{{ old('button2_url') }}" placeholder="/about أو https://...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card custom-card mb-4">
                            <div class="card-header">
                                <div class="card-title">صورة الخلفية</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">صورة الخلفية <span class="text-danger">*</span></label>
                                    <input type="file" name="background_image" class="form-control @error('background_image') is-invalid @enderror" accept="image/*" required>
                                    <small class="text-muted">يفضل صورة بعرض 1920px أو أكبر</small>
                                    @error('background_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="imagePreview" class="mb-3" style="display: none;">
                                    <img src="" alt="معاينة" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        <div class="card custom-card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">الترتيب</label>
                                    <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">الشريحة نشطة</label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                    <i class="bi bi-save me-2"></i>حفظ الشريحة
                                </button>
                                <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-secondary w-100">إلغاء</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('input[name="background_image"]');
            const preview = document.getElementById('imagePreview');
            const previewImg = preview?.querySelector('img');

            if (fileInput && preview && previewImg) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
