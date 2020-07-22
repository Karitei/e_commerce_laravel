<?php

use App\Category;
use Illuminate\Database\Seeder;

class categoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' =>'High Tech',
            'slug' =>'High Tech',
        ]);
        Category::create([
            'name' =>'Livre',
            'slug' =>'Livre',
        ]);
        Category::create([
            'name' =>'Meubles',
            'slug' =>'Meubles',
        ]);
        Category::create([
            'name' =>'Loisirs',
            'slug' =>'Loisirs',
        ]);




    }
}
