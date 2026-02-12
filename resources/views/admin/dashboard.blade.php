@extends('admin.layouts.master')

@section('page-title')
لوحة التحكم
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">مرحباً، {{ auth()->user()->name ?? 'المسؤول' }}</h4>
                <p class="mb-0 text-muted">اختر أحد الاختصارات أدناه للوصول السريع</p>
            </div>
        </div>

        <div class="row g-3">
            @can('product-list')
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.products.index') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary">
                            <i class="ri-shopping-bag-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">المنتجات</h6>
                            <small class="text-muted">إدارة المنتجات والمخزون</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>
            @endcan

            @can('category-list')
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.categories.index') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success">
                            <i class="ri-folder-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">التصنيفات</h6>
                            <small class="text-muted">تصنيفات المنتجات</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>
            @endcan

            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.ewaste-requests.index') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info">
                            <i class="ri-recycle-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">طلبات النفايات الإلكترونية</h6>
                            <small class="text-muted">طلبات الجمع والتبرع</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>

            @can('review-list')
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.reviews.index') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning">
                            <i class="ri-star-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">آراء العملاء</h6>
                            <small class="text-muted">المراجعات والتقييمات</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>
            @endcan

            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.blog.posts.index') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-secondary bg-opacity-10 text-secondary">
                            <i class="ri-article-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">المدونة</h6>
                            <small class="text-muted">المقالات والتصنيفات</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.settings.site.edit') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-dark bg-opacity-10 text-dark">
                            <i class="ri-settings-3-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">إعدادات الموقع</h6>
                            <small class="text-muted">الشعار، التواصل، الفوتر</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.home-page.edit') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary">
                            <i class="ri-home-4-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">محتوى الصفحة الرئيسية</h6>
                            <small class="text-muted">نصوص وصور الصفحة الرئيسية</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.hero-slides.index') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success">
                            <i class="ri-image-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">سلايدر الهيرو</h6>
                            <small class="text-muted">بنر الصفحة الرئيسية</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.team-members.index') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info">
                            <i class="ri-team-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">فريق العمل</h6>
                            <small class="text-muted">أعضاء الفريق</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>

            @can('user-list')
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('users.index') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger">
                            <i class="ri-user-settings-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">المستخدمون</h6>
                            <small class="text-muted">إدارة الحسابات</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>
            @endcan

            @can('role-list')
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('roles.index') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-dark bg-opacity-10 text-dark">
                            <i class="ri-shield-keyhole-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">الصلاحيات</h6>
                            <small class="text-muted">الأدوار والصلاحيات</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>
            @endcan

            @can('settings-manage')
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.settings.email.index') }}" class="card border-0 shadow-sm hover-shadow text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="w-56-px h-56-px rounded-3 d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning">
                            <i class="ri-mail-line ri-2x"></i>
                        </span>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-dark">إعدادات البريد</h6>
                            <small class="text-muted">إرسال البريد الإلكتروني</small>
                        </div>
                        <i class="ri-arrow-left-s-line text-muted"></i>
                    </div>
                </a>
            </div>
            @endcan
        </div>

        <div class="mt-4">
            <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-primary">
                <i class="ri-external-link-line me-1"></i> عرض الموقع
            </a>
        </div>
    </div>
</div>
@stop

@section('styles')
<style>
.hover-shadow { transition: box-shadow 0.2s ease, transform 0.2s ease; }
.card.hover-shadow:hover { box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important; transform: translateY(-2px); }
</style>
@stop
