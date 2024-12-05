<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Administrator ', 'wp_role_name' => 'administrator']);
        Role::create(['name' => 'Author', 'wp_role_name' => 'author']);
        Role::create(['name' => 'Contributor', 'wp_role_name' => 'contributor']);
        Role::create(['name' => 'Editor', 'wp_role_name' => 'editor']);
        Role::create(['name' => 'Group leader', 'wp_role_name' => 'group_leader']);
        Role::create(['name' => 'subscriber', 'wp_role_name' => 'subscriber']);
        Role::create(['name' => 'نمایش تجهیزات بدون قیمت', 'wp_role_name' => 'um_custom_role_1']);
        Role::create(['name' => 'نمایش تجهیزات با قیمت', 'wp_role_name' => 'um_custom_role_2']);
        Role::create(['name' => 'مدیر سامانه', 'wp_role_name' => 'um_custom_role_3']);
        Role::create(['name' => 'خرید خدمات', 'wp_role_name' => 'um_custom_role_5']);
        Role::create(['name' => 'مدیریت شرکت', 'wp_role_name' => 'um_custom_role_6']);
        Role::create(['name' => 'خرید خدمات - نیاز به تایید جهت انتشار', 'wp_role_name' => 'um_custom_role_7']);
        Role::create(['name' => '_', 'wp_role_name' => '_']);
    }
}
