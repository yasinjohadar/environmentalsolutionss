@extends('frontend.layouts.app')

@section('title', 'سياسة الخصوصية')
@section('content')
@php $s = $siteSettings ?? null; $siteName = $s?->site_name ?? 'المشروع'; @endphp
{{-- بنر الصفحة --}}
<section class="products-page-banner bg-img bg-overlay style-three position-relative z-index-2 d-flex align-items-center justify-content-center" data-background-image="{{ asset('frontend/assets/img/bg/breadcrumb-bg.png') }}" style="min-height: 320px;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-3">سياسة الخصوصية</h1>
                <p class="text-neutral-20 mb-0">نلتزم بحماية خصوصيتك وبياناتك</p>
            </div>
        </div>
    </div>
</section>

<section class="space py-60" style="padding-top: 80px !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <p class="lead text-neutral-700 mb-4">
                    يلتزم {{ $siteName }} بحماية خصوصية مستخدمي الموقع واحترام سرية بياناتهم الشخصية.
                </p>

                <h2 class="h4 fw-bold mb-3 mt-5">جمع المعلومات</h2>
                <p class="text-neutral-600 mb-4">
                    قد نقوم بجمع بعض المعلومات الأساسية مثل الاسم، معلومات التواصل، الموقع الجغرافي، ونوع الأجهزة الإلكترونية، وذلك بهدف تنظيم عمليات التبرع أو طلب الجمع وتحسين جودة الخدمات المقدمة.
                </p>

                <h2 class="h4 fw-bold mb-3 mt-5">استخدام المعلومات</h2>
                <p class="text-neutral-600 mb-2">تُستخدم المعلومات التي يتم جمعها فقط للأغراض التالية:</p>
                <ul class="text-neutral-600 mb-4">
                    <li class="mb-2">إدارة وتنظيم طلبات التبرع أو الجمع.</li>
                    <li class="mb-2">التواصل مع المستخدم عند الحاجة.</li>
                    <li class="mb-2">تحسين أداء الموقع والخدمات.</li>
                </ul>

                <h2 class="h4 fw-bold mb-3 mt-5">حماية البيانات</h2>
                <p class="text-neutral-600 mb-3">
                    نتخذ الإجراءات التقنية والتنظيمية المناسبة لحماية البيانات من الوصول غير المصرح به أو سوء الاستخدام.
                </p>
                <p class="text-neutral-600 mb-4">
                    لا يتم مشاركة أي بيانات شخصية مع أطراف ثالثة إلا في الحالات الضرورية لتنفيذ الخدمة أو عند وجود التزام قانوني.
                </p>

                <h2 class="h4 fw-bold mb-3 mt-5">خصوصية البيانات على الأجهزة</h2>
                <p class="text-neutral-600 mb-0">
                    يتم التعامل مع الأجهزة الإلكترونية المستلمة وفق إجراءات تقلّل مخاطر الوصول إلى البيانات الشخصية، بما يعزز ثقة المتبرعين ويحافظ على خصوصيتهم.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
