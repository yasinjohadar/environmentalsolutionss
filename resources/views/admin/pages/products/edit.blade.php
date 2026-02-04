@extends('admin.layouts.master')

@section('page-title')
    تعديل المنتج
@stop

@section('css')
    <style>
        .image-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            margin-top: 10px;
        }
        .gallery-item {
            position: relative;
            display: inline-block;
            margin: 10px;
        }
        .gallery-item img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #dee2e6;
        }
        .gallery-item .remove-btn {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-size: 12px;
        }
        .color-preview {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            border: 2px solid #dee2e6;
            display: inline-block;
            margin-left: 10px;
        }
        .variant-row {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
@stop

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="page-header d-flex justify-content-between align-items-center my-4">
                <h5 class="page-title mb-0">تعديل المنتج: {{ $product->name }}</h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">العودة للقائمة</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>يوجد أخطاء في النموذج:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- المعلومات الأساسية -->
                    <div class="col-xl-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">المعلومات الأساسية</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               name="name" value="{{ old('name', $product->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">الرابط (Slug)</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                               name="slug" value="{{ old('slug', $product->slug) }}">
                                        <small class="form-text text-muted">سيتم إنشاؤه تلقائياً من الاسم إذا تركت فارغاً</small>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">SKU (رمز المنتج)</label>
                                        <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                               name="sku" value="{{ old('sku', $product->sku) }}">
                                        @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">الباركود</label>
                                        <input type="text" class="form-control @error('barcode') is-invalid @enderror" 
                                               name="barcode" value="{{ old('barcode', $product->barcode) }}">
                                        @error('barcode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">التصنيف</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                                            <option value="">اختر التصنيف</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">الوصف المختصر</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                                  name="short_description" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                                        @error('short_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">الوصف الكامل</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- الأسعار والمخزون -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">الأسعار والمخزون</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">السعر الأساسي (ر.س) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                               name="price" value="{{ old('price', $product->price) }}" required min="0">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">سعر التخفيض (ر.س)</label>
                                        <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror" 
                                               name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0">
                                        @error('sale_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">سعر الجملة (ر.س)</label>
                                        <input type="number" step="0.01" class="form-control @error('wholesale_price') is-invalid @enderror" 
                                               name="wholesale_price" value="{{ old('wholesale_price', $product->wholesale_price) }}" min="0">
                                        @error('wholesale_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">الكمية المتوفرة</label>
                                        <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                               name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0">
                                        @error('stock_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">الحد الأدنى للطلب</label>
                                        <input type="number" class="form-control @error('min_order_quantity') is-invalid @enderror" 
                                               name="min_order_quantity" value="{{ old('min_order_quantity', $product->min_order_quantity) }}" min="1">
                                        @error('min_order_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- الألوان والمقاسات -->
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0">الألوان والمقاسات</h6>
                            </div>
                            <div class="card-body">
                                <!-- الألوان -->
                                <div class="mb-4">
                                    <label class="form-label">الألوان المتاحة</label>
                                    <div id="colors-container">
                                        @foreach($product->colors as $index => $color)
                                            <div class="color-item mb-2 d-flex align-items-center gap-2">
                                                <input type="text" name="colors[{{ $index }}][name]" class="form-control" 
                                                       value="{{ $color->name }}" placeholder="اسم اللون (اختياري)">
                                                <input type="color" name="colors[{{ $index }}][hex_code]" 
                                                       class="form-control form-control-color" 
                                                       value="{{ $color->hex_code ?? '#000000' }}">
                                                @if($color->image)
                                                    <img src="{{ route('storage.image.serve', ['path' => $color->image]) }}" alt="{{ $color->name }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                @endif
                                                <input type="file" name="colors[{{ $index }}][image]" class="form-control" accept="image/*">
                                                <button type="button" class="btn btn-sm btn-danger remove-color">حذف</button>
                                            </div>
                                        @endforeach
                                        @if($product->colors->isEmpty())
                                            <div class="color-item mb-2 d-flex align-items-center gap-2">
                                                <input type="text" name="colors[0][name]" class="form-control" placeholder="اسم اللون">
                                                <input type="color" name="colors[0][hex_code]" class="form-control form-control-color" value="#000000">
                                                <input type="file" name="colors[0][image]" class="form-control" accept="image/*">
                                                <button type="button" class="btn btn-sm btn-danger remove-color">حذف</button>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary mt-2" id="add-color">إضافة لون</button>
                                </div>

                                <!-- المقاسات -->
                                <div>
                                    <label class="form-label">المقاسات المتاحة</label>
                                    <div id="sizes-container">
                                        @foreach($product->sizes as $index => $size)
                                            <div class="size-item mb-2 d-flex align-items-center gap-2">
                                                <input type="text" name="sizes[{{ $index }}][name]" class="form-control" 
                                                       value="{{ $size->name }}" placeholder="اسم المقاس (اختياري)">
                                                <input type="number" name="sizes[{{ $index }}][order]" class="form-control" 
                                                       value="{{ $size->order }}" min="0" style="width: 100px;">
                                                <button type="button" class="btn btn-sm btn-danger remove-size">حذف</button>
                                            </div>
                                        @endforeach
                                        @if($product->sizes->isEmpty())
                                            <div class="size-item mb-2 d-flex align-items-center gap-2">
                                                <input type="text" name="sizes[0][name]" class="form-control" placeholder="اسم المقاس">
                                                <input type="number" name="sizes[0][order]" class="form-control" value="0" min="0" style="width: 100px;">
                                                <button type="button" class="btn btn-sm btn-danger remove-size">حذف</button>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary mt-2" id="add-size">إضافة مقاس</button>
                                </div>
                            </div>
                        </div>

                        <!-- التباينات -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">التباينات (Variants)</h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small mb-3">يمكنك إضافة تباينات للمنتج (لون + مقاس) مع أسعار ومخزون خاص لكل تباين</p>
                                <div id="variants-container">
                                    @foreach($product->variants as $index => $variant)
                                        <div class="variant-row">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label small">اللون</label>
                                                    <select name="variants[{{ $index }}][color_id]" class="form-control form-control-sm">
                                                        <option value="">اختر اللون</option>
                                                        @foreach($product->colors as $color)
                                                            <option value="{{ $color->id }}" {{ $variant->color_id == $color->id ? 'selected' : '' }}>
                                                                {{ $color->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">المقاس</label>
                                                    <select name="variants[{{ $index }}][size_id]" class="form-control form-control-sm">
                                                        <option value="">اختر المقاس</option>
                                                        @foreach($product->sizes as $size)
                                                            <option value="{{ $size->id }}" {{ $variant->size_id == $size->id ? 'selected' : '' }}>
                                                                {{ $size->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">SKU</label>
                                                    <input type="text" name="variants[{{ $index }}][sku]" class="form-control form-control-sm" 
                                                           value="{{ $variant->sku }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">السعر</label>
                                                    <input type="number" step="0.01" name="variants[{{ $index }}][price]" 
                                                           class="form-control form-control-sm" value="{{ $variant->price }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">سعر التخفيض</label>
                                                    <input type="number" step="0.01" name="variants[{{ $index }}][sale_price]" 
                                                           class="form-control form-control-sm" value="{{ $variant->sale_price }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">المخزون</label>
                                                    <input type="number" name="variants[{{ $index }}][stock_quantity]" 
                                                           class="form-control form-control-sm" value="{{ $variant->stock_quantity }}">
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label small">صورة التباين</label>
                                                    @if($variant->image)
                                                        <img src="{{ route('storage.image.serve', ['path' => $variant->image]) }}" alt="صورة التباين" 
                                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; display: block; margin-bottom: 5px;">
                                                    @endif
                                                    <input type="file" name="variants[{{ $index }}][image]" class="form-control form-control-sm" accept="image/*">
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-sm btn-danger remove-variant">حذف التباين</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-primary mt-2" id="add-variant">إضافة تباين</button>
                            </div>
                        </div>
                    </div>

                    <!-- الجانب الأيمن -->
                    <div class="col-xl-4">
                        <!-- الصورة الرئيسية -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">الصورة الرئيسية</h6>
                            </div>
                            <div class="card-body">
                                @if($product->main_image_url)
                                    <img src="{{ $product->main_image_url }}" alt="الصورة الحالية" class="image-preview mb-2">
                                @endif
                                <input type="file" class="form-control @error('main_image') is-invalid @enderror" 
                                       name="main_image" accept="image/*" onchange="previewImage(this, 'main-image-preview-new')">
                                <img id="main-image-preview-new" class="image-preview" style="display: none;" alt="معاينة الصورة الجديدة">
                                @error('main_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- معرض الصور -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">معرض الصور</h6>
                            </div>
                            <div class="card-body">
                                @if($product->images->count() > 0)
                                    <div class="mb-3">
                                        @foreach($product->images as $image)
                                            <div class="gallery-item">
                                                <img src="{{ $image->image_url }}" alt="{{ $image->alt_text }}">
                                                <button type="button" class="remove-btn" 
                                                        onclick="deleteImage({{ $product->id }}, {{ $image->id }})">×</button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="images[]" accept="image/*" multiple id="gallery-input">
                                <div id="gallery-preview" class="mt-3"></div>
                                @error('images.*')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- الأبعاد والوزن -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">الأبعاد والوزن</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">الوزن (كجم)</label>
                                    <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" 
                                           name="weight" value="{{ old('weight', $product->weight) }}" min="0">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="form-label">الأبعاد (الطول × العرض × الارتفاع)</label>
                                    <input type="text" class="form-control @error('dimensions') is-invalid @enderror" 
                                           name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="مثال: 10×20×30">
                                    @error('dimensions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- الحالة -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">الحالة</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">حالة المنتج <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                        <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>مسودة</option>
                                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="featured" value="1" 
                                           id="featured" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">
                                        منتج مميز
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">إعدادات SEO</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">عنوان SEO (Meta Title)</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                           name="meta_title" value="{{ old('meta_title', $product->meta_title) }}">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">وصف SEO (Meta Description)</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                              name="meta_description" rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">الكلمات المفتاحية</label>
                                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                           name="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}" placeholder="افصل بين الكلمات بفواصل">
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="form-label">صورة Open Graph</label>
                                    @if($product->og_image)
                                        <img src="{{ route('storage.image.serve', ['path' => $product->og_image]) }}" alt="صورة OG الحالية" class="image-preview mb-2">
                                    @endif
                                    <input type="file" class="form-control @error('og_image') is-invalid @enderror" 
                                           name="og_image" accept="image/*" onchange="previewImage(this, 'og-image-preview-new')">
                                    <img id="og-image-preview-new" class="image-preview" style="display: none;" alt="معاينة صورة OG الجديدة">
                                    @error('og_image')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4 mb-4">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4 me-2">
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>تحديث المنتج
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success') || session('error') || $errors->any())
            window.scrollTo({ top: 0, behavior: 'smooth' });
            @endif
        });

        let colorIndex = {{ $product->colors->count() }};
        let sizeIndex = {{ $product->sizes->count() }};
        let variantIndex = {{ $product->variants->count() }};

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById(previewId);
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function deleteImage(productId, imageId) {
            if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
                fetch(`/admin/products/${productId}/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }

        document.getElementById('gallery-input').addEventListener('change', function(e) {
            const preview = document.getElementById('gallery-preview');
            Array.from(e.target.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'gallery-item';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${index + 1}">
                        <button type="button" class="remove-btn" onclick="this.closest('.gallery-item').remove()">×</button>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });

        document.getElementById('add-color').addEventListener('click', function() {
            const container = document.getElementById('colors-container');
            const div = document.createElement('div');
            div.className = 'color-item mb-2 d-flex align-items-center gap-2';
            div.innerHTML = `
                <input type="text" name="colors[${colorIndex}][name]" class="form-control" placeholder="اسم اللون (اختياري)">
                <input type="color" name="colors[${colorIndex}][hex_code]" class="form-control form-control-color" value="#000000">
                <input type="file" name="colors[${colorIndex}][image]" class="form-control" accept="image/*">
                <button type="button" class="btn btn-sm btn-danger remove-color">حذف</button>
            `;
            container.appendChild(div);
            colorIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-color')) {
                e.target.closest('.color-item').remove();
            }
            if (e.target.classList.contains('remove-size')) {
                e.target.closest('.size-item').remove();
            }
            if (e.target.classList.contains('remove-variant')) {
                e.target.closest('.variant-row').remove();
            }
        });

        document.getElementById('add-size').addEventListener('click', function() {
            const container = document.getElementById('sizes-container');
            const div = document.createElement('div');
            div.className = 'size-item mb-2 d-flex align-items-center gap-2';
            div.innerHTML = `
                <input type="text" name="sizes[${sizeIndex}][name]" class="form-control" placeholder="اسم المقاس (اختياري)">
                <input type="number" name="sizes[${sizeIndex}][order]" class="form-control" value="${sizeIndex}" min="0" style="width: 100px;">
                <button type="button" class="btn btn-sm btn-danger remove-size">حذف</button>
            `;
            container.appendChild(div);
            sizeIndex++;
        });

        document.getElementById('add-variant').addEventListener('click', function() {
            const container = document.getElementById('variants-container');
            const colors = @json($product->colors);
            const sizes = @json($product->sizes);
            
            const div = document.createElement('div');
            div.className = 'variant-row';
            
            let colorOptions = '<option value="">اختر اللون</option>';
            colors.forEach(color => {
                colorOptions += `<option value="${color.id}">${color.name}</option>`;
            });
            
            let sizeOptions = '<option value="">اختر المقاس</option>';
            sizes.forEach(size => {
                sizeOptions += `<option value="${size.id}">${size.name}</option>`;
            });
            
            div.innerHTML = `
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label small">اللون</label>
                        <select name="variants[${variantIndex}][color_id]" class="form-control form-control-sm">
                            ${colorOptions}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">المقاس</label>
                        <select name="variants[${variantIndex}][size_id]" class="form-control form-control-sm">
                            ${sizeOptions}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">SKU</label>
                        <input type="text" name="variants[${variantIndex}][sku]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">السعر</label>
                        <input type="number" step="0.01" name="variants[${variantIndex}][price]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">سعر التخفيض</label>
                        <input type="number" step="0.01" name="variants[${variantIndex}][sale_price]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">المخزون</label>
                        <input type="number" name="variants[${variantIndex}][stock_quantity]" class="form-control form-control-sm" value="0">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small">صورة التباين</label>
                        <input type="file" name="variants[${variantIndex}][image]" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-danger remove-variant">حذف التباين</button>
                    </div>
                </div>
            `;
            container.appendChild(div);
            variantIndex++;
        });
    </script>
@stop
