@extends('frontend.layouts.app')

@section('title', 'المدونة - آخر المقالات والأخبار')
@section('content')
{{-- بنر الصفحة --}}
<section class="products-page-banner bg-img bg-overlay style-three position-relative z-index-2 d-flex align-items-center justify-content-center" data-background-image="{{ asset('frontend/assets/img/bg/breadcrumb-bg.png') }}" style="min-height: 320px;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-3">المدونة</h1>
                <p class="text-neutral-20 mb-0">آخر المقالات والأخبار</p>
            </div>
        </div>
    </div>
</section>

<section class="space py-60" style="padding-top: 80px !important;">
    <div class="container">
        {{-- البحث --}}
        <form action="{{ route('frontend.blog.index') }}" method="get" class="mb-4">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if(request('tag'))
                <input type="hidden" name="tag" value="{{ request('tag') }}">
            @endif
            <div class="input-group rounded-pill overflow-hidden shadow-sm" style="max-width: 400px;">
                <input type="text" name="q" class="form-control border-0" placeholder="بحث في المدونة..." value="{{ request('q') }}" aria-label="بحث">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        {{-- فلاتر التصنيفات والوسوم --}}
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mb-50">
            <a href="{{ route('frontend.blog.index', request()->only('q')) }}" class="btn {{ !request('category') && !request('tag') ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-4">
                جميع المقالات
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('frontend.blog.index', ['category' => $cat->slug] + request()->only('q')) }}" class="btn {{ request('category') == $cat->slug ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-4">
                    {{ $cat->name }}
                </a>
            @endforeach
            @foreach($tags as $tag)
                <a href="{{ route('frontend.blog.index', ['tag' => $tag->slug] + request()->only('q')) }}" class="btn {{ request('tag') == $tag->slug ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-4">
                    {{ $tag->name }}
                </a>
            @endforeach
        </div>

        @if($posts->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">لا توجد مقالات في هذا التصفية حالياً.</p>
                <a href="{{ route('frontend.blog.index') }}" class="btn btn-primary mt-3">عرض جميع المقالات</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="scale-hover-item bg-neutral-20 radius-12-px overflow-hidden h-100 border border-neutral-100">
                        <div class="overflow-hidden position-relative">
                            <a href="{{ route('frontend.blog.show', $post->slug) }}" class="d-block">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->featured_image_alt ?? $post->title }}" class="scale-hover-item__img radius-12-px fit-img transition-2 w-100" style="height: 220px; object-fit: cover;">
                            </a>
                            @if($post->category)
                                <span class="badge bg-base-two position-absolute top-0 end-0 m-3">{{ $post->category->name }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="mb-3">
                                <a href="{{ route('frontend.blog.show', $post->slug) }}" class="link text-line-2 hover-text-brand text-dark">{{ $post->title }}</a>
                            </h4>
                            <p class="text-neutral-500 mb-3">{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 120) }}</p>
                            <div class="d-flex align-items-center gap-3 text-neutral-500 text-sm flex-wrap">
                                <span><i class="far fa-user-circle me-1"></i> {{ $post->author?->name ?? 'مدير' }}</span>
                                <span><i class="far fa-calendar me-1"></i> {{ $post->published_at?->format('Y-m-d') }}</span>
                            </div>
                            <a href="{{ route('frontend.blog.show', $post->slug) }}" class="fw-semibold text-base d-inline-flex align-items-center gap-2 hover-text-brand mt-3">
                                اقرأ المزيد <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-5 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
