@extends('frontend.layouts.app')

@section('title', 'من نحن')
@section('content')
{{-- بنر الصفحة --}}
<section class="products-page-banner bg-img bg-overlay style-three position-relative z-index-2 d-flex align-items-center justify-content-center" data-background-image="{{ asset('frontend/assets/img/bg/breadcrumb-bg.png') }}" style="min-height: 320px;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-3">من نحن</h1>
                <p class="text-neutral-20 mb-0">إدارة سليمة للنفايات الإلكترونية وحماية للبيئة</p>
            </div>
        </div>
    </div>
</section>

<section class="space py-60" style="padding-top: 80px !important;">
    <div class="container">

        {{-- 1. مقدمة وتأسيس الشركة (نص ثم صورة) --}}
        <div class="row align-items-center g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-lg-6 order-2 order-lg-1">
                <h2 class="h3 mb-4 fw-bold">تأسيسنا</h2>
                <p class="text-neutral-600 mb-2">تأسست شركتنا بتاريخ <strong>10/12/2025</strong> انطلاقًا من إيماننا بأهمية الإدارة السليمة للنفايات الإلكترونية ودورها الحيوي في حماية البيئة وتعزيز الاستدامة.</p>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="rounded-3 overflow-hidden shadow-sm slideinright" data-scroll-ani>
                    <img src="{{ asset('frontend/assets/img/about-img.png') }}" alt="من نحن" class="w-100" style="height: 320px; object-fit: cover;">
                </div>
            </div>
        </div>

        {{-- 2. ما نقدمه (صورة ثم نص) --}}
        <div class="row align-items-center g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-lg-6 order-2 order-lg-2">
                <h2 class="h3 mb-4 fw-bold">ما نقدمه</h2>
                <p class="text-neutral-600 mb-3">نحن شركة متخصصة في جمع وشراء النفايات الإلكترونية بمختلف أنواعها، ونعمل على تقييمها وفرزها بعناية، حيث يتم:</p>
                <ul class="list-unstyled text-neutral-600">
                    <li class="mb-2 d-flex align-items-start gap-2"><i class="fas fa-check text-base mt-1 flex-shrink-0"></i> إعادة إصلاح وتجديد الأجهزة القابلة للاستخدام وطرحها مجددًا في السوق،</li>
                    <li class="mb-2 d-flex align-items-start gap-2"><i class="fas fa-check text-base mt-1 flex-shrink-0"></i> أو التخلص الآمن والمسؤول من الأجهزة غير القابلة للإصلاح عبر قنوات معتمدة وصديقة للبيئة.</li>
                </ul>
                <p class="text-neutral-600 mb-0">تشمل أنشطتنا التعامل مع الأجهزة الإلكترونية المختلفة مثل الحواسيب، الهواتف، الشاشات، المعدات الإلكترونية وملحقاتها، سواء من الأفراد أو الشركات.</p>
            </div>
            <div class="col-lg-6 order-1 order-lg-1">
                <div class="rounded-3 overflow-hidden shadow-sm slideinleft" data-scroll-ani>
                    <img src="{{ asset('frontend/assets/img/normal/about_2-1.jpg') }}" alt="ما نقدمه" class="w-100" style="height: 320px; object-fit: cover;">
                </div>
            </div>
        </div>

        {{-- 3. رؤيتنا (نص ثم صورة) --}}
        <div class="row align-items-center g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-lg-6 order-2 order-lg-1">
                <h2 class="h3 mb-4 fw-bold">رؤيتنا</h2>
                <p class="text-neutral-600 mb-0">أن نكون جزءًا فاعلًا في بناء مستقبل أكثر استدامة من خلال تقليل الأثر البيئي للنفايات الإلكترونية وتعزيز ثقافة إعادة الاستخدام والإدارة المسؤولة للموارد التقنية.</p>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="rounded-3 overflow-hidden shadow-sm slideinright" data-scroll-ani>
                    <img src="{{ asset('frontend/assets/img/normal/about_3-1.jpg') }}" alt="رؤيتنا" class="w-100" style="height: 320px; object-fit: cover;">
                </div>
            </div>
        </div>

        {{-- 4. رسالتنا (صورة ثم نص) --}}
        <div class="row align-items-center g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-lg-6 order-2 order-lg-2">
                <h2 class="h3 mb-4 fw-bold">رسالتنا</h2>
                <p class="text-neutral-600 mb-3">نسعى إلى تقديم حلول عملية وموثوقة في مجال إدارة النفايات الإلكترونية، عبر:</p>
                <ul class="list-unstyled text-neutral-600">
                    <li class="mb-2 d-flex align-items-start gap-2"><i class="fas fa-arrow-left text-base mt-1 flex-shrink-0"></i> جمعها بطرق منظمة ومسؤولة،</li>
                    <li class="mb-2 d-flex align-items-start gap-2"><i class="fas fa-arrow-left text-base mt-1 flex-shrink-0"></i> إعادة تأهيل الأجهزة القابلة للإصلاح وإعادتها إلى دورة الاستخدام،</li>
                    <li class="mb-2 d-flex align-items-start gap-2"><i class="fas fa-arrow-left text-base mt-1 flex-shrink-0"></i> والتخلص الآمن من الأجهزة غير الصالحة،</li>
                </ul>
                <p class="text-neutral-600 mb-0">بما يحقق التوازن بين حماية البيئة وتلبية احتياجات المجتمع.</p>
            </div>
            <div class="col-lg-6 order-1 order-lg-1">
                <div class="rounded-3 overflow-hidden shadow-sm slideinleft" data-scroll-ani>
                    <img src="{{ asset('frontend/assets/img/service/service-1-1.jpg') }}" alt="رسالتنا" class="w-100" style="height: 320px; object-fit: cover;">
                </div>
            </div>
        </div>

        {{-- 5. قيمنا (نص ثم صورة) --}}
        <div class="row align-items-center g-4 mb-0">
            <div class="col-lg-6 order-2 order-lg-1">
                <h2 class="h3 mb-4 fw-bold">قيمنا</h2>
                <p class="text-neutral-600 mb-4">نلتزم في جميع أعمالنا بمجموعة من القيم الأساسية، أبرزها:</p>
                <ul class="list-unstyled text-neutral-600">
                    <li class="mb-3">
                        <strong class="d-block mb-1">المسؤولية البيئية:</strong>
                        <span>الالتزام بالممارسات التي تحافظ على البيئة وتحد من التلوث.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">الاستدامة:</strong>
                        <span>دعم إعادة الاستخدام وتقليل الهدر الإلكتروني.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">الشفافية:</strong>
                        <span>الوضوح في التعامل مع شركائنا وعملائنا.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">الجودة:</strong>
                        <span>الحرص على فحص وإصلاح الأجهزة وفق معايير مناسبة قبل إعادة طرحها.</span>
                    </li>
                    <li class="mb-0">
                        <strong class="d-block mb-1">الالتزام المجتمعي:</strong>
                        <span>المساهمة في نشر الوعي حول مخاطر النفايات الإلكترونية وأهمية إدارتها بشكل صحيح.</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="rounded-3 overflow-hidden shadow-sm slideinright" data-scroll-ani>
                    <img src="{{ asset('frontend/assets/img/about/about-two-img1.png') }}" alt="قيمنا" class="w-100" style="height: 320px; object-fit: cover;">
                </div>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
(function() {
    var els = document.querySelectorAll('[data-scroll-ani]');
    if (!els.length) return;
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('slider-animated');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });
    els.forEach(function(el) { observer.observe(el); });
})();
</script>
@endpush
@endsection
