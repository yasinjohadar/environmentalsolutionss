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
                            @can('product-delete')
                                <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-sm" style="display: none;" title="حذف المنتجات المحددة">
                                    <i class="bi bi-trash me-1"></i> حذف المحدد (<span id="bulk-selected-count">0</span>)
                                </button>
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

                                    <select name="per_page" id="filter-per-page" class="form-select" style="width: 120px" title="عدد المنتجات في الصفحة">
                                        <option value="10"  {{ request('per_page', 15) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15"  {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                                        <option value="25"  {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50"  {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                    <span class="text-muted small align-self-center">/ صفحة</span>

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
                                    <table class="table table-striped table-hover align-middle table-nowrap mb-0" id="products-table">
                                        <thead class="table-light">
                                            <tr>
                                                @can('product-delete')
                                                <th scope="col" style="width: 44px;">
                                                    <input type="checkbox" id="select-all-products" class="form-check-input" title="تحديد الكل">
                                                </th>
                                                @endcan
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

    {{-- نموذج الحذف الجماعي (مخفي، تُضاف ids[] عبر JS قبل الإرسال) --}}
    <form id="bulk-delete-form" method="POST" action="{{ route('admin.products.bulk-destroy') }}" style="display: none;">
        @csrf
    </form>

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
        // التحديد المتعدد والحذف الجماعي — استخدام تفويض الأحداث (delegation) ليعمل "تحديد الكل" بعد تحديث الجدول (مثلاً 100 عنصر)
        function updateBulkUI() {
            const tbody = document.getElementById('products-tbody');
            const checkboxes = tbody ? tbody.querySelectorAll('.product-row-checkbox') : [];
            const checked = tbody ? tbody.querySelectorAll('.product-row-checkbox:checked') : [];
            const n = checked.length;
            const total = checkboxes.length;
            const bulkCountSpan = document.getElementById('bulk-selected-count');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const selectAll = document.getElementById('select-all-products');
            if (bulkCountSpan) bulkCountSpan.textContent = n;
            if (bulkDeleteBtn) bulkDeleteBtn.style.display = n ? 'inline-block' : 'none';
            if (selectAll) {
                selectAll.checked = total > 0 && n === total;
                selectAll.indeterminate = n > 0 && n < total;
            }
        }

        function bindBulkDeleteEvents() {
            updateBulkUI();
            // لا نضيف مستمعين جدد لكل صف — نعتمد على المستمع المفوض على الجدول
        }

        // مستمع واحد على الجدول (لا يُستبدل عند AJAX) ليعمل مع أي عدد من الصفوف
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('products-table');
            if (!table) return;
            table.addEventListener('change', function(e) {
                if (e.target.id === 'select-all-products') {
                    const tbody = document.getElementById('products-tbody');
                    const checkboxes = tbody ? tbody.querySelectorAll('.product-row-checkbox') : [];
                    checkboxes.forEach(function(cb) { cb.checked = e.target.checked; });
                    updateBulkUI();
                } else if (e.target.classList && e.target.classList.contains('product-row-checkbox')) {
                    updateBulkUI();
                }
            });
            updateBulkUI();
        });

        // زر الحذف الجماعي (مرة واحدة فقط) — نضيف ids[] قبل الإرسال حتى يستقبل الخادم مصفوفة
        document.addEventListener('DOMContentLoaded', function() {
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');
            if (bulkDeleteBtn && bulkDeleteForm) {
                bulkDeleteBtn.addEventListener('click', function() {
                    const ids = Array.from(document.querySelectorAll('.product-row-checkbox:checked')).map(cb => cb.value);
                    if (ids.length === 0) {
                        alert('لم تحدد أي منتجات.');
                        return;
                    }
                    if (!confirm('هل أنت متأكد من حذف ' + ids.length + ' منتج/منتجات؟ لا يمكن التراجع عن هذا الإجراء.')) {
                        return;
                    }
                    // إزالة أي ids[] سابقة من النموذج
                    bulkDeleteForm.querySelectorAll('input[name="ids[]"]').forEach(function(el) { el.remove(); });
                    // إضافة حقل مخفي لكل معرّف حتى يصل الخادم ids كمصفوفة
                    ids.forEach(function(id) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        bulkDeleteForm.appendChild(input);
                    });
                    bulkDeleteForm.submit();
                });
            }
        });

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
                    
                    // إعادة ربط أحداث Pagination والتحديد المتعدد
                    bindPaginationEvents();
                    bindBulkDeleteEvents();
                    
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
            const filterPerPage = document.getElementById('filter-per-page');
            if (filterPerPage) {
                filterPerPage.addEventListener('change', performFilter);
            }

            // ربط أحداث Pagination والتحديد المتعدد عند تحميل الصفحة
            bindPaginationEvents();
            bindBulkDeleteEvents();
        });
    </script>
@stop
