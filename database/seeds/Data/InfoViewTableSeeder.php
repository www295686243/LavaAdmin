<?php

namespace Database\Seeders\Data;

use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\Old\ShareViewLog;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Kra8\Snowflake\Snowflake;

class InfoViewTableSeeder extends Seeder
{
  /**
   * @throws \Exception
   */
  public function run()
  {
    $userIds = User::all()->pluck('id');
    $lists = ShareViewLog::whereIn('user_id', $userIds)->get();
    $result = [];
    $arr = [];
    foreach ($lists as $item) {
      $arr['id'] = app(Snowflake::class)->next();
      $arr['info_viewable_type'] = $item->info_classify === 'job' ? HrJob::class : HrResume::class;
      $arr['info_viewable_id'] = $item->info_id;
      $arr['share_user_id'] = $item->share_user_id;
      $arr['user_id'] = $item->user_id;
      $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
      $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
      $result[] = $arr;
    }
    DB::table('info_views')->insert($result);
  }
}
