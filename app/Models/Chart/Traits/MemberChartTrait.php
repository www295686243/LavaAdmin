<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/8
 * Time: 11:20
 */

namespace App\Models\Chart\Traits;

trait MemberChartTrait {
  /**
   * @param \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection $list
   * @return int
   */
  private function getAuthCount($list)
  {
    return $list
      ->where('name', 'WeChatController@login')
      ->where('desc', '微信注册成功')
      ->count();
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection $list
   * @return int
   */
  private function getRegisterCount($list)
  {
    return $list
      ->where('name', 'UserController@bindPhone')
      ->count();
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection $list
   * @return int
   */
  private function getLoginCount($list)
  {
    return $list
      ->where('name', 'UserController@todayFirstLogin')
      ->count();
  }
}