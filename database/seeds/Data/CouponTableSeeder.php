<?php

namespace Database\Seeders\Data;

use App\Models\Old\Coupon;
use App\Models\Old\CouponMarket;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Kra8\Snowflake\Snowflake;

class CouponTableSeeder extends Seeder
{
  /**
   * @throws \Exception
   */
  public function run()
  {
    $userIds = User::all()->pluck('id');
    $lists = Coupon::whereIn('user_id', $userIds)->get();
    $result = [];
    $arr = [];
    foreach ($lists as $item) {
      $arr['id'] = $item->id;
      $arr['coupon_template_id'] = $item->coupon_template_id;
      $arr['user_id'] = $item->user_id;
      $arr['display_name'] = $item->name;
      $arr['desc'] = $item->desc;
      $arr['amount'] = $item->amount;
      $arr['coupon_status'] = $item->status + 1;
      $arr['start_at'] = $item->start_at;
      $arr['end_at'] = $item->end_at;
      $arr['source'] = $item->source;
      $arr['is_trade'] = $item->is_trade;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    DB::table('user_coupons')->insert($result);

    $lists = CouponMarket::where('status', 0)->get();
    $result = [];
    $arr = [];
    foreach ($lists as $item) {
      $arr['id'] = app(Snowflake::class)->next();
      $arr['sell_user_id'] = $item->sell_user_id;
      $arr['buy_user_id'] = $item->buy_user_id;
      $arr['user_coupon_id'] = $item->coupon_id;
      $arr['coupon_template_id'] = $item->coupon_template_id;
      $arr['amount'] = $item->amount;
      $arr['amount_sort'] = $item->amount_sort;
      $arr['status'] = 1;
      $arr['end_at'] = $item->end_at;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    DB::table('coupon_markets')->insert($result);
  }
}
