<?php

namespace Database\Seeders\Data;

use App\Models\Info\Hr\HrJob;
use App\Models\Old\InfoProvide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoProvideTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $lists = InfoProvide::all()->chunk(300);
    foreach ($lists as $list) {
      $result = [];
      $arr = [];
      foreach ($list as $item) {
        $arr['id'] = $item->id;
        $arr['user_id'] = $item->user_id;
        $arr['description'] = $item->description;
        $arr['phone'] = $item->phone;
        $arr['status'] = $item->status + 1;
        $arr['admin_user_id'] = $item->admin_user_id;
        $arr['is_admin'] = $item->is_admin;
        $arr['is_reward'] = $item->is_reward;
        $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
        $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
        $result[] = $arr;
      }
      DB::table('info_provides')->insert($result);
    }
  }
}
