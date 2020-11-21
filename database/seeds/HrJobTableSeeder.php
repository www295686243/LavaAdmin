<?php

use App\Models\Info\Hr\HrJob;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class HrJobTableSeeder extends Seeder
{
  /**
   * @throws \Throwable
   */
  public function run()
  {
    $user = User::where('username', 'wanxin')->first();
    $data = [
      'user_id' => $user->id,
      'is_negotiate' => 1,
      'recruiter_number' => 1,
      'education' => 1,
      'seniority' => 1,
      'treatment' => '包吃,包住',
      'address' => 'address',
      'end_time' => '2020-10-20',
      'phone' => '11111111111',
      'status' => HrJob::getStatusValue(1, '已发布')
    ];
    for ($i = 1; $i <= 5; $i++) {
      (new HrJob())->createOrUpdateData(array_merge($data, [
        'title' => '招聘标题'.$i,
        'description' => '描述'.$i,
        'company_name' => '公司名称'.$i,
        'contacts' => '万鑫'.$i,
        'city' => 440104,
        'industry' => [17, 18]
      ]));
    }
    for ($i = 6; $i <= 10; $i++) {
      (new HrJob())->createOrUpdateData(array_merge($data, [
        'title' => '招聘标题'.$i,
        'description' => '描述'.$i,
        'company_name' => '公司名称'.$i,
        'contacts' => '万鑫'.$i,
        'city' => 440303,
        'industry' => [25]
      ]));
    }
    for ($i = 11; $i <= 15; $i++) {
      (new HrJob())->createOrUpdateData(array_merge($data, [
        'title' => '招聘标题'.$i,
        'description' => '描述'.$i,
        'company_name' => '公司名称'.$i,
        'contacts' => '万鑫'.$i,
        'city' => 330102,
        'industry' => [62]
      ]));
    }
    for ($i = 16; $i <= 20; $i++) {
      (new HrJob())->createOrUpdateData(array_merge($data, [
        'title' => '招聘标题'.$i,
        'description' => '描述'.$i,
        'company_name' => '公司名称'.$i,
        'contacts' => '万鑫'.$i,
        'city' => 320102,
        'industry' => [101, 108]
      ]));
    }
  }
}
