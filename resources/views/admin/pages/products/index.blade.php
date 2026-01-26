@extends('admin.layouts.master')

@section('page-title')
    قائمة المنتجات
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    @endif

    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div class="my-auto">
                    <h5 class="page-title fs-21 mb-1">كافة المنتجات</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex gap-3">
                            @can('product-create')
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">إضافة منتج جديد</a>
                            @endcan

                            <div class="flex-shrink-0 ms-auto">
                                <form id="filter-form" action="{{ route('admin.products.index') }}" method="GET" class="d-flex align-items-center gap-2">
                                    <input style="width: 250px" type="text" name="query" id="search-query" class="form-control" 
                                        placeholder="بحث بالاسم، SKU أو الباركود" value="{{ request('query') }}">

                                    <select name="category_id" id="filter-category" class="form-select" style="width: 180px">
                                        <option value="">كل التصنيفات</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="status" id="filter-status" class="form-select" style="width: 150px">
                                        <option value="">كل الحالات</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                                    </select>

                                    <select name="featured" id="filter-featured" class="form-select" style="width: 150px">
                                        <option value="">الكل</option>
                                        <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>مميز</option>
                                        <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>عادي</option>
                                    </select>

                                    <button type="button" id="search-btn" class="btn btn-secondary">بحث</button>
                                    <button type="button" id="clear-btn" class="btn btn-danger">مسح</button>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="loading-indicator" class="text-center py-4" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">جاري التحميل...</span>
                                </div>
                                <p class="mt-2 text-muted">جاري البحث...</p>
                            </div>
                            
                            <div id="products-table-container">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 40px;">#</th>
                                                <th scope="col" style="min-width: 100px;">الصورة</th>
                                                <th scope="col" style="min-width: 200px;">الاسم</th>
                                                <th scope="col" style="min-width: 120px;">SKU</th>
                                                <th scope="col" style="min-width: 150px;">التصنيف</th>
                                                <th scope="col" style="min-width: 100px;">السعر</th>
                                                <th scope="col" style="min-width: 80px;">المخزون</th>
                                                <th scope="col" style="min-width: 100px;">الحالة</th>
                                                <th scope="col" style="min-width: 200px;">العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody id="products-tbody">
                                            @include('admin.pages.products.partials.products-table')
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3" id="pagination-container">
                                    {{ $products->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10" 
                             style="width: 80px; height: 80px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#dc3545" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </div>
                    </div>
                    <h4 class="modal-title mb-3" id="deleteProductModalLabel">تأكيد الحذف</h4>
                    <p class="text-muted mb-4">
                        هل أنت متأكد من حذف المنتج 
                        <strong class="text-dark" id="productNameToDelete"></strong>؟
                        <br>
                        <small class="text-danger">هذا الإجراء لا يمكن التراجع عنه!</small>
                    </p>
                    <form id="deleteProductForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i> إلغاء
                            </button>
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bi bi-trash me-1"></i> حذف المنتج
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        // Handle delete modal
        const deleteProductModal = document.getElementById('deleteProductModal');
        if (deleteProductModal) {
            deleteProductModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const productId = button.getAttribute('data-product-id');
                const productName = button.getAttribute('data-product-name');
                
                const modalTitle = deleteProductModal.querySelector('#productNameToDelete');
                const deleteForm = deleteProductModal.querySelector('#deleteProductForm');
                
                modalTitle.textContent = productName;
                deleteForm.action = '{{ route("admin.products.destroy", ":id") }}'.replace(':id', productId);
            });
        }

        // AJAX Filtering
        document.addEventListener('DOMContentLoaded', function() {
            let filterTimeout;
            const filterForm = document.getElementById('filter-form');
            const searchQuery = document.getElementById('search-query');
            const filterCategory = document.getElementById('filter-category');
            const filterStatus = document.getElementById('filter-status');
            const filterFeatured = document.getElementById('filter-featured');
            const searchBtn = document.getElementById('search-btn');
            const clearBtn = document.getElementById('clear-btn');
            const loadingIndicator = document.getElementById('loading-indicator');
            const productsTableContainer = document.getElementById('products-table-container');
            const productsTbody = document.getElementById('products-tbody');
            const paginationContainer = document.getElementById('pagination-container');

            // التحقق من وجود جميع العناصر
            if (!filterForm || !searchQuery || !filterCategory || !filterStatus || !filterFeatured || 
                !searchBtn || !clearBtn || !loadingIndicator || !productsTableContainer || 
                !productsTbody || !paginationContainer) {
                console.error('بعض عناصر الفلترة غير موجودة:', {
                    filterForm: !!filterForm,
                    searchQuery: !!searchQuery,
                    filterCategory: !!filterCategory,
                    filterStatus: !!filterStatus,
                    filterFeatured: !!filterFeatured,
                    searchBtn: !!searchBtn,
                    clearBtn: !!clearBtn,
                    loadingIndicator: !!loadingIndicator,
                    productsTableContainer: !!productsTableContainer,
                    productsTbody: !!productsTbody,
                    paginationContainer: !!paginationContainer
                });
                return;
            }

            console.log('تم تحميل نظام الفلترة بنجاح');

            function performFilter() {
                // إظهار مؤشر التحميل
                if (loadingIndicator) loadingIndicator.style.display = 'block';
                if (productsTableContainer) {
                    productsTableContainer.style.opacity = '0.5';
                    productsTableContainer.style.pointerEvents = 'none';
                }

                // جمع بيانات النموذج
                const formData = new FormData(filterForm);
                const params = new URLSearchParams();
                
                for (const [key, value] of formData.entries()) {
                    if (value) {
                        params.append(key, value);
                    }
                }

                // إرسال طلب AJAX
                fetch(`{{ route('admin.products.index') }}?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('تم استلام البيانات:', data);
                    
                    // تحديث الجدول
                    if (productsTbody && data.html) {
                        productsTbody.innerHTML = data.html;
                    } else {
                        console.error('productsTbody أو data.html غير موجود');
                    }
                    
                    // تحديث Pagination
                    if (paginationContainer && data.pagination) {
                        paginationContainer.innerHTML = data.pagination;
                    } else {
                        console.error('paginationContainer أو data.pagination غير موجود');
                    }
                    
                    // إعادة ربط أحداث Pagination
                    bindPaginationEvents();
                    
                    // إخفاء مؤشر التحميل
                    if (loadingIndicator) loadingIndicator.style.display = 'none';
                    if (productsTableContainer) {
                        productsTableContainer.style.opacity = '1';
                        productsTableContainer.style.pointerEvents = 'auto';
                    }

                    // تحديث URL بدون إعادة تحميل الصفحة
                    const newUrl = `{{ route('admin.products.index') }}?${params.toString()}`;
                    window.history.pushState({path: newUrl}, '', newUrl);
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (loadingIndicator) loadingIndicator.style.display = 'none';
                    if (productsTableContainer) {
                        productsTableContainer.style.opacity = '1';
                        productsTableContainer.style.pointerEvents = 'auto';
                    }
                    alert('حدث خطأ أثناء البحث. يرجى المحاولة مرة أخرى.');
                });
            }

            function bindPaginationEvents() {
                if (!paginationContainer || !filterForm) return;
                
                // ربط أحداث الروابط في Pagination
                const paginationLinks = paginationContainer.querySelectorAll('a[href]');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = new URL(this.href);
                        const page = url.searchParams.get('page');
                        
                        // إضافة رقم الصفحة إلى النموذج
                        const formData = new FormData(filterForm);
                        if (page) {
                            formData.set('page', page);
                        }
                        const params = new URLSearchParams();
                        for (const [key, value] of formData.entries()) {
                            if (value) {
                                params.append(key, value);
                            }
                        }
                        
                        // تحديث URL وإرسال الطلب
                        performFilter();
                    });
                });
            }

            // البحث عند الضغط على زر البحث
            if (searchBtn) {
                searchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    performFilter();
                });
            }

            // مسح الفلاتر
            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (searchQuery) searchQuery.value = '';
                    if (filterCategory) filterCategory.value = '';
                    if (filterStatus) filterStatus.value = '';
                    if (filterFeatured) filterFeatured.value = '';
                    performFilter();
                });
            }

            // البحث التلقائي عند الكتابة (مع تأخير)
            if (searchQuery) {
                searchQuery.addEventListener('input', function() {
                    clearTimeout(filterTimeout);
                    filterTimeout = setTimeout(() => {
                        performFilter();
                    }, 500); // انتظار 500ms بعد توقف الكتابة
                });
            }

            // الفلترة التلقائية عند تغيير القوائم المنسدلة
            if (filterCategory) {
                filterCategory.addEventListener('change', performFilter);
            }
            if (filterStatus) {
                filterStatus.addEventListener('change', performFilter);
            }
            if (filterFeatured) {
                filterFeatured.addEventListener('change', performFilter);
            }

            // ربط أحداث Pagination عند تحميل الصفحة
            bindPaginationEvents();
        });
    </script>
@stop
