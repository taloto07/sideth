<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Category;
use App\Location;
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $electronic = Category::where('name', 'electronic')->first();
        $clothe = Category::where('name', 'clothe')->first();

        $phnom = Location::where('city', 'Phnom Penh')->first();
        $bat = Location::where('city', 'Battambong')->first();

        $faker = Faker::create();

        Post::create([
        	'title' => 'iphone 6', 
        	'description' => $faker->paragraph(),
        	'category_id' => $electronic->id,
        	'location_id' => $phnom->id
        ]);

        Post::create([
        	'title' => 'Motorola Z Play', 
        	'description' => $faker->paragraph(),
        	'category_id' => $electronic->id,
        	'location_id' => $bat->id
        ]);

        Post::create([
        	'title' => 'Shawl Neck Cardigan', 
        	'description' => $faker->paragraph(),
        	'category_id' => $clothe->id,
        	'location_id' => $phnom->id
        ]);

        Post::create([
        	'title' => 'Chino', 
        	'description' => $faker->paragraph(),
        	'category_id' => $clothe->id,
        	'location_id' => $bat->id
        ]);
    }
}
