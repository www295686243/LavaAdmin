<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChartRequest;
use App\Models\Chart;

class ChartController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function createTodayData()
  {
    $date = date('Y-m-d');
    $Chart = new Chart();
    $list = $Chart->getCurrentDateSuccessList($date);
    $Chart->updateOrCreate(
      ['stat_date' => $date],
      [
        'stat_data' => [
          'auth' => $Chart->getAuthCount($list),
          'register' => $Chart->getRegisterCount($list),
          'login' => $Chart->getLoginCount($list)
        ]
      ]
    );
    return $this->success();
  }

  /**
   * @param ChartRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getCurrentMonthData(ChartRequest $request)
  {
    // 2020-10
    $date = $request->input('date');
    $firstDay = date('Y-m-01', strtotime($date));
    $lastDay = date('Y-m-d', strtotime("$firstDay +1 month -1 day"));
    $data = Chart::where('stat_date', '>=', $firstDay)
      ->where('stat_date', '<=', $lastDay)
      ->get();
    return $this->setParams($data)->success();
  }

  /**
   * @param ChartRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getCurrentYearData(ChartRequest $request)
  {
    // 2020
    $date = $request->input('date');
    $firstDay = $date.'-01-01';
    $lastDay = $date.'-12-31';
    $data = Chart::where('stat_date', '>=', $firstDay)
      ->where('stat_date', '<=', $lastDay)
      ->get();
    return $this->setParams($data)->success();
  }
}
