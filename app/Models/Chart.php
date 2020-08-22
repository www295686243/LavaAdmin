<?php

namespace App\Models;

class Chart extends Base
{
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
   * @param \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection $list
   * @return int
   */
  public function getAuthCount($list)
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
  public function getRegisterCount($list)
  {
    return $list
      ->where('name', 'UserController@bindPhone')
      ->count();
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection $list
   * @return int
   */
  public function getLoginCount($list)
  {
    return $list
      ->where('name', 'UserController@todayFirstLogin')
      ->count();
  }

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
      ->where('created_at', '>=', $endDate)
      ->where('code', 200)
      ->get();
  }
}
