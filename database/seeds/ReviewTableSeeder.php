<?php

use App\Product;
use App\Review;
use Illuminate\Database\Seeder;

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::all()->each(function (Product $product){
           $reviews = factory(Review::class , random_int(5,30))->make();
           $product->reviews()->saveMany($reviews);
        });
    }
}
