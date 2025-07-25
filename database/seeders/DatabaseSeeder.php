<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class
        ]);

        User::factory()->create([
            'name' => 'Karla Muñoz',
            'email' => '2302091@utrivieramaya.edu.mx',
            'password' => 'password'
        ]);
    }
}
