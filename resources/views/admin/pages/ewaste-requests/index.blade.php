@extends('admin.layouts.master')

@section('page-title')
    طلبات جمع / التبرع بالنفايات الإلكترونية
@stop

@section('css')
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
                    <h5 class="page-title fs-21 mb-1">طلبات جمع / التبرع بالنفايات الإلكترونية</h5>
                </div>
                <div>
                    <a href="{{ route('frontend.ewaste.request') }}" class="btn btn-info btn-sm" target="_blank">
                        <i class="bi bi-link-45deg"></i> نموذج الطلب
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex gap-3">
                            <form action="{{ route('admin.ewaste-requests.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2 w-100">
                                <input type="text" name="search" class="form-control" style="width: 200px"
                                    placeholder="بحث بالاسم، الهاتف، البريد..." value="{{ request('search') }}">

                                <select name="request_type" class="form-select" style="width: 200px">
                                    <option value="">كل الأنواع</option>
                                    @foreach(\App\Models\EwasteRequest::REQUEST_TYPES as $key => $label)
                                        <option value="{{ $key }}" {{ request('request_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>

                                <select name="entity_type" class="form-select" style="width: 180px">
                                    <option value="">كل الجهات</option>
                                    @foreach(\App\Models\EwasteRequest::ENTITY_TYPES as $key => $label)
                                        <option value="{{ $key }}" {{ request('entity_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>

                                <input type="text" name="city" class="form-control" style="width: 130px" placeholder="المدينة" value="{{ request('city') }}">

                                <select name="status" class="form-select" style="width: 150px">
                                    <option value="">كل الحالات</option>
                                    @foreach(\App\Models\EwasteRequest::STATUSES as $key => $label)
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>

                                <input type="date" name="date_from" class="form-control" style="width: 140px" placeholder="من تاريخ" value="{{ request('date_from') }}">
                                <input type="date" name="date_to" class="form-control" style="width: 140px" placeholder="إلى تاريخ" value="{{ request('date_to') }}">

                                <button type="submit" class="btn btn-secondary">بحث</button>
                                <a href="{{ route('admin.ewaste-requests.index') }}" class="btn btn-outline-danger">مسح</a>
                            </form>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 50px;">#</th>
                                            <th scope="col">نوع الطلب</th>
                                            <th scope="col">الجهة</th>
                                            <th scope="col">المسؤول</th>
                                            <th scope="col">الهاتف</th>
                                            <th scope="col">المدينة</th>
                                            <th scope="col">التاريخ</th>
                                            <th scope="col">الحالة</th>
                                            <th scope="col" style="min-width: 120px;">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($requests as $req)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration + ($requests->currentPage() - 1) * $requests->perPage() }}</th>
                                                <td>{{ $req->request_type_label }}</td>
                                                <td>
                                                    <span class="badge bg-light text-dark">{{ $req->entity_type_label }}</span>
                                                    <div>{{ Str::limit($req->entity_name, 25) }}</div>
                                                </td>
                                                <td>{{ $req->responsible_name }}</td>
                                                <td>
                                                    {{ $req->phone }}
                                                    @if($req->whatsapp)
                                                        <br><small class="text-muted">واتساب: {{ $req->whatsapp }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $req->city }} / {{ Str::limit($req->district, 15) }}</td>
                                                <td>{{ $req->request_date->format('Y-m-d') }}</td>
                                                <td>
                                                    @php
                                                        $badges = [
                                                            'pending' => 'bg-warning',
                                                            'in_progress' => 'bg-info',
                                                            'completed' => 'bg-success',
                                                            'cancelled' => 'bg-secondary',
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $badges[$req->status] ?? 'bg-secondary' }}">{{ $req->status_label }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.ewaste-requests.show', $req) }}" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-eye"></i> عرض
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4 text-muted">لا توجد طلبات</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($requests->hasPages())
                                <div class="mt-3">
                                    {{ $requests->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
