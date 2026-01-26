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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('color_id')->nullable()->constrained('product_colors')->onDelete('cascade');
            $table->foreignId('size_id')->nullable()->constrained('product_sizes')->onDelete('cascade');
            $table->string('sku')->unique()->nullable()->comment('رمز التباين');
            $table->decimal('price', 10, 2)->nullable()->comment('سعر التباين');
            $table->decimal('sale_price', 10, 2)->nullable()->comment('سعر التخفيض للتباين');
            $table->integer('stock_quantity')->default(0)->comment('مخزون التباين');
            $table->string('image')->nullable()->comment('صورة خاصة بالتباين');
            $table->timestamps();
            
            $table->index('product_id');
            $table->index('color_id');
            $table->index('size_id');
            $table->index('sku');
            
            // منع التكرار (لون + مقاس)
            $table->unique(['product_id', 'color_id', 'size_id'], 'unique_variant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
