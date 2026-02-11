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
                <p class="text-neutral-600 mb-3">تأسس مشروع E-Parts Library – مكتبة الأجزاء الإلكترونية كمبادرة من فريق E-Parts لإدارة النفايات الإلكترونية، استجابةً للتزايد الكبير في حجم النفايات الإلكترونية وغياب منظومة رسمية لإدارتها محليًا، وما يرافق ذلك من مخاطر بيئية وصحية وهدر للموارد التقنية.</p>
                <p class="text-neutral-600 mb-0">انطلق المشروع بدعم من مؤسسة الابتكار الإنساني في الميدان – Field Ready for Humanitarian Innovation، وبالشراكة مع منظمة ورلد فيجن إنترناشونال – استجابة سوريا (WVSR) و Response Innovation Lab (RIL)، ليقدّم نموذجًا يجمع بين الحل البيئي، والتعليم التقني، والتمكين المجتمعي عبر نظام متكامل لجمع وفرز وتأهيل الأجزاء الإلكترونية وتحويلها إلى قيمة مستدامة تخدم المجتمع والبيئة معًا.</p>
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
                <h2 class="h3 mb-4 fw-bold">ما نقدّمه</h2>
                <p class="text-neutral-600 mb-0">نقدّم من خلال مشروع E-Parts Library – مكتبة الأجزاء الإلكترونية نموذجًا عمليًا ومستدامًا للتعامل مع النفايات الإلكترونية، حيث نقوم بجمع الأجهزة التالفة، وفرزها، وتفكيكها بشكل آمن، ثم إعادة تأهيل الأجزاء الصالحة وتحويلها إلى موارد تعليمية وتقنية متاحة للطلاب، والمبتكرين، وروّاد المشاريع الصغيرة. كما نوفر برامج تدريب وبناء قدرات في مجالات التفكيك، الإصلاح، وإعادة الاستخدام الإبداعي (Upcycling)، مع الالتزام الكامل بمعايير السلامة البيئية والمهنية.</p>
            </div>
            <div class="col-lg-6 order-1 order-lg-1">
                <div class="rounded-3 overflow-hidden shadow-sm slideinleft" data-scroll-ani>
                    <img src="{{ asset('frontend/assets/img/normal/about_2-1.jpg') }}" alt="ما نقدّمه" class="w-100" style="height: 320px; object-fit: cover;">
                </div>
            </div>
        </div>

        {{-- 3. رؤيتنا (نص ثم صورة) --}}
        <div class="row align-items-center g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-lg-6 order-2 order-lg-1">
                <h2 class="h3 mb-4 fw-bold">رؤيتنا</h2>
                <p class="text-neutral-600 mb-0">نطمح إلى مستقبلٍ تتحول فيه النفايات الإلكترونية من عبءٍ بيئي وصحي إلى فرصة للتعلّم والابتكار والتنمية المستدامة، وأن تصبح مكتبة الأجزاء الإلكترونية نموذجًا رائدًا محليًا يمكن تعميمه في سوريا والمنطقة، يربط بين حماية البيئة، والتعليم التقني، والتمكين المجتمعي.</p>
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
                <p class="text-neutral-600 mb-0">رسالتنا هي تقليل الأثر البيئي للنفايات الإلكترونية عبر حلول عملية ومبتكرة، وتعزيز الوعي المجتمعي بمخاطرها، وتوفير بدائل آمنة ومستدامة تُمكّن الشباب والطلاب من الوصول إلى موارد تقنية منخفضة التكلفة، مع ضمان إدارة شفافة ومسؤولة لجميع مراحل الجمع والمعالجة وإعادة الاستخدام.</p>
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
                <p class="text-neutral-600 mb-4">نؤمن بأن العمل البيئي الناجح يقوم على:</p>
                <ul class="list-unstyled text-neutral-600">
                    <li class="mb-3">
                        <strong class="d-block mb-1">الاستدامة:</strong>
                        <span>حلول طويلة الأمد تحمي البيئة وتدعم المجتمع.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">السلامة:</strong>
                        <span>أولوية قصوى للصحة المهنية والبيئية في جميع مراحل العمل.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">الشفافية:</strong>
                        <span>توثيق وتتبع واضح لكل جهاز وقطعة.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">التمكين:</strong>
                        <span>دعم التعليم التقني والابتكار الشبابي.</span>
                    </li>
                    <li class="mb-0">
                        <strong class="d-block mb-1">المسؤولية المجتمعية:</strong>
                        <span>شراكة حقيقية مع الأفراد والمؤسسات المحلية.</span>
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
