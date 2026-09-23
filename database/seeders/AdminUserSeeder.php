<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@lunara.vn']);
        $admin->name = 'Quản trị viên Lunara';
        $admin->password = 'admin123456';
        $admin->role = User::ROLE_ADMIN;
        $admin->save();
    }
}
