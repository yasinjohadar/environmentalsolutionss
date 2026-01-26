<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('sku')->unique()->nullable()->comment('رمز المنتج');
            $table->string('barcode')->nullable()->comment('الباركود');
            $table->text('short_description')->nullable()->comment('وصف مختصر');
            $table->longText('description')->nullable()->comment('الوصف الكامل');
            $table->string('main_image')->nullable()->comment('الصورة الرئيسية');
            
            // الأسعار
            $table->decimal('price', 10, 2)->default(0)->comment('السعر الأساسي');
            $table->decimal('sale_price', 10, 2)->nullable()->comment('سعر التخفيض');
            $table->decimal('wholesale_price', 10, 2)->nullable()->comment('سعر الجملة');
            
            // المخزون
            $table->integer('stock_quantity')->default(0)->comment('الكمية المتوفرة');
            $table->integer('min_order_quantity')->default(1)->comment('الحد الأدنى للطلب');
            
            // الأبعاد والوزن
            $table->decimal('weight', 8, 2)->nullable()->comment('الوزن بالكيلو');
            $table->string('dimensions')->nullable()->comment('الأبعاد (الطول × العرض × الارتفاع)');
            
            // العلاقات
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            
            // الحالة
            $table->enum('status', ['active', 'inactive', 'draft'])->default('draft');
            $table->boolean('featured')->default(false)->comment('منتج مميز');
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('og_image')->nullable()->comment('صورة Open Graph');
            
            // تتبع المستخدمين
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('sku');
            $table->index('category_id');
            $table->index('status');
            $table->index('featured');
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
