@extends('frontend.layouts.app')

@section('title', $post->meta_title ?? $post->title)
@section('content')
<section class="space py-120">
    <div class="container">
        <article class="max-w-900 mx-auto">
            @if($post->featured_image)
            <div class="mb-4 radius-12-px overflow-hidden">
                <img src="{{ $post->featured_image_url }}" alt="{{ $post->featured_image_alt ?? $post->title }}" class="w-100 fit-img" style="max-height: 450px; object-fit: cover;">
            </div>
            @endif
            <div class="d-flex align-items-center gap-3 text-neutral-500 mb-4 flex-wrap">
                <span><i class="far fa-user-circle me-1"></i> {{ $post->author?->name ?? 'مدير' }}</span>
                <span><i class="far fa-calendar me-1"></i> {{ $post->published_at?->format('Y-m-d') }}</span>
                @if($post->reading_time)
                <span><i class="far fa-clock me-1"></i> {{ $post->reading_time }} دقائق قراءة</span>
                @endif
                <span><i class="far fa-eye me-1"></i> {{ number_format($post->views_count ?? 0) }} مشاهدة</span>
            </div>
            <h1 class="mb-4">{{ $post->title }}</h1>
            @if($post->excerpt)
            <p class="lead text-neutral-500 mb-4">{{ $post->excerpt }}</p>
            @endif
            <div class="post-content">
                {!! $post->content !!}
            </div>
            <div class="mt-5 pt-4 border-top">
                <a href="{{ route('frontend.blog.index') }}" class="fw-semibold text-base d-inline-flex align-items-center gap-2 hover-text-brand">
                    <i class="fas fa-arrow-right"></i> العودة للمدونة
                </a>
            </div>
        </article>
    </div>
</section>
@endsection
