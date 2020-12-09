<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

class UserEnterpriseAuth extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'certificates' => 'array'
  ];

  /**
   * @param $value
   * @return array|mixed
   */
  public function getCertificatesAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }
}
