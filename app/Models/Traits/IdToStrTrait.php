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
   * @param int $value
   * @return int|null|string
   */
  public function getIdAttribute($value)
  {
    if ($value) {
      $strValue = strval($value);
      if (strlen($strValue) >= 16) {
        return $strValue;
      } else {
        return $value;
      }
    } else {
      return null;
    }
  }

  /**
   * @param $value
   * @return string
   */
  public function getUserIdAttribute($value)
  {
    return $value ? strval($value) : null;
  }

  /**
   * @param $value
   * @return string
   */
  public function getUserOrderIdAttribute($value)
  {
    return $value ? strval($value) : null;
  }

  /**
   * @param $value
   * @return string
   */
  public function getUserCouponIdAttribute($value)
  {
    return $value ? strval($value) : null;
  }

  /**
   * @param $value
   * @return null|string
   */
  public function getParentIdAttribute($value)
  {
    return $value ? strval($value) : null;
  }
}
