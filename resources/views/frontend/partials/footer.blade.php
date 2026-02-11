@php
$s = $siteSettings ?? null;
$footerBgUrl = $s?->footer_background_url ?? asset('frontend/assets/img/HomeCone/footer-bg.png');
@endphp
<!-- ================================= Footer Section Start =============================== -->
<section class="homeCone-footer bg-img bg-overlay style-three position-relative z-index-3" data-background-image="{{ $footerBgUrl }}" style="background-image: url('{{ $footerBgUrl }}');">

    <ul class="animation-line d-none d-md-flex justify-content-between">
        <li class="animation-line__item"></li>
        <li class="animation-line__item"></li>
        <li class="animation-line__item"></li>
        <li class="animation-line__item"></li>
    </ul>

    <div class="container">
        <div class=" space ">
            <div class="row gy-5">
                <div class="col-lg-3">
                    <div class="">
                        <a href="{{ route('home') }}" class="d-inline-block mb-4 text-decoration-none">
                            @if($s?->logo_dark_url || $s?->logo_url)
                                <img src="{{ $s?->logo_dark_url ?? $s?->logo_url }}" alt="{{ $s?->site_name ?? '' }}">
                            @else
                                <span class="text-white fw-bold">{{ $s?->site_name ?? 'الرئيسية' }}</span>
                            @endif
                        </a>
                        <p class="text-neutral-20">{{ $s?->footer_description ?? 'نقدم خدمات متكاملة لجمع وإعادة تدوير النفايات الإلكترونية بطرق آمنة وصديقة للبيئة.' }}</p>
                        <ul class="mt-32-px ps-0 list-unstyled d-flex align-content-center gap-12">
                            @foreach(($s?->social_links ?? []) as $platform => $data)
                            <li>
                                <a href="{{ $data['url'] }}" target="_blank" rel="noopener" class="w-36-px h-36-px rounded-circle border border-base-two text-base-two text-xl d-inline-block d-flex justify-content-center align-items-center hover-bg-base-two hover-text-neutral-700"><i class="{{ $data['icon'] }}"></i></a>
                            </li>
                            @endforeach
                            @if(empty($s?->social_links))
                            <li><a href="#" class="w-36-px h-36-px rounded-circle border border-base-two text-base-two text-xl d-inline-block d-flex justify-content-center align-items-center hover-bg-base-two hover-text-neutral-700"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" class="w-36-px h-36-px rounded-circle border border-base-two text-base-two text-xl d-inline-block d-flex justify-content-center align-items-center hover-bg-base-two hover-text-neutral-700"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" class="w-36-px h-36-px rounded-circle border border-base-two text-base-two text-xl d-inline-block d-flex justify-content-center align-items-center hover-bg-base-two hover-text-neutral-700"><i class="fab fa-pinterest"></i></a></li>
                            <li><a href="#" class="w-36-px h-36-px rounded-circle border border-base-two text-base-two text-xl d-inline-block d-flex justify-content-center align-items-center hover-bg-base-two hover-text-neutral-700"><i class="fab fa-skype"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-item">
                        <h4 class="title text-white mb-4">روابط سريعة</h4>
                        <ul class="list-unstyled ps-0 d-flex flex-md-column gap-2">
                            <li>
                                <a href="{{ route('home') }}" class="hover-action text-neutral-30 hover-text-base-two">الرئيسية</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.about.index') }}" class="hover-action text-neutral-30 hover-text-base-two">من نحن</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.work-stages.index') }}" class="hover-action text-neutral-30 hover-text-base-two">مراحل عمل المشروع</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.products.index') }}" class="hover-action text-neutral-30 hover-text-base-two">المنتجات</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.categories.index') }}" class="hover-action text-neutral-30 hover-text-base-two">التصنيفات</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.blog.index') }}" class="hover-action text-neutral-30 hover-text-base-two">المدونة</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.contact.index') }}" class="hover-action text-neutral-30 hover-text-base-two">اتصل بنا</a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.ewaste.request') }}" class="hover-action text-neutral-30 hover-text-base-two">طلب جمع / تبرع</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-item">
                        <h4 class="title text-white mb-4">تواصل معنا</h4>
                        <div class="d-flex flex-column gap-3">
                            @if($s?->phone)
                            <div class="d-flex align-items-center gap-3">
                                <span class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl">
                                    <i class="fas fa-phone-volume"></i>
                                </span>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $s->phone) }}" class="text-neutral-30 hover-text-base-two">{{ $s->phone }}</a>
                            </div>
                            @endif
                            @if($s?->email)
                            <div class="d-flex align-items-center gap-3">
                                <span class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl">
                                    <i class="far fa-envelope-open"></i>
                                </span>
                                <a href="mailto:{{ $s->email }}" class="text-neutral-30 hover-text-base-two">{{ $s->email }}</a>
                            </div>
                            @endif
                            @if($s?->address)
                            <div class="d-flex align-items-center gap-3">
                                <span class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <span class="text-neutral-30">{{ $s->address }}</span>
                            </div>
                            @endif
                            @if(!$s?->phone && !$s?->email && !$s?->address)
                            <div class="d-flex align-items-center gap-3">
                                <span class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl"><i class="fas fa-phone-volume"></i></span>
                                <a href="tel:316-555-0116" class="text-neutral-30 hover-text-base-two">(205) 555-0100</a>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl"><i class="far fa-envelope-open"></i></span>
                                <a href="mailto:info@example.com" class="text-neutral-30 hover-text-base-two">info@example.com</a>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center border border-base-two text-base-two text-xl"><i class="fas fa-map-marker-alt"></i></span>
                                <span class="text-neutral-30">المملكة العربية السعودية</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-item">
                        <h4 class="title text-white mb-4">النشرة البريدية</h4>
                        <p class="text-neutral-20">اشترك في نشرتنا لتلقي آخر التحديثات والأخبار</p>
                        <form action="#" class="mt-32-px position-relative">
                            <input type="text" class="ps-24-px py-4-px text-white bg-transparent radius-8-px h-56-px placeholder-white border border-base-two focus-border-base-two pe-48-px opacity-40 focus-opacity-1" placeholder="البريد الإلكتروني">
                            <button type="submit" class="w-32-px h-32-px text-12 bg-base-two d-flex justify-content-center align-items-center radius-4-px position-absolute end-0 top-50 translate-middle-y me-12-px">
                                <i class="far fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="bottom-footer py-32-px d-flex align-items-center justify-content-between flex-wrap">
            <p class="text-neutral-20">جميع الحقوق محفوظة &copy; {{ date('Y') }} <span class="fw-semibold text-base-two">{{ $s?->site_name ?? 'إعادة تدوير النفايات الإلكترونية' }}</span></p>
            <div class="d-flex align-items-center gap-4 flex-wrap">
                <a href="javascript:void(0)" class="text-white hover-text-base">المساعدة</a>
                <a href="{{ route('frontend.privacy.index') }}" class="text-white hover-text-base">سياسة الخصوصية</a>
                <a href="{{ route('frontend.terms.index') }}" class="text-white hover-text-base">الشروط والأحكام</a>
            </div>
        </div>
    </div>
</section>
<!-- ================================= Footer Section End =============================== -->
