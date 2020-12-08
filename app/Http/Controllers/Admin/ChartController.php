<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChartRequest;
use App\Models\Chart\Chart;

class ChartController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function createTodayData()
  {
    (new Chart())->createData(date('Y-m-d'));
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
    $code = $request->input('code');
    $firstDay = date('Y-m-01', strtotime($date));
    $lastDay = date('Y-m-d', strtotime("$firstDay +1 month -1 day"));
    $data = Chart::whereBetween('stat_date', [$firstDay, $lastDay])->orderBy('stat_date', 'asc')->get();

    return $this->setParams([
      'category' => $data->map(function ($item) {
        return explode('-', $item->stat_date)[2].'日';
      }),
      'values' => $this->getMonthData($data, $code)
    ])->success();
  }

  /**
   * @param ChartRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getCurrentYearData(ChartRequest $request)
  {
    // 2020
    $date = $request->input('date');
    $code = $request->input('code');
    $firstDay = $date.'-01-01';
    $lastDay = $date.'-12-31';
    $data = Chart::whereBetween('stat_date', [$firstDay, $lastDay])->orderBy('stat_date', 'asc')->get();

    $monthResult = [];
    $category = [];
    $maxMonth = 12;
    if ($date === date('Y')) {
      $maxMonth = intval(date('m'));
    }
    for($i = 1; $i <= $maxMonth; $i++) {
      $firstDay = $date.'-'.(str_pad($i, 2, '0', STR_PAD_LEFT)).'-01';
      $lastDay = $date.'-'.(str_pad($i + 1, 2, '0', STR_PAD_LEFT)).'-01';
      $currentMonthList = $data->where('stat_date', '>=', $firstDay)->where('stat_date', '<', $lastDay);
      $currentMonthValues = $this->getMonthData($currentMonthList, $code);
      $monthResult[] = collect($currentMonthValues)->sum();
      $category[] = $i.'月';
    }

    return $this->setParams([
      'category' => $category,
      'values' => $monthResult
    ])->success();
  }

  /**
   * @param \Illuminate\Support\Collection $list
   * @param $code
   * @return array
   */
  private function getMonthData($list, $code)
  {
    return $list->map(function ($item) use ($code) {
      return optional($item->stat_data)[$code] ?? 0;
    })->toArray();
  }
}
