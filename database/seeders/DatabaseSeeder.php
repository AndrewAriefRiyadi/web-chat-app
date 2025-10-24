<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'andru',
            'password' => Hash::make('andru123'),
        ]);

        User::factory()->create([
            'username' => 'ainun',
            'password' => Hash::make('ainun123'),
        ]);

        User::factory()->create([
            'username' => 'attar',
            'password' => Hash::make('attar123'),
        ]);
    }
}
