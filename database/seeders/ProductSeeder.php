<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CustomizationOption;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $snackCategory = Category::where('slug', 'snack')->first();
        $minumanCategory = Category::where('slug', 'minuman')->first();

        if (!$snackCategory || !$minumanCategory) {
            $this->command->error('❌ Gagal: Kategori Snack atau Minuman belum dibuat.');
            return;
        }

        // $minumanProducts = [
        //     [
        //         'name' => 'Air Putih',
        //         'price' => 5000,
        //         'description' => 'Air putih mineral segar',
        //         'category_id' => $minumanCategory->id,
        //     ]
        // ];

        $snackProducts = [
            [
                'name' => 'Chitato Sapi Panggang',
                'price' => 20000,
                'description' => 'Keripik kentang rasa sapi panggang',
                'category_id' => $snackCategory->id,
            ],
            [
                'name' => 'Chitato Lite',
                'price' => 20000,
                'description' => 'Chitato versi lite dengan kalori lebih rendah',
                'category_id' => $snackCategory->id,
            ],
            [
                'name' => 'Maxicorn Barbecue',
                'price' => 22000,
                'description' => 'Snack corn dengan rasa barbecue',
                'category_id' => $snackCategory->id,
            ],
            [
                'name' => 'Chitato Rumput Laut',
                'price' => 25000,
                'description' => 'Snack corn dengan rasa rumput laut',
                'category_id' => $snackCategory->id,
            ],
            [
                'name' => 'Happytos Jagung Bakar',
                'price' => 21000,
                'description' => 'Snack corn dengan rasa jagung bakar',
                'category_id' => $snackCategory->id,
            ]
        ];

        $allProducts = array_merge($snackProducts);
        $allOptionIds = CustomizationOption::all()->pluck('id')->toArray();

        if (empty($allOptionIds)) {
            $this->command->error('⚠️ Warning: No Customization Options found. Did CustomizationOptionSeeder run?');
        }

        $allProducts = $snackProducts;

        foreach ($allProducts as $productData) {

            $product = Product::firstOrCreate(
                ['slug' => Str::slug($productData['name'])],
                array_merge($productData, [
                    'slug' => Str::slug($productData['name']),
                ])
            );

            if ($product->category_id === $snackCategory->id && !empty($allOptionIds)) {
                $product->customizationOptions()->sync($allOptionIds);
            }
        }

        $this->command->info('✅ All food and drink products seeded successfully!');
        $this->command->info('Products: ' . Product::count());
    }
}