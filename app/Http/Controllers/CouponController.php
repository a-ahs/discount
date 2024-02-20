<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Support\Discount\Coupon\CouponValidator;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function __construct(private CouponValidator $validator)
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        try {

            $this->validate($request,[
                'coupon' => ['required', 'exists:coupons,code']
            ]);
            $coupon = Coupon::where('code', $request->coupon)->firstOrFail();

            $this->validator->isValid($coupon);

            session()->put(['coupon' => $coupon]);
            return redirect()->back()->with('success', 'کد تخفیف با موفقیت اعمال شد');

        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'کد تخفیف نامعتبر میباشد');
        }
    }

    public function remove()
    {
        session()->forget('coupon');

        return back();
    }
}
