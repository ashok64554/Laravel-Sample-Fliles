<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Carbon\Carbon;
use DB;
use Auth;

class CouponController extends Controller
{
    //

    function CheckCoupon(Request $request) {
      $couponCode = $request->coupon;

      if (empty($couponCode)) {
          return \Response::json([]);
      }

      $match = ['id' => $couponCode, 'valid' => 1];
      $coupon = Coupon::where($match)->first();

      if ($coupon) {
        $json_data = array(
            "id"                => $couponCode,
            "name"              => $coupon->name,
            "percent"             => $coupon->percent
        );

        echo json_encode($json_data);
      } else {
          return \Response::json([]);
      }

    }
}
