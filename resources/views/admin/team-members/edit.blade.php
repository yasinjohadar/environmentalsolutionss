@extends('admin.layouts.master')

@section('page-title')
تعديل عضو فريق
@stop

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                    <h4 class="mb-0">تعديل العضو</h4>
                    <p class="mb-0 text-muted">تعديل عضو قسم الفريق</p>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('admin.team-members.index') }}" class="btn btn-secondary">
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

            <form action="{{ route('admin.team-members.update', $teamMember) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card custom-card mb-4">
                            <div class="card-header">
                                <div class="card-title">المعلومات الأساسية</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">الاسم <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $teamMember->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">المسمى الوظيفي <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $teamMember->title) }}" placeholder="مثال: مدير قسم الاستدامة" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card custom-card mb-4">
                            <div class="card-header">
                                <div class="card-title">الصورة</div>
                            </div>
                            <div class="card-body">
                                @if($teamMember->image)
                                    <div class="mb-3">
                                        <label class="form-label">الصورة الحالية</label>
                                        <img src="{{ $teamMember->image_url }}" alt="{{ $teamMember->name }}" class="img-fluid rounded d-block mb-2" style="max-height: 150px;">
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">تغيير الصورة (اختياري)</label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">اتركه فارغاً للإبقاء على الصورة الحالية</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="imagePreview" class="mb-3" style="display: none;">
                                    <label class="form-label">معاينة الصورة الجديدة</label>
                                    <img src="" alt="معاينة" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        <div class="card custom-card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">الترتيب</label>
                                    <input type="number" name="order" class="form-control" value="{{ old('order', $teamMember->order) }}" min="0">
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $teamMember->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">العضو نشط</label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                    <i class="bi bi-save me-2"></i>حفظ التعديلات
                                </button>
                                <a href="{{ route('admin.team-members.index') }}" class="btn btn-secondary w-100">إلغاء</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('input[name="image"]');
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
