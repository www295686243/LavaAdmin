<?php

namespace App\Models\Info\Hr;

use App\Models\Base\HrBase;
use App\Models\User\UserOrder;

class HrResume extends HrBase
{
  protected $fillable = [
    'user_id',
    'title',
    'intro',
    'monthly_salary_min',
    'monthly_salary_max',
    'is_negotiate',
    'education',
    'seniority',
    'treatment',
    'treatment_input',
    'city',
    'end_time',
    'contacts',
    'phone',
    'status',
    'refresh_at',
    'admin_user_id',
    'provide_user_id'
  ];

  public $NotifyConfig = [
    'checkEditSuccess' => [
      'id' => 8,
      'title' => '简历信息修改审核通过通知'
    ],
    'checkCreateSuccess' => [
      'id' => 7,
      'title' => '简历信息添加审核通过通知'
    ],
    'checkEditFail' => [
      'id' => 12,
      'title' => '简历信息修改审核失败通知'
    ],
    'checkCreateFail' => [
      'id' => 11,
      'title' => '简历信息添加审核失败通知'
    ],
    'infoDisable' => [
      'id' => 18,
      'title' => '简历信息下架通知'
    ],
    'infoResolve' => [
      'id' => 20,
      'title' => '简历信息解决通知'
    ]
  ];

  /**
   * @param UserOrder $userOrderData
   */
  public function payCallback(UserOrder $userOrderData)
  {
    $userOrderData->createUserBill('查看简历联系方式');
  }
}
