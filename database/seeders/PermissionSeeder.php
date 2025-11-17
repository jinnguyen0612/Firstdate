<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Danh sách các bảng cần xóa dữ liệu
        $tables = ['model_has_permissions', 'model_has_roles', 'role_has_permissions', 'permissions', 'roles', 'modules'];

        // Xóa toàn bộ dữ liệu trong các bảng
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tạo roles
        DB::table('roles')->insert([
            'title' => 'Super Admin',
            'name' => 'superAdmin',
            'guard_name' => 'admin',
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        $superAdminRoleId = DB::getPdo()->lastInsertId();

        DB::table('roles')->insert([
            'title' => 'Sub Admin',
            'name' => 'subAdmin',
            'guard_name' => 'admin',
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('roles')->insert([
            'title' => 'Đối tác',
            'name' => 'partner',
            'guard_name' => 'partner',
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('roles')->insert([
            'title' => 'Người dùng',
            'name' => 'user',
            'guard_name' => 'user',
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        // Define modules
        $modules = [
            ['name' => 'QL Bài viết', 'description' => '<p>QL các Bài viết trong hệ thống</p>', 'key' => 'Post'],
            ['name' => 'QL Danh mục Bài viết', 'description' => '<p>QL Danh mục Bài viết</p>', 'key' => 'PostCategory'],
            ['name' => 'QL Người dùng', 'description' => '<p>QL Người dùng</p>', 'key' => 'User'],
            ['name' => 'QL Đối tác', 'description' => '<p>QL Đối tác</p>', 'key' => 'Partner'],
            ['name' => 'QL Slider', 'description' => '<p>QL Slider các hình ảnh chạy qua lại ở trang Web bên ngoài</p>', 'key' => 'Slider'],
            ['name' => 'QL Slider items', 'description' => '<p>QL các Hình ảnh bên trong một Slider</p>', 'key' => 'SliderItem'],
            ['name' => 'QL Thông báo', 'description' => '<p>QL Thông báo</p>', 'key' => 'Notification'],
            ['name' => 'QL Vai trò', 'description' => '<p>QL Vai trò</p>', 'key' => 'Role'],
            ['name' => 'QL Admin', 'description' => '<p>QL Admin</p>', 'key' => 'Admin'],
            ['name' => 'QL Loại Đối tác', 'description' => '<p>QL Loại Đối tác</p>', 'key' => 'PartnerCategory'],
            ['name' => 'QL Câu hỏi', 'description' => '<p>QL Câu hỏi</p>', 'key' => 'Question'],
            ['name' => 'QL Giao dịch', 'description' => '<p>QL Giao dịch</p>', 'key' => 'Transaction'],
            ['name' => 'QL Lịch hẹn', 'description' => '<p>QL Lịch hẹn</p>', 'key' => 'Booking'],
            ['name' => 'QL Thanh toán', 'description' => '<p>QL Thanh toán</p>', 'key' => 'Invoice'],
            ['name' => 'QL Tiêu đề App', 'description' => '<p>QL Tiêu đề App</p>', 'key' => 'AppTitle'],
            ['name' => 'QL Kèo', 'description' => '<p>QL Kèo</p>', 'key' => 'Deal'],
            ['name' => 'QL Bảng giá', 'description' => '<p>QL Bảng giá</p>', 'key' => 'PriceList'],
            ['name' => 'QL Bàn', 'description' => '<p>QL Bàn</p>', 'key' => 'PartnerTable'],
            ['name' => 'QL Danh mục Câu hỏi hỗ trợ', 'description' => '<p>QL Danh mục Câu hỏi hỗ trợ</p>', 'key' => 'SupportCategory'],
            ['name' => 'QL Câu hỏi hỗ trợ', 'description' => '<p>QL Câu hỏi hỗ trợ</p>', 'key' => 'Support'],
        ];

        // Vietnamese translations for module names
        $moduleTranslations = [
            'Post' => 'Bài viết',
            'PostCategory' => 'Danh mục bài viết',
            'User' => 'Người dùng',
            'Partner' => 'Đối tác',
            'Slider' => 'Slider',
            'SliderItem' => 'Hình ảnh slider',
            'Notification' => 'Thông báo',
            'Role' => 'Vai trò',
            'Admin' => 'Admin',
            'PartnerCategory' => 'Loại Đối tác',
            'Question' => 'Câu hỏi',
            'Transaction' => 'Giao dịch',
            'Booking' => 'Lịch hẹn',
            'Invoice' => 'Thanh toán',
            'AppTitle' => 'Tiêu đề App',
            'Deal' => 'Kèo',
            'PriceList' => 'Bảng giá',
            'PartnerTable' => 'Bàn',
            'SupportCategory' => 'Danh mục Câu hỏi hỗ trợ',
            'Support' => 'Câu hỏi hỗ trợ',
        ];

        // Insert modules and build module map
        $moduleMap = [];
        foreach ($modules as $module) {
            DB::table('modules')->insert([
                'name' => $module['name'],
                'description' => $module['description'],
                'status' => 2,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()')
            ]);

            $moduleMap[$module['key']] = DB::getPdo()->lastInsertId();
        }

        // Gán model_has_roles cho Super Admin
        DB::table('model_has_roles')->insert([
            'role_id' => $superAdminRoleId,
            'model_type' => 'AppModelsAdmin',
            'model_id' => 1
        ]);

        // Generate permissions
        $permissionIds = [];

        // 1. Add non-module permissions
        $nonModulePermissions = [
            ['title' => 'Xem tài liệu API', 'name' => 'readAPIDoc', 'guard_name' => 'admin'],
            ['title' => 'Cài đặt chung', 'name' => 'settingGeneral', 'guard_name' => 'admin'],
        ];

        foreach ($nonModulePermissions as $permission) {
            DB::table('permissions')->insert([
                'title' => $permission['title'],
                'name' => $permission['name'],
                'guard_name' => $permission['guard_name'],
                'module_id' => null,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()')
            ]);

            $permissionIds[] = DB::getPdo()->lastInsertId();
        }

        // 2. Generate standard CRUD permissions for all modules
        $crudOperations = [
            'view' => 'Xem',
            'create' => 'Thêm',
            'update' => 'Sửa',
            'delete' => 'Xóa'
        ];

        foreach ($modules as $module) {
            $moduleKey = $module['key'];
            $moduleId = $moduleMap[$moduleKey];
            $moduleViName = $moduleTranslations[$moduleKey];

            foreach ($crudOperations as $operation => $label) {
                // Format Vietnamese permission title
                $title = "$label $moduleViName";

                // Permission name stays the same in English camelCase
                $name = $operation . $moduleKey;

                DB::table('permissions')->insert([
                    'title' => $title,
                    'name' => $name,
                    'guard_name' => 'admin',
                    'module_id' => $moduleId,
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()')
                ]);

                $permissionIds[] = DB::getPdo()->lastInsertId();
            }
        }

        // Gán role_has_permissions cho Super Admin
        foreach ($permissionIds as $permissionId) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permissionId,
                'role_id' => $superAdminRoleId
            ]);
        }

        // Gán model_has_permissions cho Super Admin
        foreach ($permissionIds as $permissionId) {
            DB::table('model_has_permissions')->insert([
                'permission_id' => $permissionId,
                'model_type' => 'AppModelsAdmin',
                'model_id' => 1
            ]);
        }
    }
}
