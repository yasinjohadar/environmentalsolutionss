<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('e_waste_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('request_type', ['donation', 'collection', 'campaign'])->comment('donation=تبرع, collection=جمع, campaign=حملة');
            $table->date('request_date');
            $table->enum('entity_type', ['individual', 'education', 'company', 'local_org', 'intl_org', 'government', 'other'])->comment('نوع الجهة');
            $table->string('entity_name');
            $table->string('responsible_name');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->default('حلب');
            $table->string('district');
            $table->string('address');
            $table->enum('accessibility', ['easy', 'needs_coordination', 'hard']);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('altitude', 10, 2)->nullable();
            $table->decimal('accuracy', 10, 2)->nullable();
            $table->json('waste_types')->comment('أنواع النفايات الإلكترونية');
            $table->unsignedInteger('device_count');
            $table->enum('device_condition', ['working', 'broken', 'mixed']);
            $table->enum('has_personal_data', ['yes', 'no', 'unknown']);
            $table->enum('delivery_method', ['self_deliver', 'need_pickup']);
            $table->date('suggested_date')->nullable();
            $table->json('images')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('consent')->default(false);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index('request_type');
            $table->index('entity_type');
            $table->index('city');
            $table->index('status');
            $table->index('request_date');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('e_waste_requests');
    }
};
