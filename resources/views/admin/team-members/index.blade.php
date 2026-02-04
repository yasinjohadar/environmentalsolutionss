@extends('admin.layouts.master')

@section('page-title')
فريق العمل
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
                    <h5 class="page-title fs-21 mb-1">أعضاء فريق العمل</h5>
                    <p class="text-muted mb-0">إدارة أعضاء قسم الفريق في الصفحة الرئيسية</p>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>إضافة عضو جديد
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            @if($members->isEmpty())
                                <div class="text-center py-5">
                                    <p class="text-muted mb-3">لا يوجد أعضاء حالياً</p>
                                    <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary">إضافة أول عضو</a>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 80px;">الصورة</th>
                                                <th>الاسم</th>
                                                <th>المسمى الوظيفي</th>
                                                <th style="width: 80px;">الترتيب</th>
                                                <th style="width: 100px;">الحالة</th>
                                                <th style="width: 150px;">الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($members as $member)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                    </td>
                                                    <td>{{ $member->name }}</td>
                                                    <td>{{ $member->title }}</td>
                                                    <td>{{ $member->order }}</td>
                                                    <td>
                                                        @if($member->is_active)
                                                            <span class="badge bg-success">نشط</span>
                                                        @else
                                                            <span class="badge bg-secondary">غير نشط</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.team-members.edit', $member) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                                                        <form action="{{ route('admin.team-members.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا العضو؟');">
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
