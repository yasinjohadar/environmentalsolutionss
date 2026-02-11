<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:product-list')->only('index');
        $this->middleware('permission:product-create')->only(['create', 'store']);
        $this->middleware('permission:product-edit')->only(['edit', 'update']);
        $this->middleware('permission:product-delete')->only(['destroy', 'bulkDestroy']);
        $this->middleware('permission:product-show')->only('show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productsQuery = Product::with(['category', 'images'])->latest();

        // البحث
        if ($request->filled('query')) {
            $search = $request->input('query');
            $productsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('sku', 'like', "%$search%")
                  ->orWhere('barcode', 'like', "%$search%")
                  ->orWhere('short_description', 'like', "%$search%");
            });
        }

        // فلترة حسب التصنيف
        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->input('category_id'));
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $productsQuery->where('status', $request->input('status'));
        }

        // فلترة حسب المنتجات المميزة
        if ($request->filled('featured')) {
            $productsQuery->where('featured', $request->input('featured'));
        }

        // فلترة حسب السعر
        if ($request->filled('price_min')) {
            $productsQuery->where('price', '>=', $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $productsQuery->where('price', '<=', $request->input('price_max'));
        }

        $perPage = (int) $request->input('per_page', 15);
        $allowed = [10, 15, 25, 50, 100];
        if (!in_array($perPage, $allowed, true)) {
            $perPage = 15;
        }
        $products = $productsQuery->paginate($perPage)->withQueryString();
        $categories = Category::active()->orderBy('name')->get();

        // إذا كان الطلب عبر AJAX، أرجع JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.pages.products.partials.products-table', compact('products'))->render(),
                'pagination' => view('admin.pages.products.partials.pagination', compact('products'))->render(),
            ]);
        }

        return view('admin.pages.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.pages.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            // تأكيد وجود الحقول الاختيارية التي قد لا تُرسل مع النموذج
            $data['featured'] = $request->boolean('featured');
            if (!isset($data['category_id'])) {
                $data['category_id'] = null;
            }

            // معالجة الصورة الرئيسية
            if ($request->hasFile('main_image')) {
                $mainImage = $request->file('main_image');
                $mainImageName = time() . '_main_' . Str::slug($data['name']) . '.' . $mainImage->getClientOriginalExtension();
                $data['main_image'] = $mainImage->storeAs('products/images', $mainImageName, 'public');
            }

            // معالجة صورة Open Graph
            if ($request->hasFile('og_image')) {
                $ogImage = $request->file('og_image');
                $ogImageName = time() . '_og_' . Str::slug($data['name']) . '.' . $ogImage->getClientOriginalExtension();
                $data['og_image'] = $ogImage->storeAs('products/og', $ogImageName, 'public');
            }

            // إنشاء slug إذا لم يتم توفيره
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // إنشاء المنتج
            $product = Product::create($data);

            // معالجة صور المعرض
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $imageName = time() . '_' . $index . '_' . Str::slug($product->name) . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('products/gallery', $imageName, 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'order' => $index,
                        'is_main' => $index === 0 && !$product->main_image,
                    ]);
                }
            }

            // معالجة الألوان
            if ($request->has('colors') && is_array($request->colors)) {
                foreach ($request->colors as $colorData) {
                    $colorName = trim($colorData['name'] ?? '');
                    if ($colorName === '') continue;

                    $colorImagePath = null;
                    if (isset($colorData['image']) && $colorData['image']) {
                        $colorImage = $colorData['image'];
                        $colorImageName = time() . '_color_' . Str::slug($colorName) . '.' . $colorImage->getClientOriginalExtension();
                        $colorImagePath = $colorImage->storeAs('products/colors', $colorImageName, 'public');
                    }
                    
                    ProductColor::create([
                        'product_id' => $product->id,
                        'name' => $colorName,
                        'hex_code' => $colorData['hex_code'] ?? null,
                        'image' => $colorImagePath,
                    ]);
                }
            }

            // معالجة المقاسات
            if ($request->has('sizes') && is_array($request->sizes)) {
                foreach ($request->sizes as $index => $sizeData) {
                    $sizeName = trim($sizeData['name'] ?? '');
                    if ($sizeName === '') continue;

                    ProductSize::create([
                        'product_id' => $product->id,
                        'name' => $sizeName,
                        'order' => $sizeData['order'] ?? $index,
                    ]);
                }
            }

            // معالجة التباينات
            if ($request->has('variants') && is_array($request->variants)) {
                foreach ($request->variants as $variantData) {
                    $variantImagePath = null;
                    if (isset($variantData['image']) && $variantData['image']) {
                        $variantImage = $variantData['image'];
                        $variantImageName = time() . '_variant_' . Str::random(8) . '.' . $variantImage->getClientOriginalExtension();
                        $variantImagePath = $variantImage->storeAs('products/variants', $variantImageName, 'public');
                    }
                    
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id' => $variantData['color_id'] ?? null,
                        'size_id' => $variantData['size_id'] ?? null,
                        'sku' => $variantData['sku'] ?? null,
                        'price' => $variantData['price'] ?? null,
                        'sale_price' => $variantData['sale_price'] ?? null,
                        'stock_quantity' => $variantData['stock_quantity'] ?? 0,
                        'image' => $variantImagePath,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'تم إضافة المنتج بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إضافة المنتج: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'images', 'colors', 'sizes', 'variants.color', 'variants.size', 'creator', 'updater'])
            ->findOrFail($id);
        
        return view('admin.pages.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with(['images', 'colors', 'sizes', 'variants'])->findOrFail($id);
        $categories = Category::active()->orderBy('name')->get();
        
        return view('admin.pages.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $data = $request->validated();

            Log::info('Product update: request received', [
                'product_id' => $id,
                'has_main_image' => $request->hasFile('main_image'),
                'has_og_image' => $request->hasFile('og_image'),
            ]);

            // استبعاد الملفات من $data قبل التحديث (تجنب حفظ UploadedFile)
            foreach (['main_image', 'og_image'] as $fileKey) {
                if (isset($data[$fileKey]) && $data[$fileKey] instanceof UploadedFile) {
                    unset($data[$fileKey]);
                }
            }

            // معالجة الصورة الرئيسية
            if ($request->hasFile('main_image')) {
                $mainImage = $request->file('main_image');
                Log::info('Product image upload: starting', [
                    'product_id' => $id,
                    'file_name' => $mainImage->getClientOriginalName(),
                    'file_size' => $mainImage->getSize(),
                    'mime_type' => $mainImage->getMimeType(),
                ]);

                $this->deleteProductImage($product->main_image);

                $mainImageName = time() . '_main_' . Str::slug($data['name']) . '.' . $mainImage->getClientOriginalExtension();
                $storedPath = $mainImage->storeAs('products/images', $mainImageName, 'public');
                $data['main_image'] = $storedPath;

                Log::info('Product image upload: saved', [
                    'product_id' => $id,
                    'stored_path' => $storedPath,
                ]);
            }

            // معالجة صورة Open Graph
            if ($request->hasFile('og_image')) {
                $this->deleteProductImage($product->og_image);

                $ogImage = $request->file('og_image');
                $ogImageName = time() . '_og_' . Str::slug($data['name']) . '.' . $ogImage->getClientOriginalExtension();
                $data['og_image'] = $ogImage->storeAs('products/og', $ogImageName, 'public');
            }

            // إنشاء slug إذا لم يتم توفيره
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // تحديث المنتج
            $product->update($data);

            // معالجة صور المعرض الجديدة
            if ($request->hasFile('images')) {
                $existingImagesCount = $product->images()->count();
                foreach ($request->file('images') as $index => $image) {
                    $imageName = time() . '_' . ($existingImagesCount + $index) . '_' . Str::slug($product->name) . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('products/gallery', $imageName, 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'order' => $existingImagesCount + $index,
                        'is_main' => false,
                    ]);
                }
            }

            // تحديث الألوان (حذف القديمة وإضافة الجديدة)
            if ($request->has('colors')) {
                $product->colors()->delete();
                if (is_array($request->colors)) {
                    foreach ($request->colors as $colorData) {
                        $colorName = trim($colorData['name'] ?? '');
                        if ($colorName === '') continue;

                        $colorImagePath = null;
                        if (isset($colorData['image']) && $colorData['image']) {
                            $colorImage = $colorData['image'];
                            $colorImageName = time() . '_color_' . Str::slug($colorName) . '.' . $colorImage->getClientOriginalExtension();
                            $colorImagePath = $colorImage->storeAs('products/colors', $colorImageName, 'public');
                        }
                        
                        ProductColor::create([
                            'product_id' => $product->id,
                            'name' => $colorName,
                            'hex_code' => $colorData['hex_code'] ?? null,
                            'image' => $colorImagePath,
                        ]);
                    }
                }
            }

            // تحديث المقاسات
            if ($request->has('sizes')) {
                $product->sizes()->delete();
                if (is_array($request->sizes)) {
                    foreach ($request->sizes as $index => $sizeData) {
                        $sizeName = trim($sizeData['name'] ?? '');
                        if ($sizeName === '') continue;

                        ProductSize::create([
                            'product_id' => $product->id,
                            'name' => $sizeName,
                            'order' => $sizeData['order'] ?? $index,
                        ]);
                    }
                }
            }

            // تحديث التباينات
            if ($request->has('variants')) {
                $product->variants()->delete();
                if (is_array($request->variants)) {
                    foreach ($request->variants as $variantData) {
                        $variantImagePath = null;
                        if (isset($variantData['image']) && $variantData['image']) {
                            $variantImage = $variantData['image'];
                            $variantImageName = time() . '_variant_' . Str::random(8) . '.' . $variantImage->getClientOriginalExtension();
                            $variantImagePath = $variantImage->storeAs('products/variants', $variantImageName, 'public');
                        }
                        
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color_id' => $variantData['color_id'] ?? null,
                            'size_id' => $variantData['size_id'] ?? null,
                            'sku' => $variantData['sku'] ?? null,
                            'price' => $variantData['price'] ?? null,
                            'sale_price' => $variantData['sale_price'] ?? null,
                            'stock_quantity' => $variantData['stock_quantity'] ?? 0,
                            'image' => $variantImagePath,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.edit', $product->id)
                ->with('success', 'تم تحديث المنتج بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update failed: ' . $e->getMessage(), [
                'product_id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث المنتج: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);

            // حذف الصور
            if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                Storage::disk('public')->delete($product->main_image);
            }
            if ($product->og_image && Storage::disk('public')->exists($product->og_image)) {
                Storage::disk('public')->delete($product->og_image);
            }

            // حذف صور المعرض
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }

            // حذف صور الألوان
            foreach ($product->colors as $color) {
                if ($color->image && Storage::disk('public')->exists($color->image)) {
                    Storage::disk('public')->delete($color->image);
                }
            }

            // حذف صور التباينات
            foreach ($product->variants as $variant) {
                if ($variant->image && Storage::disk('public')->exists($variant->image)) {
                    Storage::disk('public')->delete($variant->image);
                }
            }

            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'تم حذف المنتج بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.products.index')
                ->with('error', 'حدث خطأ أثناء حذف المنتج: ' . $e->getMessage());
        }
    }

    /**
     * حذف جماعي للمنتجات المحددة
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:products,id',
        ]);

        DB::beginTransaction();
        try {
            $ids = $request->input('ids');
            $deleted = 0;

            foreach ($ids as $id) {
                $product = Product::find($id);
                if (!$product) {
                    continue;
                }

                if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                    Storage::disk('public')->delete($product->main_image);
                }
                if ($product->og_image && Storage::disk('public')->exists($product->og_image)) {
                    Storage::disk('public')->delete($product->og_image);
                }
                foreach ($product->images as $image) {
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                }
                foreach ($product->colors as $color) {
                    if ($color->image && Storage::disk('public')->exists($color->image)) {
                        Storage::disk('public')->delete($color->image);
                    }
                }
                foreach ($product->variants as $variant) {
                    if ($variant->image && Storage::disk('public')->exists($variant->image)) {
                        Storage::disk('public')->delete($variant->image);
                    }
                }

                $product->delete();
                $deleted++;
            }

            DB::commit();

            $message = $deleted === 1
                ? 'تم حذف منتج واحد بنجاح'
                : "تم حذف {$deleted} منتجات بنجاح";

            return redirect()->route('admin.products.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.products.index')
                ->with('error', 'حدث خطأ أثناء الحذف الجماعي: ' . $e->getMessage());
        }
    }

    /**
     * Delete product image - supports frontend/uploads/ and storage paths
     */
    protected function deleteProductImage(?string $path): void
    {
        if (!$path) {
            return;
        }
        $path = ltrim($path, '/');
        if (str_starts_with($path, 'frontend/uploads/')) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        } elseif (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Delete product image
     */
    public function deleteImage(Request $request, $productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = ProductImage::where('product_id', $product->id)->findOrFail($imageId);

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json(['success' => true, 'message' => 'تم حذف الصورة بنجاح']);
    }

    /**
     * Update image order
     */
    public function updateImageOrder(Request $request, $productId)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*.id' => 'required|exists:product_images,id',
            'images.*.order' => 'required|integer',
        ]);

        foreach ($request->images as $imageData) {
            ProductImage::where('id', $imageData['id'])
                ->where('product_id', $productId)
                ->update(['order' => $imageData['order']]);
        }

        return response()->json(['success' => true, 'message' => 'تم تحديث ترتيب الصور بنجاح']);
    }

    /**
     * Set main image
     */
    public function setMainImage(Request $request, $productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        
        // إلغاء تحديد جميع الصور كرئيسية
        ProductImage::where('product_id', $product->id)->update(['is_main' => false]);
        
        // تحديد الصورة المحددة كرئيسية
        $image = ProductImage::where('product_id', $product->id)->findOrFail($imageId);
        $image->update(['is_main' => true]);

        // تحديث الصورة الرئيسية في جدول المنتجات
        $product->update(['main_image' => $image->image_path]);

        return response()->json(['success' => true, 'message' => 'تم تعيين الصورة الرئيسية بنجاح']);
    }
}
