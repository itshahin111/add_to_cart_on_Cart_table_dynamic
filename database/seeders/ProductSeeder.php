<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Generate 30 dummy products
        for ($i = 1; $i <= 30; $i++) {
            Product::create([
                'title' => $faker->words(3, true), // Generates a random product title
                'short_des' => $faker->sentence, // Generates a short description
                'price' => $faker->randomFloat(2, 10, 100), // Generates a random price between 10 and 100
                'stock' => $faker->numberBetween(5, 50), // Random stock between 5 and 50
                'image' => $this->generateImage($i), // Generates a random image for each product
            ]);
        }
    }
    /**
     * Generate a dummy image and save it to the public path.
     *
     * @param int $index
     * @return string
     */
    private function generateImage($index)
    {
        // Create a dummy image using Faker (using placeholder image service for simplicity)
        $imageUrl = 'https://picsum.photos/seed/' . $index . '/300/300'; // Random image URL
        $imageName = 'product_' . $index . '.jpg'; // Naming the image file

        // Download and save the image in the public storage (public/images/products)
        $imageContent = file_get_contents($imageUrl);
        Storage::put('public/images/products/' . $imageName, $imageContent);

        // Return the path where the image is stored
        return 'images/products/' . $imageName;
    }
}
