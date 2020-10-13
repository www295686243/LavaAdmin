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
    (new HrJob())->createOrUpdateData([
      'user_id' => $user->id,
      'title' => 'title',
      'description' => 'description',
      'company_name' => 'company_name',
      'is_negotiate' => 1,
      'recruiter_number' => 1,
      'education' => 66,
      'seniority' => 1,
      'treatment' => '包吃,包住',
      'city' => 440203,
      'address' => 'address',
      'end_time' => '2020-10-20',
      'contacts' => '万鑫',
      'phone' => '11111111111',
      'status' => 50,
      'industry' => [17]
    ]);
  }
}
