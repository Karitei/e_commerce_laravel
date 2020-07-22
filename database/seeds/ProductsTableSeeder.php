<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i< 20; $i++){
            Product::create([
                'title' => $faker->sentence(6),
                'slug' => $faker->slug,
                'subtitle'=>$faker->sentence(10),
                'description' => $faker->text,
                'price' => $faker->numberBetween(20,400)*100,
                'image'=> $faker->imageUrl(200, 250),

            ])->categories()->attach([
                rand(1,4),
                rand(1,4)
            ]);
        }
    }
}
