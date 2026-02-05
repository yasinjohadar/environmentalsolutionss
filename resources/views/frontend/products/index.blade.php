@extends('frontend.layouts.app')

@section('title', 'المنتجات - معرض منتجاتنا')
@section('content')
{{-- بنر الصفحة --}}
<section class="products-page-banner bg-img bg-overlay style-three position-relative z-index-2 d-flex align-items-center justify-content-center" data-background-image="{{ asset('frontend/assets/img/bg/breadcrumb-bg.png') }}" style="min-height: 320px;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-3">معرض المنتجات</h1>
                <p class="text-neutral-20 mb-0">تشكيلة من منتجاتنا وخدماتنا في مجال إعادة تدوير النفايات الإلكترونية</p>
            </div>
        </div>
    </div>
</section>

<section class="space py-60" style="padding-top: 80px !important;">
    <div class="container">
        @if(request('q'))
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <p class="mb-0 text-muted">نتائج البحث عن: <strong>{{ request('q') }}</strong></p>
                <a href="{{ route('frontend.products.index', request()->only('category')) }}" class="btn btn-outline-secondary btn-sm rounded-pill">مسح البحث</a>
            </div>
        @endif

        {{-- فلاتر التصنيفات --}}
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mb-50">
            <a href="{{ route('frontend.categories.index') }}" class="btn btn-outline-primary rounded-pill px-4 me-2">عرض التصنيفات</a>
            <a href="{{ route('frontend.products.index', request()->only('q')) }}" class="btn {{ !request('category') ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-4">
                جميع المنتجات
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('frontend.products.index', ['category' => $cat->slug] + request()->only('q')) }}" class="btn {{ request('category') == $cat->slug ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-4">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        @if($products->isEmpty())
            <div class="text-center py-5">
                @if(request('q'))
                    <p class="text-muted">لا توجد منتجات تطابق البحث. جرّب تغيير الكلمات أو التصنيف.</p>
                    <a href="{{ route('frontend.products.index', request()->only('category')) }}" class="btn btn-outline-primary mt-3 me-2">مسح البحث</a>
                @else
                    <p class="text-muted">لا توجد منتجات في هذا التصنيف حالياً.</p>
                @endif
                <a href="{{ route('frontend.products.index') }}" class="btn btn-primary mt-3">عرض جميع المنتجات</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="scale-hover-item bg-neutral-20 radius-12-px overflow-hidden h-100 border border-neutral-100">
                        <div class="overflow-hidden position-relative">
                            <a href="{{ route('frontend.products.show', $product->slug) }}" class="d-block">
                                <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="w-100 fit-img transition-2" style="height: 220px; object-fit: cover;">
                            </a>
                            @if($product->category)
                                <span class="badge bg-base-two position-absolute top-0 end-0 m-3">{{ $product->category->name }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="mb-3">
                                <a href="{{ route('frontend.products.show', $product->slug) }}" class="link text-line-2 hover-text-brand text-dark">{{ $product->name }}</a>
                            </h4>
                            <p class="text-neutral-500 mb-3">{{ Str::limit($product->short_description ?? strip_tags($product->description ?? ''), 120) }}</p>
                            <a href="{{ route('frontend.products.show', $product->slug) }}" class="fw-semibold text-base d-inline-flex align-items-center gap-2 hover-text-brand">
                                عرض التفاصيل <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
