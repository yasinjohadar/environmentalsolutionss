@extends('frontend.layouts.app')

@section('title', 'مراحل عمل المشروع')
@section('content')
{{-- بنر الصفحة --}}
<section class="products-page-banner bg-img bg-overlay style-three position-relative z-index-2 d-flex align-items-center justify-content-center" data-background-image="{{ asset('frontend/assets/img/bg/breadcrumb-bg.png') }}" style="min-height: 320px;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-3">مراحل عمل المشروع</h1>
                <p class="text-neutral-20 mb-0">من طلب الخدمة حتى الإتاحة والتأثير المجتمعي</p>
            </div>
        </div>
    </div>
</section>

<section class="space py-60" style="padding-top: 80px !important;">
    <div class="container">

        {{-- المرحلة 1 --}}
        <div class="row align-items-start g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-auto">
                <span class="w-56-px h-56-px rounded-circle bg-base-two text-white d-flex align-items-center justify-content-center fw-bold fs-4">1</span>
            </div>
            <div class="col">
                <h2 class="h4 fw-bold mb-3">التسجيل وطلب الخدمة عبر الموقع</h2>
                <p class="text-neutral-600 mb-3">تبدأ رحلة النفايات الإلكترونية من خلال الموقع الإلكتروني لمشروع E-Parts Library، حيث يتيح الموقع للأفراد والمؤسسات خيار التبرع بالأجهزة الإلكترونية أو تقديم طلب لجمعها.</p>
                <p class="text-neutral-600 mb-0">يقوم المستخدم بتعبئة نموذج إلكتروني يتضمن معلومات أساسية عن نوع الأجهزة، حالتها، وموقعها، مما يسهّل تنظيم عملية الجمع بشكل فعّال وآمن.</p>
            </div>
        </div>

        {{-- المرحلة 2 --}}
        <div class="row align-items-start g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-auto">
                <span class="w-56-px h-56-px rounded-circle bg-base-two text-white d-flex align-items-center justify-content-center fw-bold fs-4">2</span>
            </div>
            <div class="col">
                <h2 class="h4 fw-bold mb-3">مراجعة الطلب وتنسيق الجمع</h2>
                <p class="text-neutral-600 mb-0">بعد استلام الطلب، يقوم فريق المشروع بمراجعته والتواصل مع مقدّم الطلب عند الحاجة، ثم يتم تنسيق موعد الجمع المناسب، إما عبر نقاط التجميع المعتمدة أو من خلال الوحدة المتنقلة، وفقًا لطبيعة وكمية الأجهزة.</p>
            </div>
        </div>

        {{-- المرحلة 3 --}}
        <div class="row align-items-start g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-auto">
                <span class="w-56-px h-56-px rounded-circle bg-base-two text-white d-flex align-items-center justify-content-center fw-bold fs-4">3</span>
            </div>
            <div class="col">
                <h2 class="h4 fw-bold mb-3">الاستلام والنقل الآمن</h2>
                <p class="text-neutral-600 mb-0">يتم استلام الأجهزة الإلكترونية باستخدام معدات وتجهيزات تراعي معايير السلامة المهنية والبيئية، ثم تُنقل إلى المستودع المركزي أو ورشة الفرز، مع توثيق الكميات والأنواع لضمان الشفافية وتتبع المواد.</p>
            </div>
        </div>

        {{-- المرحلة 4 --}}
        <div class="row align-items-start g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-auto">
                <span class="w-56-px h-56-px rounded-circle bg-base-two text-white d-flex align-items-center justify-content-center fw-bold fs-4">4</span>
            </div>
            <div class="col">
                <h2 class="h4 fw-bold mb-3">الفرز والتفكيك الآمن</h2>
                <p class="text-neutral-600 mb-0">تخضع الأجهزة لعمليات فحص وفرز أولي لتحديد إمكانية إعادة الاستخدام، ثم يتم تفكيكها بطريقة آمنة لاستخلاص الأجزاء الصالحة، مع عزل النفايات الخطرة والتعامل معها وفق إجراءات السلامة المعتمدة.</p>
            </div>
        </div>

        {{-- المرحلة 5 --}}
        <div class="row align-items-start g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-auto">
                <span class="w-56-px h-56-px rounded-circle bg-base-two text-white d-flex align-items-center justify-content-center fw-bold fs-4">5</span>
            </div>
            <div class="col">
                <h2 class="h4 fw-bold mb-3">التأهيل وإعادة الاستخدام</h2>
                <p class="text-neutral-600 mb-0">يتم تنظيف وتأهيل الأجزاء الإلكترونية القابلة للاستخدام واختبارها، ثم تصنيفها وتوثيقها ضمن نظام إدارة رقمي، لتصبح جاهزة للاستخدام التعليمي أو التقني من قبل الطلاب والمبتكرين وروّاد المشاريع الصغيرة.</p>
            </div>
        </div>

        {{-- المرحلة 6 --}}
        <div class="row align-items-start g-4 mb-5 pb-5 border-bottom border-neutral-100">
            <div class="col-auto">
                <span class="w-56-px h-56-px rounded-circle bg-base-two text-white d-flex align-items-center justify-content-center fw-bold fs-4">6</span>
            </div>
            <div class="col">
                <h2 class="h4 fw-bold mb-3">الإتاحة والتأثير المجتمعي</h2>
                <p class="text-neutral-600 mb-0">تُتاح الأجزاء المؤهلة عبر مكتبة الأجزاء الإلكترونية، كما يتم توظيف جزء منها في برامج التدريب وورش Upcycling، ليكتمل المسار من نفايات مهملة إلى موارد تخلق أثرًا بيئيًا وتعليميًا مستدامًا.</p>
            </div>
        </div>

        {{-- لماذا تختارنا؟ --}}
        <div class="row g-4 mb-0">
            <div class="col-12">
                <h2 class="h3 fw-bold mb-4">لماذا تختارنا؟</h2>
                <p class="text-neutral-600 mb-4">لأن مشروع E-Parts Library يقدّم حلًا عمليًا ومبتكرًا لأزمة النفايات الإلكترونية، مبنيًا على فهم واقعي للتحديات البيئية والصحية المحلية، وليس مجرد مبادرة نظرية.</p>
                <ul class="list-unstyled text-neutral-600">
                    <li class="mb-3">
                        <strong class="d-block mb-1">حل لمشكلة حقيقية:</strong>
                        <span>في ظل غياب أي نظام رسمي لجمع النفايات الإلكترونية محليًا وكون 100% منها غير مُدارة، نقدّم آلية منظمة وآمنة للجمع والمعالجة.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">نهج متكامل ومستدام:</strong>
                        <span>نعتمد التدوير الميكروي (Micro-recycling) وإعادة الاستخدام والتأهيل قبل إعادة التدوير، بما يحدّ من التلوث ويمنع الهدر.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">سلامة بيئية ومهنية:</strong>
                        <span>نطبّق إجراءات صارمة للتعامل مع المواد الخطرة والبطاريات والشاشات، مع التزام كامل بمعدات الحماية ومعايير السلامة.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">حماية البيانات وبناء الثقة:</strong>
                        <span>نعالج أحد أكبر التحديات المحلية، وهو خوف الأفراد من تسريب بياناتهم، عبر إجراءات موثقة وآمنة.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">تحويل النفايات إلى قيمة:</strong>
                        <span>نحول الأجهزة التالفة إلى موارد تعليمية وتقنية تخدم الطلاب، المبتكرين، وروّاد المشاريع الصغيرة.</span>
                    </li>
                    <li class="mb-3">
                        <strong class="d-block mb-1">نظام رقمي وشفافية:</strong>
                        <span>توثيق وتتبع كل جهاز وقطعة عبر نظام إدارة مخزون رقمي يضمن الكفاءة والموثوقية.</span>
                    </li>
                    <li class="mb-0">
                        <strong class="d-block mb-1">أثر تعليمي ومجتمعي:</strong>
                        <span>نربط إدارة النفايات الإلكترونية بالتدريب، وبناء القدرات، وورش الـ Upcycling لخلق أثر طويل الأمد.</span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</section>
@endsection
