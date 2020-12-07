<?php

namespace App\Models\Info\Hr;

use App\Models\Base\HrBase;
use App\Models\User\UserOrder;

class HrJob extends HrBase
{
  protected $fillable = [
    'user_id',
    'title',
    'intro',
    'company_name',
    'monthly_salary_min',
    'monthly_salary_max',
    'is_negotiate',
    'recruiter_number',
    'education',
    'seniority',
    'treatment',
    'treatment_input',
    'city',
    'address',
    'end_time',
    'contacts',
    'phone',
    'status',
    'refresh_at',
    'admin_user_id',
    'provide_user_id',
  ];

  protected $casts = [
    'admin_user_id' => 'string',
    'provide_user_id' => 'string',
  ];

  public $NotifyConfig = [
    'checkEditSuccess' => [
      'id' => 6,
      'title' => '职位信息修改审核通过通知'
    ],
    'checkCreateSuccess' => [
      'id' => 5,
      'title' => '职位信息添加审核通过通知'
    ],
    'checkEditFail' => [
      'id' => 10,
      'title' => '职位信息修改审核失败通知'
    ],
    'checkCreateFail' => [
      'id' => 9,
      'title' => '职位信息添加审核失败通知'
    ],
    'infoDisable' => [
      'id' => 17,
      'title' => '职位信息下架通知'
    ],
    'infoResolve' => [
      'id' => 19,
      'title' => '职位信息解决通知'
    ]
  ];

  /**
   * @param UserOrder $userOrderData
   */
  public function payCallback(UserOrder $userOrderData)
  {
    $userOrderData->createUserBill('查看职位联系方式');
  }
}
