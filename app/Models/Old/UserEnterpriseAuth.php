<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\UserEnterpriseAuth
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $company 公司名
 * @property string|null $business_license 营业执照
 * @property int|null $city 省市区
 * @property string|null $address 详细地址
 * @property string|null $intro 简介
 * @property array|mixed $certificates 证件照
 * @property int $auth_status 状态(0初始状态 1已提交 2已通过 3未通过)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $refuse_reason
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereAuthStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereBusinessLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereRefuseReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterpriseAuth whereUserId($value)
 * @mixin \Eloquent
 */
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
