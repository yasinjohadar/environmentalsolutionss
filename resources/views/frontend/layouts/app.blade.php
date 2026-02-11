<!doctype html>
<html class="no-js" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'المدونة')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/assets/img/favicons/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&family=Inter:ital,opsz,wght@0,14..32,100..900&family=Mulish:ital,wght@0,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    @stack('styles')
    @stack('meta')
</head>
<body class="body-white bg-white @yield('body_class')">
    @php $s = $siteSettings ?? null; @endphp
    @if(trim($__env->yieldContent('body_class')) !== 'page-home')
    <div class="preloader">
        <div class="preloader-inner">
            <span class="loader"></span>
        </div>
    </div>

    <div class="mobile-menu-wrapper">
        <div class="mobile-menu-area">
            <div class="mobile-logo">
                <a href="{{ route('home') }}"><img src="{{ $s?->logo_url ?? asset('frontend/assets/img/logo.svg') }}" alt="{{ $s?->site_name ?? '' }}"></a>
                <button class="menu-toggle"><i class="fa fa-times"></i></button>
            </div>
            <div class="mobile-menu">
                <ul>
                    <li><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li><a href="{{ route('frontend.about.index') }}">من نحن</a></li>
                    <li><a href="{{ route('frontend.products.index') }}">المنتجات</a></li>
                    <li><a href="{{ route('frontend.categories.index') }}">التصنيفات</a></li>
                    <li><a href="{{ route('frontend.blog.index') }}">المدونة</a></li>
                    <li><a href="{{ route('frontend.ewaste.request') }}">طلب جمع / تبرع</a></li>
                    <li><a href="{{ route('frontend.contact.index') }}">اتصل بنا</a></li>
                </ul>
            </div>
        </div>
    </div>

    <header class="my-header top-0 py-lg-0 py-3 header-one-wrapper nav-header header-layout4 bg-title border-bottom border-white-25">
        <div class="sticky-wrapper">
            <div class="container custom-container--xl">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <a href="{{ route('home') }}"><img src="{{ $s?->logo_dark_url ?? $s?->logo_url ?? asset('frontend/assets/img/logo-white-2.png') }}" alt="{{ $s?->site_name ?? 'logo' }}"></a>
                    </div>
                    <div class="col-auto">
                        <nav class="main-menu d-none d-lg-inline-block">
                            <ul>
                                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                                <li><a href="{{ route('frontend.about.index') }}">من نحن</a></li>
                                <li><a href="{{ route('frontend.products.index') }}">المنتجات</a></li>
                                <li><a href="{{ route('frontend.categories.index') }}">التصنيفات</a></li>
                                <li><a href="{{ route('frontend.blog.index') }}">المدونة</a></li>
                                <li><a href="{{ route('frontend.ewaste.request') }}">طلب جمع / تبرع</a></li>
                                <li><a href="{{ route('frontend.contact.index') }}">اتصل بنا</a></li>
                            </ul>
                        </nav>
                        <div class="navbar-right d-inline-flex d-lg-none">
                            <button type="button" class="menu-toggle icon-btn"><i class="fas fa-bars"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @endif

    @yield('content')

    @include('frontend.partials.footer')

    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
        </svg>
    </div>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
</body>
</html>
