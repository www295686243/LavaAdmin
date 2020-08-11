<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/8/11
 * Time: 18:01
 */

namespace App\Models\Traits;

trait IdToStrTrait
{
  /**
   * @param $value
   * @return string
   */
  public function getIdAttribute($value)
  {
    return strval($value);
  }

  /**
   * @param $value
   * @return string
   */
  public function getUserIdAttribute($value)
  {
    return strval($value);
  }
}
