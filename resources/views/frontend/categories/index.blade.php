@extends('frontend.layouts.app')

@section('title', 'التصنيفات')
@section('content')
{{-- بنر الصفحة --}}
<section class="products-page-banner bg-img bg-overlay style-three position-relative z-index-2 d-flex align-items-center justify-content-center" data-background-image="{{ asset('frontend/assets/img/bg/breadcrumb-bg.png') }}" style="min-height: 320px;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-3">التصنيفات</h1>
                <p class="text-neutral-20 mb-0">تصفح تصنيفات منتجاتنا وخدماتنا في مجال إعادة تدوير النفايات الإلكترونية</p>
            </div>
        </div>
    </div>
</section>

<section class="space py-60" style="padding-top: 80px !important;">
    <div class="container">
        {{-- فلاتر: نوع العرض + بحث --}}
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3 mb-50">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('frontend.categories.index', request()->only('search')) }}" class="btn {{ !request('type') ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-4">
                    الكل
                </a>
                <a href="{{ route('frontend.categories.index', array_merge(request()->only('search'), ['type' => 'root'])) }}" class="btn {{ request('type') === 'root' ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-4">
                    أساسية فقط
                </a>
            </div>
            <form action="{{ route('frontend.categories.index') }}" method="GET" class="d-flex align-items-center gap-2">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                <input type="text" name="search" class="form-control" style="width: 220px" placeholder="بحث بالاسم..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary rounded-pill px-4">بحث</button>
            </form>
        </div>

        @if($categories->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">لا توجد تصنيفات تطابق البحث.</p>
                <a href="{{ route('frontend.categories.index') }}" class="btn btn-primary mt-3">عرض جميع التصنيفات</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($categories as $category)
                <div class="col-lg-4 col-md-6">
                    <div class="scale-hover-item bg-neutral-20 radius-12-px overflow-hidden h-100 border border-neutral-100">
                        <div class="overflow-hidden position-relative">
                            <a href="{{ route('frontend.products.index', ['category' => $category->slug]) }}" class="d-block">
                                <img src="{{ $category->display_image_url }}" alt="{{ $category->name }}" class="w-100 fit-img transition-2" style="height: 220px; object-fit: cover;">
                            </a>
                            @if($category->parent)
                                <span class="badge bg-secondary position-absolute top-0 end-0 m-3">{{ $category->parent->name }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="mb-3">
                                <a href="{{ route('frontend.products.index', ['category' => $category->slug]) }}" class="link text-line-2 hover-text-brand text-dark">{{ $category->name }}</a>
                            </h4>
                            @if($category->description)
                                <p class="text-neutral-500 mb-3">{{ Str::limit(strip_tags($category->description), 100) }}</p>
                            @endif
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <span class="text-muted small">{{ $category->products_count }} منتج</span>
                                <a href="{{ route('frontend.products.index', ['category' => $category->slug]) }}" class="fw-semibold text-base d-inline-flex align-items-center gap-2 hover-text-brand">
                                    عرض المنتجات <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
