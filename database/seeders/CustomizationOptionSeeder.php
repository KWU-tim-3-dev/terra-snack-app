<?php

namespace Database\Seeders;

use App\Models\CustomizationOption;
use App\Models\OptionValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomizationOptionSeeder extends Seeder
{
    public function run()
    {
        $sayurGroup = CustomizationOption::create([
            'name' => 'Sayur',
            'slug' => Str::slug('Sayur'),
            'type' => 'checkbox', // multiple selection
        ]);

        $sayurValues = [
            ['name' => 'Tomato', 'price_modifier' => 0, 'details' => []],
            ['name' => 'Timun', 'price_modifier' => 0, 'details' => []],
            ['name' => 'Sawi', 'price_modifier' => 0, 'details' => []],
        ];

        foreach ($sayurValues as $value) {
            $sayurGroup->optionValues()->create([
                'name' => $value['name'],
                'slug' => Str::slug($value['name']),
                'price_modifier' => $value['price_modifier'],
                'details' => $value['details'],
            ]);
        }

        // 2. Topping group
        $toppingGroup = CustomizationOption::create([
            'name' => 'Topping',
            'slug' => Str::slug('Topping'),
            'type' => 'checkbox', // multiple selection
        ]);

        $toppingValues = [
            ['name' => 'Mix Beef', 'price_modifier' => 0, 'details' => []],
            ['name' => 'Mix Chicken', 'price_modifier' => 0, 'details' => []],
            ['name' => 'Mix Beef & Chicken', 'price_modifier' => 0, 'details' => []],
        ];

        foreach ($toppingValues as $value) {
            $toppingGroup->optionValues()->create([
                'name' => $value['name'],
                'slug' => Str::slug($value['name']),
                'price_modifier' => $value['price_modifier'],
                'details' => $value['details'],
            ]);
        }

        // 3. Sauce group
        $sausGroup = CustomizationOption::create([
            'name' => 'Saus',
            'slug' => Str::slug('Saus'),
            'type' => 'radio', // single selection
        ]);

        $sausValues = [
            ['name' => 'Tar-Tar', 'price_modifier' => 0, 'details' => []],
            ['name' => 'Marinara', 'price_modifier' => 0, 'details' => []],
            ['name' => 'Cheese', 'price_modifier' => 0, 'details' => []],
            ['name' => 'Mixed', 'price_modifier' => 0, 'details' => []],
        ];

        foreach ($sausValues as $value) {
            $sausGroup->optionValues()->create([
                'name' => $value['name'],
                'slug' => Str::slug($value['name']),
                'price_modifier' => $value['price_modifier'],
                'details' => $value['details'],
            ]);
        }
    }
}