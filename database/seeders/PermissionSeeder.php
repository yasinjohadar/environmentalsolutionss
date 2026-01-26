<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // صلاحيات الأدوار
            "role-list",
            "role-create",
            "role-edit",
            "role-delete",

            // صلاحيات المستخدمين
            "user-list",
            "user-create",
            "user-edit",
            "user-delete",
            "user-show",

            // صلاحيات التصنيفات
            "category-list",
            "category-create",
            "category-edit",
            "category-delete",
            "category-show",

            // صلاحيات المنتجات
            "product-list",
            "product-create",
            "product-edit",
            "product-delete",
            "product-show",
            "product-featured",

            // صلاحيات آراء العملاء
            "review-list",
            "review-create",
            "review-edit",
            "review-delete",
            "review-show",
            "review-approve",
            "review-reject",
            "review-reply",
            "review-statistics",

            // صلاحيات إضافية للنظام
            "dashboard-view",
            "settings-manage",
            "reports-view",
        ];

        foreach ($permissions as $key => $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
