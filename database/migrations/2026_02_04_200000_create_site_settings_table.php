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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            // عام
            $table->string('site_name')->default('حلول بيئية');
            $table->string('logo')->nullable()->comment('مسار الشعار الرئيسي');
            $table->string('logo_dark')->nullable()->comment('الشعار للنمط الداكن');
            $table->string('favicon')->nullable()->comment('أيقونة المفضلة');
            // الفوتر
            $table->string('footer_background')->nullable()->comment('خلفية الفوتر');
            $table->text('footer_description')->nullable()->comment('وصف الفوتر');
            // وسائل التواصل
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('pinterest_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('snapchat_url')->nullable();
            $table->string('telegram_url')->nullable();
            // التواصل
            $table->string('phone')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('email')->nullable();
            $table->string('email_2')->nullable();
            $table->text('address')->nullable();
            // حقل JSON للتطوير المستقبلي
            $table->json('meta')->nullable()->comment('بيانات إضافية للتطوير');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
