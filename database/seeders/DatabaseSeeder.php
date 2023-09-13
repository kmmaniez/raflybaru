<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'ADMIN',
            'email' => 'admin@gmail.com',
            'is_admin' => true
        ]);
        \App\Models\User::factory()->create([
            'name' => 'OWNER',
            'email' => 'owner@mail.com',
            'is_admin' => false
        ]);

        $product = [
            'oxford',
            'tc',
            'aliano',
        ];
        for ($i=0; $i < count($product); $i++) { 
            \App\Models\MasterProduk::factory()->create([
                'nama_produk' => $product[$i]
            ]);
        }
    }
}
