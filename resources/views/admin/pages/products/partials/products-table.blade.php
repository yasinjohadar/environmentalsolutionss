@forelse ($products as $product)
    <tr>
        <th scope="row">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</th>
        <td>
            @if($product->main_image_url)
                <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" 
                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>
            <a href="{{ route('admin.products.show', $product->id) }}" class="text-decoration-none">
                <strong>{{ $product->name }}</strong>
            </a>
            @if($product->featured)
                <span class="badge bg-warning text-dark ms-1">مميز</span>
            @endif
        </td>
        <td>
            <code class="text-primary">{{ $product->sku ?? '-' }}</code>
        </td>
        <td>
            @if($product->category)
                <span class="badge bg-info">{{ $product->category->name }}</span>
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <td>
            @if($product->isOnSale())
                <div>
                    <span class="text-decoration-line-through text-muted">{{ number_format($product->price, 2) }}</span>
                    <span class="text-danger fw-bold ms-2">{{ number_format($product->sale_price, 2) }} ر.س</span>
                </div>
                <small class="text-success">خصم {{ $product->discount_percentage }}%</small>
            @else
                <span class="fw-bold">{{ number_format($product->price, 2) }} ر.س</span>
            @endif
        </td>
        <td>
            @if($product->isInStock())
                <span class="badge bg-success">{{ $product->stock_quantity }}</span>
            @else
                <span class="badge bg-danger">نفد</span>
            @endif
        </td>
        <td>
            @if($product->status == 'active')
                <span class="badge bg-success">نشط</span>
            @elseif($product->status == 'inactive')
                <span class="badge bg-danger">غير نشط</span>
            @else
                <span class="badge bg-secondary">مسودة</span>
            @endif
        </td>
        <td>
            <div class="d-flex gap-2">
                @can('product-show')
                    <a href="{{ route('admin.products.show', $product->id) }}" 
                        class="btn btn-sm btn-info" title="عرض">
                        <i class="bi bi-eye"></i>
                    </a>
                @endcan
                @can('product-edit')
                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                        class="btn btn-sm btn-primary" title="تعديل">
                        <i class="bi bi-pencil"></i>
                    </a>
                @endcan
                @can('product-delete')
                    <button type="button" class="btn btn-sm btn-danger" 
                            title="حذف" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteProductModal"
                            data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->name }}">
                        <i class="bi bi-trash"></i>
                    </button>
                @endcan
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center py-4">
            <p class="text-muted mb-0">لا توجد منتجات</p>
        </td>
    </tr>
@endforelse
