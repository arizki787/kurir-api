<?php

namespace Database\Seeders;

use App\Models\Courier;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    public function run(): void
    {
        // random fake couriers
        Courier::factory()->count(30)->create();

        // a few fixed ones for predictable manual testing
        Courier::factory()->create([
            'name'      => 'Budiono Hadi Agung',
            'email'     => 'budiono@example.com',
            'level'     => 3,
            'joined_at' => '2023-05-10',
        ]);

        Courier::factory()->create([
            'name'      => 'Siti Aminah',
            'email'     => 'siti@example.com',
            'level'     => 2,
            'joined_at' => '2024-01-20',
        ]);

        Courier::factory()->create([
            'name'      => 'Agus Budiman',
            'email'     => 'agus@example.com',
            'level'     => 5,
            'joined_at' => '2022-11-02',
        ]);
    }
}