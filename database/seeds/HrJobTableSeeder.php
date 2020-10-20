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
    for ($i = 1; $i <= 2; $i++) {
      (new HrJob())->createOrUpdateData([
        'user_id' => $user->id,
        'title' => '标题'.$i,
        'description' => '描述'.$i,
        'company_name' => '公司名称'.$i,
        'is_negotiate' => 1,
        'recruiter_number' => 1,
        'education' => 66,
        'seniority' => 1,
        'treatment' => '包吃,包住',
        'city' => 440203,
        'address' => 'address',
        'end_time' => '2020-10-20',
        'contacts' => '万鑫'.$i,
        'phone' => '11111111111',
        'status' => 50,
        'industry' => [17]
      ]);
    }
  }
}
