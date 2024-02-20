<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = ['ASDF', 'ZXCV'];

        foreach ($coupons as $coupon)
        {
            Coupon::factory()->create([
                'code' => $coupon
            ]);
        }
    }
}
