<!DOCTYPE html>
<html lang="en" dir="rtl" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('page-title')</title>
    <meta name="Description" content="أفضل موقع للاعلانات المبوبة">
    <meta name="Author" content="claudSoft">
    <meta name="keywords" content="إعلانات , لوحة التحكم">

    @include('admin.layouts.head')
    
    @yield('css')
    @yield('styles')
</head>

<body>


    @include('admin.layouts.switcher')


    <!-- Loader -->
    <div id="loader">
        <img src="{{asset('assets/images/media/loader.svg')}}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">


        @include('admin.layouts.main-header')



        @include('admin.layouts.offcanvas-sidebar')



        @include('admin.layouts.main-sidebar')


        {{-- عرض مركزي لرسائل النجاح والخطأ فقط (بدون أخطاء التحقق لتجنب التكرار) --}}
        @if(session('success') || session('error'))
        <div class="admin-global-alerts position-fixed top-0 start-50 translate-middle-x mt-5 p-3" style="z-index: 9999; width: 90%; max-width: 600px;">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
            @endif
        </div>
        @endif

        @yield('content')


        @include('admin.layouts.footer')

    </div>
    @include('admin.layouts.footer-scripts')


</body>

</html>
