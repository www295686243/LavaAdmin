<?php

namespace App\Models;

use App\Models\Traits\ResourceTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Base extends Model
{
  use ResourceTrait;

  /**
   * @param \DateTimeInterface $date
   * @return string
   */
  protected function serializeDate(\DateTimeInterface $date)
  {
    return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
  }

  /**
   * @return array
   */
  public static function getFillFields()
  {
    return (new static())->getFillable();
  }

  /**
   * @param array $except
   * @return array
   */
  public static function getFillFieldAndExcept($except = [])
  {
    $array = static::getFillFields();
    return Arr::except($array, $except);
  }
}
