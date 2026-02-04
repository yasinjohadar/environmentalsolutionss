@extends('frontend.layouts.app')

@section('title', 'المدونة')
@section('content')
<section class="space py-120">
    <div class="container">
        <div class="section-heading max-w-804 mx-auto text-center mb-60">
            <h2 class="mb-24">المدونة</h2>
            <p class="mb-0">آخر المقالات والأخبار</p>
        </div>
        @if($posts->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">لا توجد مقالات منشورة حالياً.</p>
                <a href="{{ route('home') }}" class="btn btn-primary mt-3">العودة للرئيسية</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="scale-hover-item bg-neutral-20 radius-12-px overflow-hidden h-100">
                        <div class="course-item__thumb radius-12-px overflow-hidden position-relative">
                            <a href="{{ route('frontend.blog.show', $post->slug) }}" class="w-100 h-100 d-block">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->featured_image_alt ?? $post->title }}" class="scale-hover-item__img radius-12-px fit-img transition-2 w-100" style="height: 220px; object-fit: cover;">
                            </a>
                        </div>
                        <div class="p-4">
                            <h4 class="mb-3">
                                <a href="{{ route('frontend.blog.show', $post->slug) }}" class="link text-line-2 hover-text-brand">{{ $post->title }}</a>
                            </h4>
                            <p class="text-neutral-500 mb-3">{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 120) }}</p>
                            <div class="d-flex align-items-center gap-3 text-neutral-500 text-sm">
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
