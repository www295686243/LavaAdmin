<?php

namespace Database\Seeders\Data;

use App\Models\Info\Hr\HrResume;
use App\Models\Old\Resume;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Kra8\Snowflake\Snowflake;

class ResumeTableSeeder extends Seeder
{
  /**
   * @throws \Exception
   */
  public function run()
  {
    $userIds = User::all()->pluck('id');
    $lists = Resume::with('resume_sub')
      ->whereIn('user_id', $userIds)
      ->get()
      ->chunk(500);
    foreach ($lists as $list) {
      $result = [];
      $arr = [];
      $result2 = [];
      $arr2 = [];
      foreach ($list as $item) {
        if (!$item->resume_sub) {
          continue;
        }
        $arr['id'] = $item->id;
        $arr['user_id'] = $item->user_id;
        $arr['title'] = $item->title;
        $arr['intro'] = $item->intro;
        $arr['monthly_salary_min'] = $item->monthly_pay_min;
        $arr['monthly_salary_max'] = $item->monthly_pay_max;
        $arr['is_negotiate'] = $item->is_negotiate;
        $arr['education'] = $item->education;
        $arr['seniority'] = $item->seniority;
        $arr['treatment'] = $this->getTreatment($item->resume_sub->treatment);
        $arr['city'] = $item->city;
        $arr['end_time'] = $item->end_time;
        $arr['contacts'] = $item->contacts;
        $arr['phone'] = $item->phone;
        $arr['status'] = $item->status;
        $arr['views'] = $item->views;
        $arr['pay_count'] = $item->pay_count;
        $arr['refresh_at'] = $item->refresh_at;
        $arr['admin_user_id'] = $item->admin_user_id;
        $arr['created_at'] = $item->created_at->format('Y-m-d H:i:s');
        $arr['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
        $result[] = $arr;

        $arr2['id'] = app(Snowflake::class)->next();
        $arr2['info_subable_type'] = HrResume::class;
        $arr2['info_subable_id'] = $item->id;
        $arr2['description'] = $item->resume_sub->description;
        $arr2['created_at'] = $item->created_at->format('Y-m-d H:i:s');
        $arr2['updated_at'] = $item->updated_at->format('Y-m-d H:i:s');
        $result2[] = $arr2;
      }
      DB::table('hr_resumes')->insert($result);
      DB::table('info_subs')->insert($result2);
    }
  }

  private function getTreatment($treatment)
  {
    if ($treatment) {
      if (count($treatment)) {
        return implode(',', $treatment['tags']);
      } else {
        return null;
      }
    } else {
      return null;
    }
  }
}
