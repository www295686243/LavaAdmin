<?php

namespace App\Models;

class CouponTemplate extends Base
{
  protected $fillable = [
    'display_name',
    'desc',
    'is_trade'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**
   * @param $idOrName
   * @return CouponTemplate|CouponTemplate[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
   */
  public static function getCouponTemplateData($idOrName)
  {
    if (is_numeric($idOrName)) {
      $data = self::findOrFail($idOrName);
    } else {
      $data = self::where('name', $idOrName)->firstOrFail();
    }
    return $data;
  }
}
