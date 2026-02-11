@extends('frontend.layouts.app')

@section('title', 'الشروط والأحكام')
@section('content')
@php $s = $siteSettings ?? null; $siteName = $s?->site_name ?? 'المشروع'; @endphp
{{-- بنر الصفحة --}}
<section class="products-page-banner bg-img bg-overlay style-three position-relative z-index-2 d-flex align-items-center justify-content-center" data-background-image="{{ asset('frontend/assets/img/bg/breadcrumb-bg.png') }}" style="min-height: 320px;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-3">الشروط والأحكام</h1>
                <p class="text-neutral-20 mb-0">شروط استخدام الموقع والخدمات</p>
            </div>
        </div>
    </div>
</section>

<section class="space py-60" style="padding-top: 80px !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <p class="lead text-neutral-700 mb-4">
                    باستخدامك لموقع {{ $siteName }}، فإنك توافق على الشروط والأحكام التالية:
                </p>

                <h2 class="h4 fw-bold mb-3 mt-5">استخدام الموقع</h2>
                <ul class="text-neutral-600 mb-4">
                    <li class="mb-2">يلتزم المستخدم بتقديم معلومات صحيحة ودقيقة عند تعبئة النماذج.</li>
                    <li class="mb-2">يُمنع استخدام الموقع لأي أغراض مخالفة للقوانين أو لأهداف المشروع البيئية والتعليمية.</li>
                </ul>

                <h2 class="h4 fw-bold mb-3 mt-5">التبرع وطلبات الجمع</h2>
                <ul class="text-neutral-600 mb-4">
                    <li class="mb-2">يحتفظ المشروع بحق قبول أو رفض أي طلب تبرع أو جمع في حال عدم توافقه مع معايير السلامة أو الإمكانيات التشغيلية.</li>
                    <li class="mb-2">التبرع بالنفايات الإلكترونية يتم طوعًا ولا يترتب عليه أي التزام مالي.</li>
                </ul>

                <h2 class="h4 fw-bold mb-3 mt-5">حدود المسؤولية</h2>
                <ul class="text-neutral-600 mb-4">
                    <li class="mb-2">لا يتحمل المشروع أي مسؤولية عن الأعطال التقنية أو الخسائر الناتجة عن استخدام الموقع خارج نطاقه المخصص.</li>
                    <li class="mb-2">يتم التعامل مع النفايات الإلكترونية وفق أفضل الممارسات المتاحة ضمن الإمكانيات المحلية.</li>
                </ul>

                <h2 class="h4 fw-bold mb-3 mt-5">التعديلات</h2>
                <p class="text-neutral-600 mb-0">
                    يحتفظ {{ $siteName }} بحق تعديل هذه الشروط والأحكام أو سياسة الخصوصية في أي وقت، وسيتم نشر أي تحديث على هذه الصفحة، ويُعد استمرار استخدام الموقع موافقة ضمنية على هذه التعديلات.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
