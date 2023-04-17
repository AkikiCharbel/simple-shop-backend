<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::factory()->create([
             'name' => 'Admin User',
             'email' => 'admin@admin.com',
             'is_admin' => true,
         ]);

         for ($i = 0; $i++; $i < 10) {
             User::factory()->create([
                 'name' => 'user '.$i,
                 'email' => 'user-'.$i.'@example.com',
             ]);
         }
    }
}
