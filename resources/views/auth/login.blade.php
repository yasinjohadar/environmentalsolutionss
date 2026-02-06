@extends('frontend.layouts.app')

@section('title', 'تسجيل الدخول')
@section('body_class', 'auth-page')
@section('content')
<section class="products-page-banner bg-img bg-overlay style-three position-relative z-index-2 d-flex align-items-center justify-content-center" data-background-image="{{ asset('frontend/assets/img/bg/breadcrumb-bg.png') }}" style="min-height: 280px;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-3">تسجيل الدخول</h1>
                <p class="text-neutral-20 mb-0">ادخل إلى لوحة التحكم</p>
            </div>
        </div>
    </div>
</section>

<section class="space py-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
                <div class="bg-white border border-neutral-100 radius-12-px shadow-sm p-4 p-lg-5">
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="auth-form">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-dark">{{ __('البريد الإلكتروني') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg border-neutral-100 radius-8-px @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@example.com" dir="ltr">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-dark">{{ __('كلمة المرور') }}</label>
                            <input id="password" type="password" class="form-control form-control-lg border-neutral-100 radius-8-px @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="********" dir="ltr">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input border-base" name="remember">
                                <label for="remember_me" class="form-check-label text-neutral-600">
                                    {{ __('تذكرني') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-base hover-text-brand text-decoration-none">
                                    {{ __('نسيت كلمة المرور؟') }}
                                </a>
                            @endif
                            <button type="submit" class="btn global-btn arrow-btn fw-bold style2 text-white px-5 radius-8 border-0">
                                {{ __('تسجيل الدخول') }} <i class="fas fa-arrow-left ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.auth-page .form-control:focus {
    border-color: var(--theme-color);
    box-shadow: 0 0 0 0.2rem rgba(0, 72, 124, 0.15);
}
.auth-page .form-check-input:checked {
    background-color: var(--theme-color);
    border-color: var(--theme-color);
}
.auth-page .btn.global-btn {
    background: var(--theme-color) !important;
}
.auth-page .btn.global-btn:hover {
    background: var(--dark-color) !important;
    color: #fff !important;
}
</style>
@endpush
@endsection
