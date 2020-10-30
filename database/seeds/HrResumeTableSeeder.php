<?php

use App\Models\Info\Hr\HrResume;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class HrResumeTableSeeder extends Seeder
{
  /**
   * @throws \Throwable
   */
  public function run()
  {
    $user = User::where('username', 'wanxin2')->first();
    for ($i = 1; $i <= 2; $i++) {
      (new HrResume())->createOrUpdateData([
        'user_id' => $user->id,
        'title' => '简历标题'.$i,
        'description' => '描述'.$i,
        'is_negotiate' => 1,
        'recruiter_number' => 1,
        'education' => 66,
        'seniority' => 1,
        'treatment' => '包吃,包住',
        'city' => 440203,
        'end_time' => '2020-10-20',
        'contacts' => '万鑫'.$i,
        'phone' => '12111111111',
        'status' => HrResume::getStatusValue(1, '已发布'),
        'industry' => [17]
      ]);
    }
  }
}
