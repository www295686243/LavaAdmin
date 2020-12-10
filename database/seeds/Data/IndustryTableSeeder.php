<?php

namespace Database\Seeders\Data;

use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\Old\Industry;
use App\Models\Old\Job;
use App\Models\Old\Resume;
use App\Models\User\User;
use App\Models\User\UserEnterprise;
use App\Models\User\UserPersonal;
use Illuminate\Database\Seeder;

class IndustryTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $userIds = User::all()->pluck('id');
    // 职位
    $lists = Job::whereHas('job_sub')
      ->whereIn('user_id', $userIds)
      ->get()
      ->chunk(200);
    foreach ($lists as $list) {
      foreach ($list as $item) {
        if ($item->industries && count($item->industries)) {
          $oldIndustryNames = Industry::whereIn('id', $item->industries)->get()->pluck('name');
          $industryIds = \App\Models\Info\Industry::whereIn('display_name', $oldIndustryNames)->get()->pluck('id')->toArray();
          $infoData = HrJob::find($item->id);
          $infoData->attachIndustry(['industry' => $industryIds]);
        }
      }
    }

    // 简历
    $lists = Resume::whereHas('resume_sub')->whereIn('user_id', $userIds)
      ->get()
      ->chunk(200);
    foreach ($lists as $list) {
      foreach ($list as $item) {
        if ($item->industries && count($item->industries)) {
          $oldIndustryNames = Industry::whereIn('id', $item->industries)->get()->pluck('name');
          $industryIds = \App\Models\Info\Industry::whereIn('display_name', $oldIndustryNames)->get()->pluck('id')->toArray();
          $infoData = HrResume::find($item->id);
          $infoData->attachIndustry(['industry' => $industryIds]);
        }
      }
    }

    // 个人用户
    $lists = \App\Models\Old\User::whereIn('id', $userIds)
      ->get()
      ->chunk(500);
    foreach ($lists as $list) {
      foreach ($list as $item) {
        if ($item->industries && count($item->industries)) {
          $oldIndustryNames = Industry::whereIn('id', $item->industries)->get()->pluck('name');
          $industryIds = \App\Models\Info\Industry::whereIn('display_name', $oldIndustryNames)->get()->pluck('id')->toArray();
          $infoData = UserPersonal::where('user_id', $item->id)->first();
          $infoData->attachIndustry(['industry' => $industryIds]);
        }
      }
    }

    // 企业用户
    $lists = \App\Models\Old\User::whereIn('id', $userIds)
      ->get()
      ->chunk(500);
    foreach ($lists as $list) {
      foreach ($list as $item) {
        if ($item->industries && count($item->industries)) {
          $oldIndustryNames = Industry::whereIn('id', $item->industries)->get()->pluck('name');
          $industryIds = \App\Models\Info\Industry::whereIn('display_name', $oldIndustryNames)->get()->pluck('id')->toArray();
          $infoData = UserEnterprise::where('user_id', $item->id)->first();
          $infoData->attachIndustry(['industry' => $industryIds]);
        }
      }
    }
  }
}
