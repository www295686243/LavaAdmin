<?php

namespace Database\Seeders\Data;

use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\Old\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Kra8\Snowflake\Snowflake;

class OrderTableSeeder extends Seeder
{
  /**
   * @throws \Exception
   */
  public function run()
  {
    $lists = Order::where('pay_status', 1)->get()->chunk(1000);
    foreach ($lists as $list) {
      $result = [];
      $arr = [];
      foreach ($list as $item) {
        $arr['id'] = app(Snowflake::class)->next();
        $arr['user_id'] = $item->user_id;
        $arr['user_orderable_type'] = $item->info_classify === 'job' ? HrJob::class : HrResume::class;
        $arr['user_orderable_id'] = $item->info_id;
        $arr['total_amount'] = $item->amount;
        $arr['coupon_amount'] = $item->amount;
        $arr['user_coupon_id'] = $item->coupon_id;
        $arr['pay_status'] = $item->pay_status;
        $arr['paid_at'] = $item->paid_at;
        $arr['source'] = $item->source;
        $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
        $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
        $result[] = $arr;
      }
      DB::table('user_orders')->insert($result);
    }
  }
}
