@extends('frontend.layouts.app')

@section('title', $product->meta_title ?? $product->name)
@push('meta')
    @if($product->meta_description)
        <meta name="description" content="{{ Str::limit($product->meta_description, 160) }}">
    @endif
    <meta property="og:title" content="{{ $product->meta_title ?? $product->name }}">
    @if($product->meta_description)
        <meta property="og:description" content="{{ Str::limit($product->meta_description, 200) }}">
    @endif
    <meta property="og:image" content="{{ $product->main_image_url }}">
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">
    <style>
/* معرض المنتج: صورة رئيسية بنسبة ثابتة */
.product-main-image-wrap {
  position: relative;
  aspect-ratio: 1 / 1;
  overflow: hidden;
  min-height: 280px;
  background: var(--bs-neutral-20, #f5f5f5);
}
.product-main-image-wrap .product-main-image {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: contain;
}
/* مصغرات أسفل الصورة الرئيسية */
.product-thumbs {
  -webkit-overflow-scrolling: touch;
}
.product-thumb {
  flex-shrink: 0;
  width: 80px;
  height: 80px;
  overflow: hidden;
  padding: 4px;
  border-radius: 0.5rem;
  background: transparent;
  cursor: pointer;
}
.product-thumb .product-thumb-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
@media (max-width: 576px) {
  .product-thumb {
    width: 64px;
    height: 64px;
  }
}
#related-products-arrows .slick-arrow,
#related-products-arrows .slick-prev,
#related-products-arrows .slick-next {
  position: static !important;
  inset-block-start: auto !important;
  inset-inline-end: auto !important;
  inset-inline-start: auto !important;
  margin-top: 0 !important;
}
    </style>
@endpush

@section('content')
{{-- بنر الصفحة --}}
<section class="products-page-banner bg-img bg-overlay style-three position-relative z-index-2 d-flex align-items-center justify-content-center" data-background-image="{{ asset('frontend/assets/img/bg/breadcrumb-bg.png') }}" style="min-height: 320px;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-3">{{ $product->name }}</h1>
                <p class="text-neutral-20 mb-0">{{ Str::limit($product->short_description ?? $product->meta_description ?? '', 100) }}</p>
            </div>
        </div>
    </div>
</section>

<section class="space py-60" style="padding-top: 80px !important;">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="mb-4" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.products.index') }}">المنتجات</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('frontend.products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-4 mb-5">
            {{-- معرض الصور --}}
            <div class="col-lg-6">
                <div class="position-relative rounded-3 overflow-hidden bg-neutral-20 border border-neutral-100 shadow-sm">
                    <div class="product-main-image-wrap" id="productMainImageWrap">
                        <img id="productMainImage" src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="product-main-image">
                        @if($product->isOnSale())
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3 rounded-pill px-3">خصم {{ $product->discount_percentage }}%</span>
                        @endif
                    </div>
                    @if($product->images->isNotEmpty())
                        <div class="p-3 border-top bg-white">
                            <div class="product-thumbs d-flex gap-2 flex-nowrap overflow-x-auto">
                                <button type="button" class="border-2 border-base rounded-2 p-1 product-thumb active" data-src="{{ $product->main_image_url }}">
                                    <img src="{{ $product->main_image_url }}" alt="" class="product-thumb-img">
                                </button>
                                @foreach($product->images as $img)
                                    <button type="button" class="border rounded-2 p-1 product-thumb" data-src="{{ $img->image_url }}">
                                        <img src="{{ $img->image_url }}" alt="{{ $img->alt_text }}" class="product-thumb-img">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- معلومات المنتج --}}
            <div class="col-lg-6">
                <h1 class="h3 mb-3 fw-bold">{{ $product->name }}</h1>
                @if($product->sku || $product->barcode)
                    <div class="text-muted small mb-2">
                        @if($product->sku)<span class="me-3">SKU: <code>{{ $product->sku }}</code></span>@endif
                        @if($product->barcode)<span>الباركود: {{ $product->barcode }}</span>@endif
                    </div>
                @endif
                @if($product->category)
                    <p class="mb-2">
                        التصنيف: <a href="{{ route('frontend.products.index', ['category' => $product->category->slug]) }}" class="hover-text-brand fw-semibold">{{ $product->category->name }}</a>
                    </p>
                @endif
                @if($product->short_description)
                    <p class="text-neutral-500 mb-4">{{ $product->short_description }}</p>
                @endif

                {{-- الأسعار --}}
                <div class="mb-4">
                    @if($product->isOnSale())
                        <span class="text-decoration-line-through text-muted me-2">{{ number_format($product->price, 2) }} ر.س</span>
                        <span class="h4 text-danger mb-0">{{ number_format($product->sale_price, 2) }} ر.س</span>
                    @else
                        <span class="h4 mb-0">{{ number_format($product->current_price, 2) }} ر.س</span>
                    @endif
                    @if($product->wholesale_price)
                        <p class="text-muted small mt-1 mb-0">سعر الجملة: {{ number_format($product->wholesale_price, 2) }} ر.س</p>
                    @endif
                </div>

                {{-- المخزون --}}
                <div class="mb-4">
                    @if($product->isInStock())
                        <span class="badge bg-success rounded-pill">متوفر</span>
                        @if(!$product->hasVariants() && $product->stock_quantity > 0)
                            <span class="text-muted ms-2">({{ $product->stock_quantity }} قطعة)</span>
                        @endif
                    @else
                        <span class="badge bg-danger rounded-pill">نفد</span>
                    @endif
                    @if($product->min_order_quantity > 1)
                        <span class="text-muted ms-2">الحد الأدنى للطلب: {{ $product->min_order_quantity }}</span>
                    @endif
                </div>

                {{-- الألوان --}}
                @if($product->colors->isNotEmpty())
                    <div class="mb-4">
                        <h6 class="mb-2 fw-semibold">الألوان المتاحة</h6>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            @foreach($product->colors as $color)
                                <div class="text-center">
                                    @if($color->hex_code)
                                        <span class="d-inline-block rounded-circle border" style="width: 32px; height: 32px; background-color: {{ $color->hex_code }};" title="{{ $color->name }}"></span>
                                    @elseif($color->image_url)
                                        <img src="{{ $color->image_url }}" alt="{{ $color->name }}" class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;" title="{{ $color->name }}">
                                    @else
                                        <span class="badge bg-secondary">{{ $color->name }}</span>
                                    @endif
                                    <small class="d-block">{{ $color->name }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- المقاسات --}}
                @if($product->sizes->isNotEmpty())
                    <div class="mb-4">
                        <h6 class="mb-2 fw-semibold">المقاسات</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($product->sizes as $size)
                                <span class="badge bg-light text-dark border rounded-pill px-3">{{ $size->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- جدول التباينات --}}
                @if($product->variants->isNotEmpty())
                    <div class="table-responsive mb-4">
                        <h6 class="mb-2 fw-semibold">التباينات</h6>
                        <table class="table table-bordered table-sm rounded-2 overflow-hidden">
                            <thead class="table-light">
                                <tr>
                                    <th>اللون</th>
                                    <th>المقاس</th>
                                    <th>SKU</th>
                                    <th>السعر</th>
                                    <th>المخزون</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->variants as $v)
                                    <tr>
                                        <td>{{ $v->color->name ?? '-' }}</td>
                                        <td>{{ $v->size->name ?? '-' }}</td>
                                        <td><code>{{ $v->sku ?? '-' }}</code></td>
                                        <td>{{ $v->sale_price ? number_format($v->sale_price, 2) : number_format($v->price ?? $product->price, 2) }} ر.س</td>
                                        <td>{{ $v->stock_quantity > 0 ? $v->stock_quantity : 'نفد' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <a href="{{ url('contact.html') }}" class="btn btn-primary px-4 rounded-2 global-btn">استفسار عن المنتج</a>
            </div>
        </div>

        {{-- الوصف الكامل --}}
        @if($product->description)
            <div class="bg-neutral-20 radius-12-px border border-neutral-100 overflow-hidden mb-4 shadow-sm">
                <div class="p-4 border-bottom border-neutral-100 bg-white">
                    <h5 class="mb-0 fw-semibold">الوصف</h5>
                </div>
                <div class="p-4">
                    <div class="product-description">{!! nl2br(e($product->description)) !!}</div>
                </div>
            </div>
        @endif

        {{-- المواصفات --}}
        @if($product->weight || $product->dimensions)
            <div class="bg-neutral-20 radius-12-px border border-neutral-100 overflow-hidden mb-4 shadow-sm">
                <div class="p-4 border-bottom border-neutral-100 bg-white">
                    <h5 class="mb-0 fw-semibold">المواصفات</h5>
                </div>
                <div class="p-4">
                    <table class="table table-bordered mb-0 rounded-2">
                        @if($product->weight)
                            <tr><th style="width: 180px;">الوزن</th><td>{{ $product->weight }} كجم</td></tr>
                        @endif
                        @if($product->dimensions)
                            <tr><th>الأبعاد</th><td>{{ $product->dimensions }}</td></tr>
                        @endif
                    </table>
                </div>
            </div>
        @endif

        {{-- التقييمات --}}
        @if($product->total_reviews_count > 0)
            <div class="bg-neutral-20 radius-12-px border border-neutral-100 overflow-hidden mb-4 shadow-sm">
                <div class="p-4 border-bottom border-neutral-100 bg-white d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h5 class="mb-0 fw-semibold">تقييمات العملاء</h5>
                    <span class="text-warning">{{ str_repeat('★', (int) round($product->average_rating)) }}{{ str_repeat('☆', 5 - (int) round($product->average_rating)) }} ({{ $product->total_reviews_count }})</span>
                </div>
                <div class="p-4">
                    @foreach($product->approvedReviews as $review)
                        <div class="border-bottom border-neutral-100 pb-3 mb-3 last:border-0">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="text-warning">{{ str_repeat('★', $review->rating) }}</span>
                                <strong>{{ $review->display_name }}</strong>
                            </div>
                            @if($review->comment)
                                <p class="mb-0 text-muted small">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- منتجات ذات صلة --}}
        @if($relatedProducts->isNotEmpty())
            <div class="mb-5">
                <h4 class="mb-4 fw-bold">منتجات ذات صلة</h4>
                <div class="position-relative">
                    <div class="related-products-slider">
                        @foreach($relatedProducts as $item)
                            <div class="px-2">
                                <div class="scale-hover-item bg-neutral-20 radius-12-px overflow-hidden h-100 border border-neutral-100">
                                    <div class="overflow-hidden position-relative">
                                        <a href="{{ route('frontend.products.show', $item->slug) }}" class="d-block">
                                            <img src="{{ $item->main_image_url }}" alt="{{ $item->name }}" class="w-100 fit-img transition-2" style="height: 220px; object-fit: cover;">
                                        </a>
                                        @if($item->category)
                                            <span class="badge bg-base-two position-absolute top-0 end-0 m-3">{{ $item->category->name }}</span>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h5 class="mb-2">
                                            <a href="{{ route('frontend.products.show', $item->slug) }}" class="link text-line-2 hover-text-brand text-dark">{{ $item->name }}</a>
                                        </h5>
                                        <p class="text-neutral-500 mb-3 small">{{ Str::limit($item->short_description ?? strip_tags($item->description ?? ''), 80) }}</p>
                                        <a href="{{ route('frontend.products.show', $item->slug) }}" class="fw-semibold text-base d-inline-flex align-items-center gap-2 hover-text-brand">
                                            عرض التفاصيل <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="related-products-arrows" class="slick-arrows d-flex align-items-center gap-3 mt-3 justify-content-start">
                        <button type="button" id="related-products-prev" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-transparent hover-text-white slick-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                        <button type="button" id="related-products-next" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-transparent hover-text-white slick-arrow">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-4">
                <p class="text-muted small mb-0">لا توجد منتجات ذات صلة حالياً.</p>
            </div>
        @endif

        {{-- العودة --}}
        <div class="pt-3">
            @if($product->category)
                <a href="{{ route('frontend.products.index', ['category' => $product->category->slug]) }}" class="fw-semibold d-inline-flex align-items-center gap-2 hover-text-brand">
                    <i class="fas fa-arrow-right"></i> عرض المزيد من {{ $product->category->name }}
                </a>
            @else
                <a href="{{ route('frontend.products.index') }}" class="fw-semibold d-inline-flex align-items-center gap-2 hover-text-brand">
                    <i class="fas fa-arrow-right"></i> العودة للمنتجات
                </a>
            @endif
        </div>
    </div>
</section>

@push('scripts')
    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
    <script>
    (function() {
        // Product image gallery thumbs
        document.querySelectorAll('.product-thumb').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var src = this.getAttribute('data-src');
                if (src) {
                    document.getElementById('productMainImage').src = src;
                    document.querySelectorAll('.product-thumb').forEach(function(b) { b.classList.remove('active', 'border-base', 'border-2'); b.classList.add('border'); });
                    this.classList.add('active', 'border-base', 'border-2');
                    this.classList.remove('border');
                }
            });
        });

        // Related products slider
        @if($relatedProducts->isNotEmpty())
        if (typeof jQuery !== 'undefined' && jQuery('.related-products-slider').length) {
            jQuery('.related-products-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: false,
                speed: 500,
                dots: false,
                arrows: true,
                appendArrows: '#related-products-arrows',
                rtl: true,
                prevArrow: '#related-products-prev',
                nextArrow: '#related-products-next',
                responsive: [
                    { breakpoint: 1199, settings: { slidesToShow: 3 } },
                    { breakpoint: 767, settings: { slidesToShow: 2 } },
                    { breakpoint: 575, settings: { slidesToShow: 1 } }
                ]
            });
        }
        @endif
    })();
    </script>
@endpush
@endsection
