<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/8
 * Time: 11:24
 */

namespace App\Models\Chart\Traits;

trait OrderChartTrait {
  /**
   * @param \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection $list
   * @return int
   */
  private function getOrderTotalCount($list)
  {
    $num1 = $this->getInfoOrderCount($list, 'HrJobController');
    $num2 = $this->getInfoOrderCount($list, 'HrResumeController');
    return $num1 + $num2;
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection $list
   * @param $name
   * @return mixed
   */
  private function getInfoOrderCount($list, $name)
  {
    $num1 = $list
      ->where('name', $name.'@payCallback')
      ->count();
    $num2 = $list
      ->where('name', $name.'@pay')
      ->where('desc', '支付成功')
      ->count();
    return $num1 + $num2;
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection $list
   * @param $name
   * @return mixed
   */
  private function getInfoFirstOrderPayCount($list, $name)
  {
    $num1 = $list
      ->where('name', $name.'@payCallback')
      ->where('extra.isModelFirstPay', true)
      ->count();
    $num2 = $list
      ->where('name', $name.'@pay')
      ->where('desc', '支付成功')
      ->where('extra.isModelFirstPay', true)
      ->count();
    return $num1 + $num2;
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection $list
   * @return int
   */
  private function getOrderFirstPayCount($list)
  {
    return $list
      ->where('extra.isFirstPay', true)
      ->count();
  }
}