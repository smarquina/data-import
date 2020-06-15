<?php

use App\Http\Models\Product\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['Camisetas', 'Faldas', 'Pantalones', 'Abrigos', 'Camisas', 'Blusas'])->each(function ($name) {
            (new Category(['name' => $name]))->save();
        });
    }
}
