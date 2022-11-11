<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'name' => 'Admin',
           'email' => 'admin@test.com',
           'email_verified_at'  => now(),
           'password'           => bcrypt('password123'),
            'is_admin'          => true
        ]);
    }
}
