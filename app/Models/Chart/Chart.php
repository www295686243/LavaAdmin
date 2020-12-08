<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/8
 * Time: 10:50
 */

namespace App\Models\Chart;

use App\Models\ApiLog;
use App\Models\Base\Base;
use App\Models\Chart\Traits\MemberChartTrait;
use App\Models\Chart\Traits\OrderChartTrait;

class Chart extends Base {
  use MemberChartTrait, OrderChartTrait;
  protected $fillable = [
    'stat_date',
    'stat_data'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'stat_data' => 'array',
  ];

  /**
   * 获取当前日期所有成功的数据
   * @param $date
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function getCurrentDateSuccessList($date)
  {
    $startDate = $date.' 00:00:00';
    $endDate = $date.' 23:59:59';
    return ApiLog::where('created_at', '>=', $startDate)
      ->where('created_at', '<=', $endDate)
      ->where('code', 200)
      ->get();
  }

  /**
   * @param $date
   */
  public function createData($date)
  {
    $list = $this->getCurrentDateSuccessList($date);
    $this->updateOrCreate(
      ['stat_date' => $date],
      [
        'stat_data' => [
          'auth' => $this->getAuthCount($list),
          'register' => $this->getRegisterCount($list),
          'login' => $this->getLoginCount($list),
          'order_total' => $this->getOrderTotalCount($list),
          'order_first_pay' => $this->getOrderFirstPayCount($list),
          'hr_job_first_order_pay' => $this->getInfoFirstOrderPayCount($list, 'HrJobController'),
          'hr_job_order' => $this->getInfoOrderCount($list, 'HrJobController'),
          'hr_resume_first_order_pay' => $this->getInfoFirstOrderPayCount($list, 'HrResumeController'),
          'hr_resume_order' => $this->getInfoOrderCount($list, 'HrResumeController')
        ]
      ]
    );
  }
}
