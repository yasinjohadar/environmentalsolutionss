@php
$s = $siteSettings ?? null;
$h = $homeContent ?? [];
$homeUrl = function($key, $default = '') use ($h) { $path = data_get($h, $key); return $path ? \App\Models\HomePageSetting::imageUrl($path) : ($default ? asset($default) : null); };
$homeText = fn($key, $default = '') => e(data_get($h, $key) ?: $default);
@endphp
<!doctype html>
<html class="no-js" dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $s?->site_name ?? 'إعادة تدوير النفايات الإلكترونية' }} - حلول بيئية متكاملة</title>
    <meta name="description" content="خدمات إعادة تدوير النفايات الإلكترونية بأمان - جمع، إتلاف بيانات، إعادة تدوير وفق المعايير البيئية">
    <meta name="keywords" content="إعادة تدوير، نفايات إلكترونية، التخلص الآمن، السعودية">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $s?->favicon_url ?? asset('frontend/assets/img/favicons/favicon.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Nothing+You+Could+Do&display=swap" rel="stylesheet">



    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="frontend/assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="frontend/assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="frontend/assets/css/magnific-popup.min.css">
    <!-- Slick Slider -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">
    <!-- Swiper -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper.css') }}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <style>
    /* حركات بسيطة عند التمرير */
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .animate-on-scroll.animate-in {
        opacity: 1;
        transform: translateY(0);
    }
    .animate-on-scroll.animate-from-start {
        transform: translateY(24px) translateX(20px);
    }
    .animate-on-scroll.animate-from-start.animate-in {
        transform: translateY(0) translateX(0);
    }
    .animate-on-scroll.animate-from-end {
        transform: translateY(24px) translateX(-20px);
    }
    .animate-on-scroll.animate-from-end.animate-in {
        transform: translateY(0) translateX(0);
    }
    @media (prefers-reduced-motion: reduce) {
        .animate-on-scroll, .animate-on-scroll.animate-in,
        .animate-on-scroll.animate-from-start, .animate-on-scroll.animate-from-start.animate-in,
        .animate-on-scroll.animate-from-end, .animate-on-scroll.animate-from-end.animate-in {
            transition: none; opacity: 1; transform: none;
        }
    }
    </style>

</head>

<body class="body-white bg-white">
    <!--********************************
   		Code Start From Here 
	******************************** -->




    <!--==============================
     Preloader
    ==============================-->
    <div class="preloader ">
        <div class="preloader-inner">
            <span class="loader"></span>
        </div>
    </div>

    <!--==============================
    Sidemenu
    ============================== -->
    <div class="sidemenu-wrapper sidemenu-info ">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="fas fa-times"></i></button>
            <div class="widget  ">
                <div class="th-widget-about">
                    <div class="about-logo">
                        <a href="{{ route('home') }}"><img src="{{ $s?->logo_url ?? asset('frontend/assets/img/logo.svg') }}" alt="{{ $s?->site_name ?? '' }}"></a>
                    </div>
                    <p class="about-text">{{ $s->footer_description ?? 'نقدم خدمات متخصصة في إعادة تدوير النفايات الإلكترونية وجمعها والتخلص الآمن منها وفق أعلى المعايير البيئية.' }}</p>
                    <div class="social-links">
                        @foreach(($s?->social_links ?? []) as $platform => $data)
                        <a href="{{ $data['url'] }}" target="_blank" rel="noopener"><i class="{{ $data['icon'] }}"></i></a>
                        @endforeach
                        @if(empty($s?->social_links))
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="side-info mb-30">
                @if($s?->address)
                <div class="contact-list mb-20">
                    <h4>العنوان</h4>
                    <p>{{ $s->address }}</p>
                </div>
                @endif
                @if($s?->phone)
                <div class="contact-list mb-20">
                    <h4>رقم الهاتف</h4>
                    <p class="mb-0"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $s->phone) }}">{{ $s->phone }}</a></p>
                </div>
                @endif
                @if($s?->email)
                <div class="contact-list mb-20">
                    <h4>البريد الإلكتروني</h4>
                    <p class="mb-0"><a href="mailto:{{ $s->email }}">{{ $s->email }}</a></p>
                </div>
                @endif
                @if(!$s?->address && !$s?->phone && !$s?->email)
                <div class="contact-list mb-20">
                    <h4>العنوان</h4>
                    <p>المملكة العربية السعودية</p>
                </div>
                <div class="contact-list mb-20">
                    <h4>رقم الهاتف</h4>
                    <p class="mb-0">(205) 555-0100</p>
                </div>
                <div class="contact-list mb-20">
                    <h4>البريد الإلكتروني</h4>
                    <p class="mb-0">info@example.com</p>
                </div>
                @endif
            </div>
            <ul class="side-instagram list-wrap">
                @for($i = 0; $i < 4; $i++)
                <li><a href="project.html"><img src="{{ $homeUrl("sidemenu_gallery.$i", 'frontend/assets/img/gallery/' . ($i+1) . '.jpg') }}" alt=""></a></li>
                @endfor
            </ul>
        </div>
    </div>
    <div class="popup-search-box">
        <button class="searchClose"><i class="fas fa-times"></i></button>
        <form action="{{ route('frontend.products.index') }}" method="get">
            <input type="text" name="q" placeholder="بحث عن منتجات..." value="{{ request('q') }}" aria-label="بحث">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <!--==============================
    Mobile Menu
    ============================== -->
    <div class="mobile-menu-wrapper">
        <div class="mobile-menu-area">
            <div class="mobile-logo">
                <a href="{{ route('home') }}"><img src="{{ $s?->logo_url ?? asset('frontend/assets/img/logo.svg') }}" alt="{{ $s?->site_name ?? '' }}"></a>
                <button class="menu-toggle"><i class="fa fa-times"></i></button>
            </div>
            <div class="mobile-menu">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">الرئيسية</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.about.index') }}">من نحن</a>
                    </li>
                    <li>
                        <a href="service.html">الخدمات</a>
                    </li>
                    <li>
                        <a href="project.html">المشاريع</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.products.index') }}">المنتجات</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.categories.index') }}">التصنيفات</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.blog.index') }}">المدونة</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.ewaste.request') }}">طلب جمع / تبرع</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.contact.index') }}">اتصل بنا</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    
    <!--==============================
	Header Area Start
    ==============================-->
    <header class="my-header top-0 py-lg-0 py-3 header-one-wrapper nav-header header-layout4 bg-transparent border-bottom border-white-25">
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="container custom-container--xl">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <!-- Logo Start -->
                        <a href="{{ route('home') }}" class="">
                            <img src="{{ $s?->logo_dark_url ?? $s?->logo_url ?? asset('frontend/assets/img/logo-white-2.png') }}" alt="{{ $s?->site_name ?? 'logo' }}">
                        </a>
                        <!-- Logo End -->
                    </div>
                    <div class="col-auto">
                        <nav class="main-menu d-none d-lg-inline-block">
                            <ul>
                                <li>
                                    <a href="{{ route('home') }}">الرئيسية</a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.about.index') }}">من نحن</a>
                                </li>
                                <li>
                                    <a href="service.html">الخدمات</a>
                                </li>
                                <li>
                                    <a href="project.html">المشاريع</a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.products.index') }}">المنتجات</a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.categories.index') }}">التصنيفات</a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.blog.index') }}">المدونة</a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.ewaste.request') }}">طلب جمع / تبرع</a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.contact.index') }}">اتصل بنا</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="navbar-right d-inline-flex d-lg-none">
                            <button type="button" class="menu-toggle icon-btn"><i class="fas fa-bars"></i></button>
                        </div>
                    </div>
                    <div class="col-auto d-lg-block d-none">
                        <div class="d-flex align-items-center gap-4">
                            <form action="{{ route('frontend.products.index') }}" method="get" class="position-relative max-w-300-px w-100 d-xxl-block d-none">
                                <input type="text" name="q" class="bg-neutral-700 ps-24-px py-4-px text-white radius-8-px h-56-px placeholder-white border border-transparent focus-border-base-two pe-48-px" placeholder="بحث عن منتجات..." value="{{ request('q') }}" aria-label="بحث">
                                <button type="submit" class="w-32-px h-32-px text-12 bg-base-two d-flex justify-content-center align-items-center radius-4-px position-absolute end-0 top-50 translate-middle-y me-12-px">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                            <a href="{{ route('frontend.ewaste.request') }}" class="global-btn arrow-btn fw-bold style3 text-black hover-text-white px-4 rounded d-flex align-items-center gap-2 flex-shrink-0">
                                طلب جمع / تبرع
                                <i class="fas fa-arrow-right rotate-icon d-xl-flex d-none"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
      <!--==============================
	Header Area End
    ==============================-->

    
    <!-- ================================= Banner Section Start =============================== -->
    @php $heroSlides = $heroSlides ?? collect(); @endphp
    @if($heroSlides->isNotEmpty())
    <section class="homeCone-banner hero-swiper-section overflow-hidden" style="height: 750px; min-height: 750px;">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                @foreach($heroSlides as $slide)
                <div class="swiper-slide">
                    <div class="slide-bg" style="background-image: url('{{ $slide->background_image_url }}');"></div>
                    <div class="slide-overlay bg-overlay gradient-overlay"></div>
                    <div class="slide-content-wrapper position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
                        <div class="container">
                            <div class="position-relative banner-one__inner">
                                <div class="row">
                                    <div class="col-xxl-7 col-md-8">
                                        <div class="banner-content">
                                            @if($slide->subtitle)
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <img src="{{ $homeUrl('banner_fallback.arrow_icon') }}" alt="" class="">
                                                <h4 class="text-brand mb-0">{{ $slide->subtitle }}</h4>
                                            </div>
                                            @endif
                                            @if($slide->title)
                                            <h2 class="sec-title fw-semibold style2 text-capitalize text-white mt-4 text-80 mb-4 pb-2">
                                                {!! nl2br(e($slide->title)) !!}
                                            </h2>
                                            @endif
                                            @if($slide->description)
                                            <p class="text-white text-xl">{{ $slide->description }}</p>
                                            @endif
                                            @if($slide->button1_text || $slide->button2_text)
                                            <div class="d-flex flex-wrap align-items-center gap-20 mt-40">
                                                @if($slide->button1_text)
                                                <a href="{{ $slide->button1_url ?? '#' }}" class="global-btn arrow-btn fw-bold style3 text-black hover-text-white px-4 radius-8 d-flex align-items-center gap-2">
                                                    {{ $slide->button1_text }} <i class="fas fa-arrow-right rotate-icon"></i>
                                                </a>
                                                @endif
                                                @if($slide->button2_text)
                                                <a href="{{ $slide->button2_url ?? '#' }}" class="global-btn style-border3 hover-text-black">{{ $slide->button2_text }} <i class="fas fa-arrow-right ms-2"></i></a>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>
    @else
    <section class="homeCone-banner bg-overlay gradient-overlay overflow-hidden bg-img" data-background-image="{{ $homeUrl('banner_fallback.image', 'frontend/assets/img/slider/slide1.webp') }}" style="height: 750px; min-height: 750px;">
        <h1 class="text-outline-white writing-mode position-absolute top-50 translate-y-middle-rotate text-white text-opacity-25 text-uppercase margin-left-80 z-index-2">إعادة التدوير</h1>
        <img src="{{ $homeUrl('banner_fallback.cross_shape', 'frontend/assets/img/HomeCone/shape/cross-shape.png') }}" alt="" class="cross-shape position-absolute top-50 translate-middle-y end-20">
        <ul class="animation-line d-none d-md-flex justify-content-between">
            <li class="animation-line__item"></li>
            <li class="animation-line__item"></li>
            <li class="animation-line__item"></li>
            <li class="animation-line__item"></li>
        </ul>
        <div class="container">
            <div class="position-relative banner-one__inner">
                <div class="row">
                    <div class="col-xxl-7 col-md-8">
                        <div class="banner-content">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $homeUrl('banner_fallback.arrow_icon', 'frontend/assets/img/HomeCone/icon/arrow-icon.png') }}" alt="" class="">
                                <h4 class="text-brand mb-0">{{ $homeText('banner_fallback.subtitle', 'نحن خبراء في المجال') }}</h4>
                            </div>
                            <h2 class="sec-title fw-semibold style2 text-capitalize text-white mt-4 text-80 mb-4 pb-2">
                                {{ $homeText('banner_fallback.title', 'حلول متكاملة النفايات الإلكترونية') }} <span class="bg-base-two radius-8 text-neutral-700 fw-semibold p-1">{{ $homeText('banner_fallback.title_highlight', 'إعادة تدوير') }}</span>
                            </h2>
                            <p class="text-white text-xl">{{ $homeText('banner_fallback.description', 'نقدم خدمات شاملة لجمع وإعادة تدوير النفايات الإلكترونية بطرق آمنة وصديقة للبيئة.') }}</p>
                            <div class="d-flex flex-wrap align-items-center gap-20 mt-40">
                                <a href="{{ $homeText('banner_fallback.button1_url', 'project.html') }}" class="global-btn arrow-btn fw-bold style3 text-black hover-text-white px-4 radius-8 d-flex align-items-center gap-2">
                                    {{ $homeText('banner_fallback.button1_text', 'اكتشف المزيد') }} <i class="fas fa-arrow-right rotate-icon"></i>
                                </a>
                                <a href="{{ $homeText('banner_fallback.button2_url') ?: route('frontend.about.index') }}" class="global-btn style-border3 hover-text-black">{{ $homeText('banner_fallback.button2_text', 'من نحن') }} <i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- ================================= Banner Section End =============================== -->

     
    <!-- ================================= Service Section Start =============================== -->
     <section class="homeC-service space">
        <div class="container">
            <div class="section-heading max-w-804 mx-auto text-center mb-60 animate-on-scroll">
                <div class="d-inline-flex align-items-center gap-2 text-base mb-3">
                    <img src="{{ $homeUrl('services.arrow_icon', 'frontend/assets/img/HomeCone/icon/arrow-icon-two.png') }}" alt="" class="">
                    <h4 class="mb-0 text-base">{{ $homeText('services.section_subtitle', 'نحن خبراء في المجال') }}</h4>
                </div>
                <h2 class="mb-24">{{ $homeText('services.section_title', 'خدمات إعادة تدوير النفايات الإلكترونية') }}</h2>
                <p class="mb-0">{{ $homeText('services.section_description', 'نقدم حلولاً متكاملة وآمنة لإدارة النفايات الإلكترونية، مع ضمان الامتثال للمعايير البيئية وضمان التخلص الآمن من البيانات الحساسة.') }}</p>
            </div>
            <div class="homeC-service-slider animate-on-scroll" data-animate-delay="80">
                <div class="px-3">
                    <div class="homeC-service-card homeC-service-item p-4 rounded-3 border border-neutral-100 bg-white shadow-sm">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                            <span class="homeC-service-item__icon text-base">
                                <i class="fas fa-truck-loading" style="font-size: 2rem;"></i>
                            </span>
                            <span class="text-neutral-40 fw-bold" style="font-size: 2.5rem; line-height: 1;">01</span>
                        </div>
                        <h3 class="mb-2 h5 fw-bold">الاستلام والنقل</h3>
                        <p class="homeC-service-card__desc text-neutral-500 small mb-3">نرتب عملية جمع النفايات الإلكترونية من أي جزء من المملكة، لأي نوع من المؤسسات، عبر شبكتنا الواسعة.</p>
                        <a href="service.html" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand mt-auto">اقرأ المزيد <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="px-3">
                    <div class="homeC-service-card homeC-service-item p-4 rounded-3 border border-neutral-100 bg-white shadow-sm">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                            <span class="homeC-service-item__icon text-base">
                                <i class="fas fa-recycle" style="font-size: 2rem;"></i>
                            </span>
                            <span class="text-neutral-40 fw-bold" style="font-size: 2.5rem; line-height: 1;">02</span>
                        </div>
                        <h3 class="mb-2 h5 fw-bold">التخلص الآمن وإعادة التدوير</h3>
                        <p class="homeC-service-card__desc text-neutral-500 small mb-3">عملية صديقة للبيئة تضمن التخلص وإعادة التدوير بنسبة 100% للإلكترونيات منتهية الصلاحية، مع الاتلاف الآمن للبيانات.</p>
                        <a href="service.html" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand mt-auto">اقرأ المزيد <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="px-3">
                    <div class="homeC-service-card homeC-service-item p-4 rounded-3 border border-neutral-100 bg-white shadow-sm">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                            <span class="homeC-service-item__icon text-base">
                                <i class="fas fa-handshake" style="font-size: 2rem;"></i>
                            </span>
                            <span class="text-neutral-40 fw-bold" style="font-size: 2.5rem; line-height: 1;">03</span>
                        </div>
                        <h3 class="mb-2 h5 fw-bold">حلول طويلة الأمد</h3>
                        <p class="homeC-service-card__desc text-neutral-500 small mb-3">اتفاقيات وعقود إدارة طويلة الأجل لإدارة المخلفات الإلكترونية بشكل مستمر وفعّال.</p>
                        <a href="service.html" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand mt-auto">اقرأ المزيد <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="px-3">
                    <div class="homeC-service-card homeC-service-item p-4 rounded-3 border border-neutral-100 bg-white shadow-sm">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                            <span class="homeC-service-item__icon text-base">
                                <i class="fas fa-boxes" style="font-size: 2rem;"></i>
                            </span>
                            <span class="text-neutral-40 fw-bold" style="font-size: 2.5rem; line-height: 1;">04</span>
                        </div>
                        <h3 class="mb-2 h5 fw-bold">الاسترجاع وإعادة التدوير</h3>
                        <p class="homeC-service-card__desc text-neutral-500 small mb-3">خدمة الإرجاع وإعادة تدوير الأجهزة الكهربائية والإلكترونية في المملكة ودول مجلس التعاون الخليجي.</p>
                        <a href="service.html" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand mt-auto">اقرأ المزيد <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="px-3">
                    <div class="homeC-service-card homeC-service-item p-4 rounded-3 border border-neutral-100 bg-white shadow-sm">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                            <span class="homeC-service-item__icon text-base">
                                <i class="fas fa-shield-alt" style="font-size: 2rem;"></i>
                            </span>
                            <span class="text-neutral-40 fw-bold" style="font-size: 2.5rem; line-height: 1;">05</span>
                        </div>
                        <h3 class="mb-2 h5 fw-bold">الإتلاف الآمن للبيانات</h3>
                        <p class="homeC-service-card__desc text-neutral-500 small mb-3">إتلاف البيانات بشكل آمن وفق أعلى المعايير الأمنية والبيئية لحماية معلوماتكم الحساسة.</p>
                        <a href="service.html" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand mt-auto">اقرأ المزيد <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="px-3">
                    <div class="homeC-service-card homeC-service-item p-4 rounded-3 border border-neutral-100 bg-white shadow-sm">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                            <span class="homeC-service-item__icon text-base">
                                <i class="fas fa-certificate" style="font-size: 2rem;"></i>
                            </span>
                            <span class="text-neutral-40 fw-bold" style="font-size: 2.5rem; line-height: 1;">06</span>
                        </div>
                        <h3 class="mb-2 h5 fw-bold">التوثيق والشهادات</h3>
                        <p class="homeC-service-card__desc text-neutral-500 small mb-3">تقديم تقارير وشهادات معتمدة تثبت التخلص الآمن والسليم من النفايات الإلكترونية.</p>
                        <a href="service.html" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand mt-auto">اقرأ المزيد <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="slick-arrows d-flex align-items-center gap-3 mt-40 justify-content-center">
                <button type="button" id="homeC-service-prev" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-transparent hover-text-white position-relative top-0 end-0 start-0 mt-0">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button type="button" id="homeC-service-next" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-transparent hover-text-white position-relative top-0 end-0 start-0 mt-0">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
     </section>
    <!-- ================================= Service Section End =============================== -->

     
    <!-- ================================= Choose Us Section Start =============================== -->
     <section class="homeC-choose-us space bg-neutral-20 position-relative">
        <h1 class="text-outline-neutral writing-mode position-absolute top-50 translate-middle-y text-white text-opacity-25 text-uppercase margin-right-80 z-index-2 h-100 text-center right-0">لماذا نحن</h1>

        <div class="container">
            <div class="row gy-4">
                <div class="col-xxl-5 col-xl-6 animate-on-scroll animate-from-end">
                    <div class="choose-us-thumbs position-relative">

                        <div class="circle bg-base-two border border-white">
                            <a href="https://www.youtube.com/watch?v=VCPGMjCW0is" class="magnific-video w-86-px h-86-px bg-base rounded-circle d-flex justify-content-center align-items-center text-xl text-base-two z-index-3">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>
                        
                        <div class="row gy-4">
                            <div class="col-sm-8">
                                <img src="{{ $homeUrl('choose_us.image1', 'frontend/assets/img/HomeCone/choose-us-img1.png') }}" alt="إعادة تدوير النفايات الإلكترونية" class="choose-us-thumbs__one radius-16-px w-100">
                            </div>
                            <div class="col-sm-4">
                                <div class="bg-base-two radius-12-px text-center py-32-px px-12-px mb-24 mb-16-px">    
                                    <h2 class="mb-16 d-flex"> <span class="counter-number">75</span>K+</h2>
                                    <span class="text-neutral-700 mb-16-px d-block fw-medium">عميل واثق من خدماتنا</span>
                                    <div class="peoples d-inline-flex">
                                        @for($i = 0; $i < 5; $i++)
                                        <div class="w-32-px h-32-px border border-2 border-base rounded-circle overflow-hidden">
                                            <img src="{{ $homeUrl("choose_us.people_images.$i", 'frontend/assets/img/HomeCone/people-img' . ($i+1) . '.png') }}" alt="" class="w-100 h-100 object-fit-cover">
                                        </div>
                                        @endfor
                                    </div>
                                </div>

                                <img src="{{ $homeUrl('choose_us.image2', 'frontend/assets/img/HomeCone/choose-us-img2.png') }}" alt="" class="choose-us-thumbs__two radius-16-px w-100">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-1 d-xxl-block d-none"></div>


                <div class="col-xl-6">
                    <div class="section-heading max-w-804 ms-0 text-start mb-40 animate-on-scroll animate-from-start">
                        <div class="d-inline-flex align-items-center gap-2 text-base mb-3">
                            <img src="{{ $homeUrl('choose_us.arrow_icon', 'frontend/assets/img/HomeCone/icon/arrow-icon-two.png') }}" alt="" class="">
                            <h4 class="mb-0 text-base">{{ $homeText('choose_us.title', 'لماذا تختارنا') }}</h4>
                        </div>
                        <h2 class="mb-24">{{ $homeText('choose_us.section_title', 'نحن الحل الأمثل لإدارة وإعادة تدوير النفايات الإلكترونية.') }}</h2>
                        <p class="mb-0">{{ $homeText('choose_us.description', 'نقدم حلولاً متكاملة وآمنة تلبي احتياجات مؤسستكم، مع ضمان الامتثال للمعايير البيئية وحماية بياناتكم الحساسة بثقة تامة.') }}</p>
                    </div>
                    <ul class="nav common-tabs nav-pills p-1 border border-nuetral-40 radius-8-px d-inline-flex mb-32-px" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-Mission-tab" data-bs-toggle="pill" data-bs-target="#pills-Mission" type="button" role="tab" aria-controls="pills-Mission" aria-selected="true">الرسالة</button>
                        </li>
                        <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-Approach-tab" data-bs-toggle="pill" data-bs-target="#pills-Approach" type="button" role="tab" aria-controls="pills-Approach" aria-selected="false">المنهجية</button>
                        </li>
                        <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-Vision-tab" data-bs-toggle="pill" data-bs-target="#pills-Vision" type="button" role="tab" aria-controls="pills-Vision" aria-selected="false">الرؤية</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-Mission" role="tabpanel" aria-labelledby="pills-Mission-tab" tabindex="0">
                            <div class="row gy-4 align-items-center">
                                <div class="col-sm-6">
                                    <div class="position-relative bg-overlay style-two radius-10-px overflow-hidden">
                                        <img src="{{ $homeUrl('choose_us.video_image', 'frontend/assets/img/HomeCone/video.png') }}" alt="فيديو إعادة التدوير" class="w-100 h-100 radius-10-px">
                                        <a href="{{ $homeText('choose_us.video_url', 'https://www.youtube.com/watch?v=VCPGMjCW0is') }}" class="play-button magnific-video position-absolute top-50 start-50 translate-middle d-flex flex-column gap-10 w-48-px h-48-px text-sm">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="ps-0 d-flex flex-column gap-3">
                                        @foreach(($h['choose_us']['mission']['items'] ?? ['التزامنا بحماية البيئة والتقليل من البصمة الكربونية', 'إعادة تدوير 100% من النفايات الإلكترونية المستلمة', 'الإتلاف الآمن للبيانات الحساسة وفق أعلى المعايير', 'الشفافية والموثوقية في كل خطوة من العملية']) as $item)
                                        <li class="d-flex align-items-center gap-2">
                                            <span class=""><img src="{{ $homeUrl('choose_us.check_icon', 'frontend/assets/img/HomeCone/check-icon.png') }}" alt=""></span>
                                            <span class="text-neutral-500 text-lg">{{ is_string($item) ? $item : ($item['text'] ?? '') }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-Approach" role="tabpanel" aria-labelledby="pills-Approach-tab" tabindex="0">
                            <div class="row gy-4 align-items-center">
                                <div class="col-sm-6">
                                    <div class="position-relative">
                                        <img src="{{ $homeUrl('choose_us.video_image', 'frontend/assets/img/HomeCone/video.png') }}" alt="منهجيتنا" class="w-100 h-100 radius-10-px">
                                        <a href="{{ $homeText('choose_us.video_url', 'https://www.youtube.com/watch?v=VCPGMjCW0is') }}" class="play-button magnific-video position-absolute top-50 start-50 translate-middle d-flex flex-column gap-10 w-48-px h-48-px text-sm">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="ps-0 d-flex flex-column gap-3">
                                        @foreach(($h['choose_us']['approach']['items'] ?? ['جمع النفايات من جميع أنحاء المملكة ودول الخليج', 'عمليات صديقة للبيئة ومعتمدة دولياً', 'توثيق كامل وشهادات التخلص الآمن', 'شراكات استراتيجية مع القطاعين العام والخاص']) as $item)
                                        <li class="d-flex align-items-center gap-2">
                                            <span class=""><img src="{{ $homeUrl('choose_us.check_icon', 'frontend/assets/img/HomeCone/check-icon.png') }}" alt=""></span>
                                            <span class="text-neutral-500 text-lg">{{ is_string($item) ? $item : ($item['text'] ?? '') }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-Vision" role="tabpanel" aria-labelledby="pills-Vision-tab" tabindex="0">
                            <div class="row gy-4 align-items-center">
                                <div class="col-sm-6">
                                    <div class="position-relative">
                                        <img src="{{ $homeUrl('choose_us.video_image', 'frontend/assets/img/HomeCone/video.png') }}" alt="رؤيتنا" class="w-100 h-100 radius-10-px">
                                        <a href="{{ $homeText('choose_us.video_url', 'https://www.youtube.com/watch?v=VCPGMjCW0is') }}" class="play-button magnific-video position-absolute top-50 start-50 translate-middle d-flex flex-column gap-10 w-48-px h-48-px text-sm">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="ps-0 d-flex flex-column gap-3">
                                        @foreach(($h['choose_us']['vision']['items'] ?? ['مستقبل خالٍ من النفايات الإلكترونية الضارة', 'ريادة في الاقتصاد الدائري والاستدامة', 'المساهمة في أهداف التنمية المستدامة 2030', 'التوعية المجتمعية بأهمية إعادة التدوير']) as $item)
                                        <li class="d-flex align-items-center gap-2">
                                            <span class=""><img src="{{ $homeUrl('choose_us.check_icon', 'frontend/assets/img/HomeCone/check-icon.png') }}" alt=""></span>
                                            <span class="text-neutral-500 text-lg">{{ is_string($item) ? $item : ($item['text'] ?? '') }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-xxl-5 gap-4 flex-wrap mt-40">
                        <a href="service.html" class="global-btn arrow-btn fw-bold style2 text-base-two px-4 radius-8 d-flex align-items-center gap-2">
                            اقرأ المزيد <i class="fas fa-arrow-right rotate-icon"></i>
                        </a>
                        <div class="d-flex align-items-center gap-4">
                            <span class="w-56-px h-56-px d-flex justify-content-center align-items-center radius-8 bg-brand text-neutral-700 text-2xl">
                                <i class="fas fa-headset"></i>
                            </span>
                            <div class="">
                                <span class="text-neutral-700 d-block">تواصل معنا</span>
                                <a href="tel:205-555-0100" class="text-neutral-700 fw-semibold text-lg d-block hover-text-brand">(205) 555-0100</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
     </section>
    <!-- ================================= Choose Us Section End =============================== -->

     
    <!-- ================================= Portfolio / Products Section Start =============================== -->
    @php $products = $products ?? collect(); @endphp
     <section class="homeC-portfolio space">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between mb-60 animate-on-scroll">
                <div class="section-heading max-w-804 ms-0 text-start">
                    <div class="d-inline-flex align-items-center gap-2 text-base mb-3">
                        <img src="{{ $homeUrl('services.arrow_icon', 'frontend/assets/img/HomeCone/icon/arrow-icon-two.png') }}" alt="" class="">
                        <h4 class="mb-0 text-base">معرض منتجاتنا</h4>
                    </div>
                    <h2 class="mb-0">منتجات وإنجازات إعادة التدوير</h2>
                </div>
                <div class="">
                    <p class="mb-24 max-w-416">نعرض لكم تشكيلة من منتجاتنا وخدماتنا في مجال إعادة تدوير النفايات الإلكترونية والتي تعكس التزامنا بالجودة والاستدامة.</p>
                    <a href="{{ route('frontend.products.index') }}" class="global-btn arrow-btn fw-bold style2 text-base-two px-5 radius-8 d-inline-flex align-items-center gap-2">
                        عرض جميع المنتجات <i class="fas fa-arrow-right rotate-icon"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="homeC-portfolio__inner d-flex position-relative overflow-hidden">    
            <div class="homeC-portfolio__left d-md-block d-none animate-on-scroll animate-from-end" data-animate-delay="100">
                <img src="{{ $homeUrl('portfolio.bg_image') }}" alt="" class="homeC-portfolio__bg">
                <div class="homeC-portfolio__data bg-base-two p-32-px">
                    <img src="{{ $homeUrl('portfolio.play_icon') }}" alt="">
                    <p class="text-neutral-700 mt-20 mb-0">{{ $homeText('portfolio.description', 'نعمل معكم بشكل وثيق لتطوير حلول متكاملة لإدارة النفايات الإلكترونية وتحقيق أهداف الاستدامة.') }}</p>
                </div>
            </div>
            <div class="homeC-portfolio__right z-index-3 ps-md-4 animate-on-scroll animate-from-start" data-animate-delay="150">
                <div class="padding-from-left d-flex align-items-center gap-1 mb-40">
                    <ul class="d-flex align-items-center gap-2 list-unstyled mb-0 p-0">
                        <li class="text-yellow"><i class="fas fa-star"></i></li>
                        <li class="text-yellow"><i class="fas fa-star"></i></li>
                        <li class="text-yellow"><i class="fas fa-star"></i></li>
                        <li class="text-yellow"><i class="fas fa-star"></i></li>
                        <li class="text-yellow"><i class="fas fa-star"></i></li>
                    </ul>
                    <span class="text-neutral-700 text-lg">(تقييمات العملاء)</span>
                </div>

                @if($products->isNotEmpty())
                <div class="homeC-portfolio-slider">
                    @foreach($products as $product)
                    <div class="mx-2">
                        <div class="homeC-portfolio__item radius-12-px overflow-hidden border border-neutral-100 bg-white">
                            <h4 class="mb-0 p-4 pb-0">{{ $product->name }}</h4>
                            <div class="p-4 pe-0 position-relative">
                                <a href="{{ route('frontend.products.show', $product->slug) }}" class="d-block">
                                    <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="w-100" style="height: 220px; object-fit: cover;">
                                </a>
                                <p class="p-4 me-4 text-neutral-700 bg-neutral-20 position-absolute start-0 bottom-0 mb--4 rounded-top-right-8">{{ Str::limit($product->short_description ?? $product->description, 80) }}</p>
                            </div>
                            <div class="p-4 pt-5">
                                <a href="{{ route('frontend.products.show', $product->slug) }}" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand" tabindex="0">
                                    اقرأ المزيد
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="homeC-portfolio-slider">
                    <div class="mx-2">
                        <div class="homeC-portfolio__item radius-12-px overflow-hidden border border-neutral-100 bg-white">
                            <h4 class="mb-0 p-4 pb-0">إعادة تدوير الحواسيب</h4>
                            <div class="p-4 pe-0 position-relative">
                                <a href="{{ route('frontend.products.index') }}" class="d-block">
                                    <img src="{{ $homeUrl('portfolio.image1', 'frontend/assets/img/HomeCone/portfolio-img1.png') }}" alt="" class="w-100">
                                </a>
                                <p class="p-4 me-4 text-neutral-700 bg-neutral-20 position-absolute start-0 bottom-0 mb--4 rounded-top-right-8">جمع وإعادة تدوير الحواسيب والأجهزة الإلكترونية القديمة بشكل آمن وصديق للبيئة.</p>
                            </div>
                            <div class="p-4 pt-5">
                                <a href="{{ route('frontend.products.index') }}" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand">اقرأ المزيد <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="mx-2">
                        <div class="homeC-portfolio__item radius-12-px overflow-hidden border border-neutral-100 bg-white">
                            <h4 class="mb-0 p-4 pb-0">تدوير الهواتف والأجهزة اللوحية</h4>
                            <div class="p-4 pe-0 position-relative">
                                <a href="{{ route('frontend.products.index') }}" class="d-block">
                                    <img src="{{ $homeUrl('portfolio.image2', 'frontend/assets/img/HomeCone/portfolio-img2.png') }}" alt="" class="w-100">
                                </a>
                                <p class="p-4 me-4 text-neutral-700 bg-neutral-20 position-absolute start-0 bottom-0 mb--4 rounded-top-right-8">التخلص الآمن من الهواتف مع ضمان إتلاف البيانات وإعادة تدوير المكونات.</p>
                            </div>
                            <div class="p-4 pt-5">
                                <a href="{{ route('frontend.products.index') }}" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand">اقرأ المزيد <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="mx-2">
                        <div class="homeC-portfolio__item radius-12-px overflow-hidden border border-neutral-100 bg-white">
                            <h4 class="mb-0 p-4 pb-0">تدوير الأجهزة الكهربائية</h4>
                            <div class="p-4 pe-0 position-relative">
                                <a href="{{ route('frontend.products.index') }}" class="d-block">
                                    <img src="{{ $homeUrl('portfolio.image3', 'frontend/assets/img/HomeCone/portfolio-img3.png') }}" alt="" class="w-100">
                                </a>
                                <p class="p-4 me-4 text-neutral-700 bg-neutral-20 position-absolute start-0 bottom-0 mb--4 rounded-top-right-8">معالجة الأجهزة الكهربائية المنزلية والتجارية وفق المعايير البيئية.</p>
                            </div>
                            <div class="p-4 pt-5">
                                <a href="{{ route('frontend.products.index') }}" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand">اقرأ المزيد <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="padding-from-left slick-arrows d-flex align-items-center gap-3 mt-40 justify-content-start">
                    <button type="button" id="homeC-portfolio-prev" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-transparent hover-text-white position-relative top-0 end-0 start-0 mt-0 slick-arrow">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button type="button" id="homeC-portfolio-next" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-transparent hover-text-white position-relative top-0 end-0 start-0 mt-0 slick-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

     </section>
    <!-- ================================= Portfolio Section End =============================== -->

    <!-- ================================= About Section Start =============================== -->
    <section class="homeC-about space overflow-hidden">
        <div class="container">

            <div class="homeC-about__bg position-relative bg-overlay style-two overflow-hidden animate-on-scroll">
                <img src="{{ $homeUrl('about_section.bg_image', 'frontend/assets/img/HomeCone/about-bg.png') }}" alt="" class="fit-img">
                <a href="https://www.youtube.com/watch?v=VCPGMjCW0is" class="play-button magnific-video position-absolute top-50 start-50 translate-middle d-flex flex-column gap-10 w-120-px h-120-px text-2xl bg-brand">
                    <i class="fas fa-play"></i>
                </a>
            </div>

            <div class="row align-items-end gy-4 z-index-3 position-relative animate-on-scroll" data-animate-delay="80">
                <div class="col-xl-8 col-lg-7">
                    <div class="row">
                        <div class="col-12">
                            <div class="py-80 bg-white px-110">
                                <div class="section-heading max-w-804 ms-0 text-start mb-40">
                                    <div class="d-inline-flex align-items-center gap-2 text-base mb-3">
                                        <img src="{{ $homeUrl('about_section.arrow_icon', 'frontend/assets/img/HomeCone/icon/arrow-icon-two.png') }}" alt="" class="">
                                        <h4 class="mb-0 text-base">{{ $homeText('about_section.subtitle', 'من نحن') }}</h4>
                                    </div>
                                    <h2 class="mb-24">{{ $homeText('about_section.title', 'حلول متكاملة لإعادة تدوير النفايات الإلكترونية') }}</h2>
                                    <p class="mb-0">{{ $homeText('about_section.description', 'نتبع نهجاً يراعي احتياجات كل عميل، ونعمل بشكل وثيق مع المؤسسات لفهم تحدياتهم وضمان التخلص الآمن والسليم من النفايات الإلكترونية.') }}</p>
                                </div>
                                <a href="{{ route('frontend.about.index') }}" class="global-btn arrow-btn fw-bold style2 text-base-two px-5 radius-8 d-inline-flex align-items-center gap-2">
                                    اقرأ المزيد <i class="fas fa-arrow-right rotate-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 mt-xs-4">
                            <div class="py-60 bg-base px-3 text-center">
                                <h1 class="text-80 text-base-two mb-16"> <span class="counter-number">10</span>+</h1>
                                <span class="text-white">سنوات من الخبرة</span>
                            </div>      
                        </div>
                        <div class="col-sm-6 col-xs-6 mt-xs-4">
                            <div class="py-60 bg-base px-3 text-center">
                                <h1 class="text-80 text-base-two mb-16"> <span class="counter-number">50</span>ألف+</h1>
                                <span class="text-white">طن مُعاد تدويرها</span>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="row gy-4">
                        <div class="col-lg-12 col-sm-6 col-xs-6">
                            <div class="py-60 bg-base px-3 text-center">
                                <h1 class="text-80 text-base-two mb-16"> <span class="counter-number">500</span>+</h1>
                                <span class="text-white">عميل راضٍ</span>
                            </div>    
                        </div>
                        <div class="col-lg-12 col-sm-6 col-xs-6">
                            <div class="py-60 bg-base-two px-3 text-center">
                                <h1 class="text-80 text-base mb-16"> <span class="counter-number">15</span>+</h1>
                                <span class="text-base">شهادة معتمدة</span>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================= About Section End =============================== -->

     
    <!-- ================================= Team Section Start =============================== -->
    @php $teamMembers = $teamMembers ?? collect(); @endphp
    <section class="expert-team space py-120 bg-neutral-20 position-relative">

        <h1 class="text-outline-neutral writing-mode position-absolute top-50 translate-y-middle-rotate text-white text-opacity-25 text-uppercase margin-left-80 z-index-2 h-100 text-center start-0">فريقنا</h1>
        
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between mb-60 animate-on-scroll">
                <div class="section-heading max-w-804 ms-0 text-start">
                    <div class="d-inline-flex align-items-center gap-2 text-base mb-3">
                        <img src="{{ $homeUrl('team.arrow_icon', 'frontend/assets/img/HomeCone/icon/arrow-icon-two.png') }}" alt="" class="">
                        <h4 class="mb-0 text-base">{{ $homeText('team.subtitle', 'تعرف على فريقنا') }}</h4>
                    </div>
                    <h2 class="mb-0">{{ $homeText('team.title', 'شركاء النجاح') }}</h2>
                </div>
                <div class="">
                    <p class="mb-24 max-w-416">{{ $homeText('team.description', 'فريقنا هو عماد نجاحنا، مكوّن من خبراء في مجال إعادة التدوير والاستدامة.') }}</p>
                    @if($teamMembers->isNotEmpty())
                    <div class="slick-arrows d-flex align-items-center gap-3 mt-40 justify-content-start">
                        <button type="button" id="expert-team-prev" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-transparent hover-text-white position-relative top-0 end-0 start-0 mt-0 slick-arrow">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <button type="button" id="expert-team-next" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-transparent hover-text-white position-relative top-0 end-0 start-0 mt-0 slick-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <div class="expert-team-slider animate-on-scroll" data-animate-delay="80">
                @if($teamMembers->isNotEmpty())
                    @foreach($teamMembers as $member)
                <div class="expert-team-item mx-2">
                    <div class="expert-team-item__thumb pb-20 position-relative">
                        <div class="d-block">
                            <img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="radius-12-px fit-img">
                        </div>
                    </div>
                    <div class="mt-20-px">
                        <h4 class="mb-3">
                            <span class="hover-text-brand">{{ $member->name }}</span>
                        </h4>
                        <span class="text-neutral-500">{{ $member->title }}</span>
                    </div>
                </div>
                @endforeach
                @else
                <div class="expert-team-item mx-2">
                    <div class="expert-team-item__thumb pb-20 position-relative">
                        <div class="d-block">
                            <img src="{{ $homeUrl('team.default_image', 'frontend/assets/img/HomeCone/team-img1.png') }}" alt="" class="radius-12-px fit-img">
                        </div>
                    </div>
                    <div class="mt-20-px">
                        <p class="text-neutral-500 mb-0">لا يوجد أعضاء حالياً. أضف أعضاء من لوحة التحكم.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- ================================= Team Section End =============================== -->


    <!-- ================================= Working Process Section Start =============================== -->
    <section class="homeC-work-process space overflow-hidden position-relative">
        <h1 class="text-outline-neutral writing-mode position-absolute top-50 translate-middle-y text-white text-opacity-25 text-uppercase margin-right-80 z-index-2 h-100 text-center right-0">How Its Works</h1>
        
        <div class="container">
            <div class="section-heading max-w-804 mx-auto text-center mb-60 animate-on-scroll">
                <div class="d-inline-flex align-items-center gap-2 text-base mb-3">
                    <img src="{{ $homeUrl('work_process.arrow_icon', 'frontend/assets/img/HomeCone/icon/arrow-icon-two.png') }}" alt="" class="">
                    <h4 class="mb-0 text-base">{{ $homeText('work_process.subtitle', 'آلية عملنا') }}</h4>
                </div>
                <h2 class="mb-24">{{ $homeText('work_process.title', 'خطوات بسيطة للتخلص الآمن من النفايات الإلكترونية') }}</h2>
                <p class="mb-0">{{ $homeText('work_process.description', 'نسير معكم خطوة بخطوة لضمان أفضل النتائج وفق احتياجاتكم، من الاتصال حتى استلام شهادة التخلص.') }}</p>
            </div>
            
            <div class="row gy-4 align-items-center animate-on-scroll" data-animate-delay="80">
                <div class="col-lg-3">
                    <div class="homeC-work-process-item pb-80 position-relative">
                        <img src="{{ $homeUrl('work_process.shape1', 'frontend/assets/img/HomeCone/shape/work-process-shape1.png') }}" alt="" class="homeC-work-process-item__shape d-lg-block d-none position-absolute start-0 mt-40 ms-80-px">

                        <div class="w-80-px h-80-px d-inline-flex justify-content-center align-items-center border border-neutral-200 radius-12-px overflow-hidden bg-base-two mb-32">
                            <span class="w-72-px h-72-px d-inline-flex justify-content-center align-items-center border border-neutral-200 radius-12-px overflow-hidden bg-base">
                                <img src="{{ $homeUrl('work_process.step_icon', 'frontend/assets/img/HomeCone/icon/work-process-icon1.png') }}" alt="">
                            </span>
                        </div>
                        <h3 class="mb-3 text-3xl">التواصل والاستشارة</h3>
                        <p class="text-neutral-700 text-sm fw-medium">نبدأ بفهم احتياجاتكم ونوع وكمية النفايات الإلكترونية للتخلص منها...</p>
                    </div>
                    <div class="homeC-work-process-item position-relative">
                        <img src="{{ $homeUrl('work_process.shape1', 'frontend/assets/img/HomeCone/shape/work-process-shape1.png') }}" alt="" class="homeC-work-process-item__shape d-lg-block d-none position-absolute start-0 mt-40 ms-80-px">

                        <div class="w-80-px h-80-px d-inline-flex justify-content-center align-items-center border border-neutral-200 radius-12-px overflow-hidden bg-base-two mb-32">
                            <span class="w-72-px h-72-px d-inline-flex justify-content-center align-items-center border border-neutral-200 radius-12-px overflow-hidden bg-base">
                                <img src="{{ $homeUrl('work_process.step_icon', 'frontend/assets/img/HomeCone/icon/work-process-icon1.png') }}" alt="">
                            </span>
                        </div>
                        <h3 class="mb-3 text-3xl">التواصل والاستشارة</h3>
                        <p class="text-neutral-700 text-sm fw-medium">نبدأ بفهم احتياجاتكم ونوع وكمية النفايات الإلكترونية للتخلص منها...</p>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-block d-none">
                    <div class="homeC-work-process__thumb radius-12-px overflow-hidden text-center z-index-3 position-relative">
                        <img src="{{ $homeUrl('work_process.main_image', 'frontend/assets/img/HomeCone/work-process-img.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="homeC-work-process-item text-end position-relative pb-80">
                        <img src="{{ $homeUrl('work_process.shape2', 'frontend/assets/img/HomeCone/shape/work-process-shape2.png') }}" alt="" class="homeC-work-process-item__shape d-lg-block d-none position-absolute end-0 mt-40 me-80-px">

                        <div class="w-80-px h-80-px d-inline-flex justify-content-center align-items-center border border-neutral-200 radius-12-px overflow-hidden bg-base-two mb-32">
                            <span class="w-72-px h-72-px d-inline-flex justify-content-center align-items-center border border-neutral-200 radius-12-px overflow-hidden bg-base">
                                <img src="{{ $homeUrl('work_process.step_icon', 'frontend/assets/img/HomeCone/icon/work-process-icon1.png') }}" alt="">
                            </span>
                        </div>
                        <h3 class="mb-3 text-3xl">التواصل والاستشارة</h3>
                        <p class="text-neutral-700 text-sm fw-medium">نبدأ بفهم احتياجاتكم ونوع وكمية النفايات الإلكترونية للتخلص منها...</p>
                    </div>
                    <div class="homeC-work-process-item text-end position-relative">
                        <img src="{{ $homeUrl('work_process.shape2', 'frontend/assets/img/HomeCone/shape/work-process-shape2.png') }}" alt="" class="homeC-work-process-item__shape d-lg-block d-none position-absolute end-0 mt-40 me-80-px">

                        <div class="w-80-px h-80-px d-inline-flex justify-content-center align-items-center border border-neutral-200 radius-12-px overflow-hidden bg-base-two mb-32">
                            <span class="w-72-px h-72-px d-inline-flex justify-content-center align-items-center border border-neutral-200 radius-12-px overflow-hidden bg-base">
                                <img src="{{ $homeUrl('work_process.step_icon', 'frontend/assets/img/HomeCone/icon/work-process-icon1.png') }}" alt="">
                            </span>
                        </div>
                        <h3 class="mb-3 text-3xl">التواصل والاستشارة</h3>
                        <p class="text-neutral-700 text-sm fw-medium">نبدأ بفهم احتياجاتكم ونوع وكمية النفايات الإلكترونية للتخلص منها...</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================= Working Process Section End =============================== -->
    
    
    <!-- ================================= Testimonials Section Start =============================== -->
    @php $testimonials = $testimonials ?? collect(); @endphp
    <section class="homeC-testimonial space overflow-hidden position-relative bg-neutral-20">

      <h1 class="text-outline-neutral writing-mode position-absolute top-50 translate-y-middle-rotate text-white text-opacity-25 text-uppercase margin-left-80 z-index-2 h-100 text-center start-0">أراء العملاء</h1>
        
        <div class="container">
            <div class="section-heading max-w-804 mx-auto text-center mb-60 animate-on-scroll">
                <div class="d-inline-flex align-items-center gap-2 text-base mb-3">
                    <img src="{{ $homeUrl('testimonial.arrow_icon', 'frontend/assets/img/HomeCone/icon/arrow-icon-two.png') }}" alt="">
                    <h4 class="mb-0 text-base">{{ $homeText('testimonial.subtitle', 'ماذا يقول عملاؤنا') }}</h4>
                </div>
                <h2 class="mb-24">{{ $homeText('testimonial.title', 'قصص نجاحنا') }}</h2>
                <p class="mb-0">{{ $homeText('testimonial.description', 'نفخر بتقديم نتائج استثنائية وخدمة متميزة لعملائنا. اكتشفوا تجارب من تعاملوا معنا.') }}</p>
            </div>
            
            <div class="row gy-4 align-items-center animate-on-scroll" data-animate-delay="80">
                <div class="col-lg-7">
                    <div class="position-relative">
                        <div class="homeC-testimonial-slider">
                            @if($testimonials->isNotEmpty())
                                @foreach($testimonials as $review)
                                <div class="homeC-testimonial-item">
                                    <ul class="d-flex align-items-center gap-2 list-unstyled mb-24">
                                        @for($i = 1; $i <= 5; $i++)
                                        <li class="{{ $i <= $review->rating ? 'text-yellow' : 'text-neutral-300' }}"><i class="fas fa-star"></i></li>
                                        @endfor
                                    </ul>
                                    <p class="text-neutral-700 text-2xl fw-medium">"{{ $review->comment ?? '' }}"</p>
                                    <div class="d-flex align-items-center gap-4">
                                        <img src="{{ $review->avatar_url }}" alt="{{ $review->display_name }}" class="w-60-px h-60-px rounded-circle">
                                        <div class="">
                                            <h6 class="text-20 mb-10-px">{{ $review->display_name }}</h6>
                                            <span class="text-neutral-700">{{ $review->display_title ?: 'شريك تعاون' }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <div class="homeC-testimonial-item">
                                <p class="text-neutral-700 text-2xl fw-medium">لا توجد آراء مميزة لعرضها حالياً. يمكنك إضافة آراء وتحديدها كـ "رأي مميز" من لوحة التحكم لعرضها هنا.</p>
                                <div class="d-flex align-items-center gap-4">
                                    <img src="{{ $homeUrl('testimonial.user_placeholder') }}" alt="" class="w-60-px h-60-px rounded-circle">
                                    <div class="">
                                        <h6 class="text-20 mb-10-px">لوحة التحكم</h6>
                                        <span class="text-neutral-700">آراء العملاء</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
    
                        <div class="slick-arrows position-absolute end-0 bottom-0 d-flex align-items-center gap-3 justify-content-start">
                            <button type="button" id="homeC-testimonial-prev" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-white hover-text-white position-relative top-0 end-0 start-0 mt-0 slick-arrow">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <button type="button" id="homeC-testimonial-next" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-white hover-text-white position-relative top-0 end-0 start-0 mt-0 slick-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="homeC-testimonial__thumb circle-border position-relative ps-lg-5">
                        <div class="position-relative overflow-hidden rounded-circle" style="width: 306px; height: 306px; aspect-ratio: 1/1;">
                            <img src="{{ $homeUrl('testimonial.fallback_image', 'frontend/assets/img/HomeCone/testimonial-image.png') }}" alt="" class="fit-img w-100 h-100" style="object-fit: cover;">
                            <span class="w-72-px h-72-px border border-white rounded-circle bg-base text-32 text-base-two d-inline-block d-flex justify-content-center align-items-center position-absolute top-50 end-0 translate-middle-y end--36">
                                <i class="fas fa-quote-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================= Testimonials Section End =============================== -->
    

    <!-- ================================= Blog Section Start =============================== -->
    @php $blogPosts = $blogPosts ?? collect(); @endphp
    <section class="homeCone-blog space py-120 position-relative">

        <h1 class="text-outline-neutral writing-mode position-absolute top-50 translate-y-middle-rotate text-white text-opacity-25 text-uppercase margin-left-80 z-index-2 h-100 text-center start-0">آخر الأخبار</h1>
        
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between mb-60 animate-on-scroll">
                <div class="section-heading max-w-804 ms-0 text-start">
                    <div class="d-inline-flex align-items-center gap-2 text-base mb-3">
                        <img src="{{ $homeUrl('services.arrow_icon', 'frontend/assets/img/HomeCone/icon/arrow-icon-two.png') }}" alt="" class="">
                        <h4 class="mb-0 text-base">أحدث مقالاتنا</h4>
                    </div>
                    <h2 class="mb-0">آخر الأخبار والمقالات</h2>
                </div>
                <div class="">
                    <p class="mb-24 max-w-416">مدونتنا وجهتك للنصائح والخبرات وآخر المستجدات في مجالنا.</p>
                    @if($blogPosts->isNotEmpty())
                    <div class="slick-arrows d-flex align-items-center gap-3 mt-40 justify-content-start">
                        <button type="button" id="homeCone-blog-prev" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-transparent hover-text-white position-relative top-0 end-0 start-0 mt-0 slick-arrow">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <button type="button" id="homeCone-blog-next" class="w-48-px h-48-px radius-8-px d-flex justify-content-center align-items-center border border-base text-base text-lg hover-bg-base bg-transparent hover-text-white position-relative top-0 end-0 start-0 mt-0 slick-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            @if($blogPosts->isNotEmpty())
            <div class="homeCone-blog-slider animate-on-scroll" data-animate-delay="80">
                @foreach($blogPosts as $post)
                <div class="scale-hover-item bg-neutral-20 mx-2 radius-12-px p-12-px h-100">
                    <div class="course-item__thumb radius-12-px overflow-hidden position-relative">
                        <a href="{{ route('frontend.blog.show', $post->slug) }}" class="w-100 h-100">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->featured_image_alt ?? $post->title }}" class="scale-hover-item__img radius-12-px fit-img transition-2">
                        </a>
                        <div class="position-absolute end-0 bottom-0 me-16-px mb-16-px py-12 px-24 radius-8-px bg-base-two text-neutral-700 fw-medium px-24-px py-12-px radius-8-px">
                            <h3 class="mb-0 text-neutral-700 fw-medium">{{ $post->published_at ? $post->published_at->format('d') : '—' }}</h3>
                            {{ $post->published_at ? strtoupper($post->published_at->format('M')) : '—' }}
                        </div>
                    </div>
                    <div class="pt-4 pb-4 px-16-px position-relative">
                        <h4 class="mb-28-px">
                            <a href="{{ route('frontend.blog.show', $post->slug) }}" class="link text-line-2 hover-text-brand">{{ $post->title }}</a>
                        </h4>
                        <div class="d-flex align-items-center gap-14 flex-wrap my-20">
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="far fa-user-circle"></i></span>
                                <span class="text-neutral-500 text-lg">{{ $post->author?->name ?? 'مدير' }}</span>
                            </div>
                            <span class="w-4-px h-4-px bg-neutral-100 rounded-circle"></span>
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="far fa-eye"></i></span>
                                <span class="text-neutral-500 text-lg">{{ number_format($post->views_count ?? 0) }}</span>
                            </div>
                            <span class="w-4-px h-4-px bg-neutral-100 rounded-circle"></span>
                            <div class="d-flex align-items-center gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="far fa-comment-alt"></i></span>
                                <span class="text-neutral-500 text-lg">{{ $post->comments_count ?? 0 }}</span>
                            </div>
                        </div>
                        <span class="d-block border-bottom border border-neutral-200 border-dashed my-24-px"></span>
                        <div class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                            <a href="{{ route('frontend.blog.show', $post->slug) }}" class="fw-semibold text-base d-flex align-items-center gap-2 hover-text-brand" tabindex="0">
                                اقرأ المزيد
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <p class="text-muted">لا توجد مقالات منشورة حالياً.</p>
                <a href="{{ route('frontend.blog.index') }}" class="btn btn-primary mt-3">عرض المدونة</a>
            </div>
            @endif
        </div>
    </section>
    <!-- ================================= Blog Section End =============================== -->

    @include('frontend.partials.footer')

    <!--********************************
			Code End  Here 
	******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>

    <!--==============================
    All Js File
    ============================== -->
    <!-- Jquery -->
    <script src="frontend/assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Slick Slider -->   
    <script src="frontend/assets/js/slick.min.js"></script>
    <!-- Range Slider -->
    <script src="frontend/assets/js/jquery-ui.min.js"></script>
    <!-- Bootstrap -->
    <script src="frontend/assets/js/bootstrap.min.js"></script>
    <!-- Magnific Popup -->
    <script src="frontend/assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up -->
    <script src="frontend/assets/js/jquery.counterup.min.js"></script>
    <!-- Marquee -->
    <script src="frontend/assets/js/jquery.marquee.min.js"></script>
    <!-- Isotope Filter -->
    <script src="frontend/assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="frontend/assets/js/isotope.pkgd.min.js"></script>

    <!-- Swiper -->
    <script src="{{ asset('frontend/assets/js/swiper.js') }}"></script>
    <!-- Main Js File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script>
    (function() {
        var els = document.querySelectorAll('.animate-on-scroll');
        if (!els.length) return;
        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (!entry.isIntersecting) return;
                var el = entry.target;
                var delay = parseInt(el.getAttribute('data-animate-delay'), 10) || 0;
                if (delay) {
                    el.style.transitionDelay = delay + 'ms';
                }
                el.classList.add('animate-in');
            });
        }, { rootMargin: '0px 0px -8% 0px', threshold: 0 });
        els.forEach(function(el) { io.observe(el); });
    })();
    </script>
    @if(isset($heroSlides) && $heroSlides->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.hero-swiper', {
                loop: true,
                autoplay: { delay: 5000, disableOnInteraction: false },
                effect: 'fade',
                fadeEffect: { crossFade: true },
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
    @endif
</body>

</html>