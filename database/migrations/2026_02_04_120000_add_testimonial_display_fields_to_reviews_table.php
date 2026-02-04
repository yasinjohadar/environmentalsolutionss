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
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('client_name')->nullable()->after('title')->comment('اسم العميل للعرض في الشهادات');
            $table->string('client_title')->nullable()->after('client_name')->comment('المسمى الوظيفي للعرض');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['client_name', 'client_title']);
        });
    }
};
