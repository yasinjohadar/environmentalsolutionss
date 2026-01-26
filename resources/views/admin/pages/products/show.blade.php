@extends('admin.layouts.master')

@section('page-title')
    تفاصيل المنتج
@stop

@section('css')
@stop

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div class="my-auto">
                    <h5 class="page-title fs-21 mb-1">تفاصيل المنتج: {{ $product->name }}</h5>
                </div>
                <div>
                    @can('product-edit')
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm me-2">
                            <i class="bi bi-pencil"></i> تعديل
                        </a>
                    @endcan
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
                        العودة للقائمة
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- الصور والمعلومات الأساسية -->
                <div class="col-xl-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">المعلومات الأساسية</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>الاسم:</strong>
                                    <p>{{ $product->name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>SKU:</strong>
                                    <p><code>{{ $product->sku ?? '-' }}</code></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>الباركود:</strong>
                                    <p>{{ $product->barcode ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>التصنيف:</strong>
                                    <p>
                                        @if($product->category)
                                            <span class="badge bg-info">{{ $product->category->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <strong>الوصف المختصر:</strong>
                                    <p>{{ $product->short_description ?? '-' }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <strong>الوصف الكامل:</strong>
                                    <p>{!! nl2br(e($product->description ?? '-')) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- معرض الصور -->
                    @if($product->images->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">معرض الصور</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($product->images as $image)
                                        <div class="col-md-3 mb-3">
                                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->alt_text }}" 
                                                 class="img-fluid rounded" style="max-height: 200px;">
                                            @if($image->is_main)
                                                <span class="badge bg-success mt-2">صورة رئيسية</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- الألوان -->
                    @if($product->colors->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">الألوان المتاحة</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($product->colors as $color)
                                        <div class="text-center">
                                            @if($color->hex_code)
                                                <div class="color-preview" style="background-color: {{ $color->hex_code }}; width: 60px; height: 60px; border-radius: 8px; border: 2px solid #dee2e6;"></div>
                                            @elseif($color->image)
                                                <img src="{{ Storage::url($color->image) }}" alt="{{ $color->name }}" 
                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                            @endif
                                            <p class="mt-2 mb-0"><strong>{{ $color->name }}</strong></p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- المقاسات -->
                    @if($product->sizes->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">المقاسات المتاحة</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($product->sizes as $size)
                                        <span class="badge bg-secondary p-2">{{ $size->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- التباينات -->
                    @if($product->variants->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="card-title mb-0">التباينات ({{ $product->variants->count() }})</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>اللون</th>
                                                <th>المقاس</th>
                                                <th>SKU</th>
                                                <th>السعر</th>
                                                <th>المخزون</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->variants as $variant)
                                                <tr>
                                                    <td>{{ $variant->color->name ?? '-' }}</td>
                                                    <td>{{ $variant->size->name ?? '-' }}</td>
                                                    <td><code>{{ $variant->sku ?? '-' }}</code></td>
                                                    <td>
                                                        @if($variant->sale_price)
                                                            <span class="text-decoration-line-through text-muted">{{ number_format($variant->price, 2) }}</span>
                                                            <span class="text-danger fw-bold ms-2">{{ number_format($variant->sale_price, 2) }} ر.س</span>
                                                        @else
                                                            {{ number_format($variant->price ?? $product->price, 2) }} ر.س
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($variant->stock_quantity > 0)
                                                            <span class="badge bg-success">{{ $variant->stock_quantity }}</span>
                                                        @else
                                                            <span class="badge bg-danger">نفد</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- الجانب الأيمن -->
                <div class="col-xl-4">
                    <!-- الصورة الرئيسية -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">الصورة الرئيسية</h6>
                        </div>
                        <div class="card-body text-center">
                            @if($product->main_image_url)
                                <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" 
                                     class="img-fluid rounded" style="max-height: 300px;">
                            @else
                                <p class="text-muted">لا توجد صورة</p>
                            @endif
                        </div>
                    </div>

                    <!-- الأسعار والمخزون -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">الأسعار والمخزون</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 150px;">السعر الأساسي</th>
                                    <td><strong>{{ number_format($product->price, 2) }} ر.س</strong></td>
                                </tr>
                                @if($product->sale_price)
                                    <tr>
                                        <th>سعر التخفيض</th>
                                        <td>
                                            <span class="text-danger fw-bold">{{ number_format($product->sale_price, 2) }} ر.س</span>
                                            <span class="badge bg-success ms-2">خصم {{ $product->discount_percentage }}%</span>
                                        </td>
                                    </tr>
                                @endif
                                @if($product->wholesale_price)
                                    <tr>
                                        <th>سعر الجملة</th>
                                        <td><strong>{{ number_format($product->wholesale_price, 2) }} ر.س</strong></td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>الكمية المتوفرة</th>
                                    <td>
                                        @if($product->isInStock())
                                            <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                        @else
                                            <span class="badge bg-danger">نفد</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>الحد الأدنى للطلب</th>
                                    <td>{{ $product->min_order_quantity }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- الأبعاد والوزن -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">الأبعاد والوزن</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 150px;">الوزن</th>
                                    <td>{{ $product->weight ? $product->weight . ' كجم' : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>الأبعاد</th>
                                    <td>{{ $product->dimensions ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- الحالة -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">الحالة</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 150px;">الحالة</th>
                                    <td>
                                        @if($product->status == 'active')
                                            <span class="badge bg-success">نشط</span>
                                        @elseif($product->status == 'inactive')
                                            <span class="badge bg-danger">غير نشط</span>
                                        @else
                                            <span class="badge bg-secondary">مسودة</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>منتج مميز</th>
                                    <td>
                                        @if($product->featured)
                                            <span class="badge bg-warning text-dark">نعم</span>
                                        @else
                                            <span class="text-muted">لا</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإنشاء</th>
                                    <td>{{ $product->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>آخر تحديث</th>
                                    <td>{{ $product->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- SEO -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">إعدادات SEO</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 150px;">عنوان SEO</th>
                                    <td>{{ $product->meta_title ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>وصف SEO</th>
                                    <td>{{ $product->meta_description ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>الكلمات المفتاحية</th>
                                    <td>{{ $product->meta_keywords ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>الرابط (Slug)</th>
                                    <td><code>{{ $product->slug ?? '-' }}</code></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
