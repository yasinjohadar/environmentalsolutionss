<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds contact columns to site_settings if they do not exist (e.g. table was created before these were added).
     */
    public function up(): void
    {
        if (!Schema::hasTable('site_settings')) {
            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('site_settings', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'phone_2')) {
                $table->string('phone_2')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'email_2')) {
                $table->string('email_2')->nullable();
            }
            if (!Schema::hasColumn('site_settings', 'address')) {
                $table->text('address')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('site_settings')) {
            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            $columns = ['phone', 'phone_2', 'email', 'email_2', 'address'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('site_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
