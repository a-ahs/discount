<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement([
                'موبایل سامسونگ',
                'لپ تاپ سونی',
                'لپ تاپ فوجیتسو',
                'مچبند شیائومی',
                'اسپیکر هارمن کاردن',
                'مودم ADSL',
                'پاور بانک',
                'دوربین',
                'کابل صدا',
                'باتری موبایل',
                'کتابخوان',
                'ال جی مانیتور',
                'تبلت سامسونگ',
            ]),
            'descriptions' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه .',
    
            'image' => 'https://via.placeholder.com/286x180?text=Image',
            'price' => $this->faker->randomElement([
            150000 , 450000 , 252000 , 2521000 , 250000 , 150000 , 850000 , 650000, 450000 , 950000 , 410000 , 320000
            ]),
            'stock'=> $this->faker->randomDigitNotNull,
            'category_id' => $this->faker->randomElement([1, 2, 3]) 
        ];
    }
}
