<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $couponable = $this->couponable();
        return [
            'code' => Str::random(4),
            'limit' => rand(1, 5) * 10000,
            'expire_time' => now()->addDays(1),
            'percent' => rand(1, 5) * 10,
            'couponable_id' => $couponable::factory(),
            'couponable_type' => $couponable
        ];
    }

    private function couponable()
    {
        return $this->faker->randomElement([
            User::class,
            Category::class
        ]);
    }
}
