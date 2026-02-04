@extends('admin.layouts.master')

@section('page-title')
سلايدر الهيرو
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    @endif

    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div class="my-auto">
                    <h5 class="page-title fs-21 mb-1">شرائح سلايدر الهيرو</h5>
                    <p class="text-muted mb-0">إدارة شرائح قسم الهيرو في الصفحة الرئيسية</p>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>إضافة شريحة جديدة
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            @if($slides->isEmpty())
                                <div class="text-center py-5">
                                    <p class="text-muted mb-3">لا توجد شرائح حالياً</p>
                                    <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary">إضافة أول شريحة</a>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 80px;">الصورة</th>
                                                <th>العنوان</th>
                                                <th style="width: 80px;">الترتيب</th>
                                                <th style="width: 100px;">الحالة</th>
                                                <th style="width: 150px;">الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($slides as $slide)
                                                <tr>
                                                    <td>
                                                        @if($slide->background_image)
                                                            <img src="{{ $slide->background_image_url }}" alt="" class="rounded" style="width: 70px; height: 45px; object-fit: cover;">
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $slide->title ?? '—' }}</td>
                                                    <td>{{ $slide->order }}</td>
                                                    <td>
                                                        @if($slide->is_active)
                                                            <span class="badge bg-success">نشط</span>
                                                        @else
                                                            <span class="badge bg-secondary">غير نشط</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                                                        <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الشريحة؟');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
