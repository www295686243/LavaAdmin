<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\UserPersonalAuth
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name 姓名
 * @property string|null $company 公司名
 * @property string|null $position 职位
 * @property int|null $city 省市区
 * @property string|null $address 详细地址
 * @property string|null $intro 简介
 * @property array|mixed $certificates 证件
 * @property int $auth_status 状态(0初始状态 1已提交 2已通过 3未通过)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $refuse_reason
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereAuthStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereRefuseReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereUserId($value)
 * @mixin \Eloquent
 */
class UserPersonalAuth extends Model
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
