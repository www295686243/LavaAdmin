<?php

namespace App\Models\User;

use App\Models\Base\Base;
use App\Models\Image;

/**
 * App\Models\User\UserPersonalAuth
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string|null $name 姓名
 * @property string|null $company 公司名
 * @property string|null $position 职位
 * @property int|null $city 省市区
 * @property string|null $address 详细地址
 * @property string|null $intro 简介
 * @property array|null $certificates 证件
 * @property int $status 状态(0初始状态 1已提交 2已通过 3未通过)
 * @property string|null $refuse_reason 拒绝原因
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \Illuminate\Database\Eloquent\Collection|Image[] $images
 * @property-read int|null $images_count
 * @property-read \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereRefuseReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonalAuth whereUserId($value)
 * @mixin \Eloquent
 */
class UserPersonalAuth extends Base
{
  protected $fillable = [
    'user_id',
    'name',
    'company',
    'position',
    'city',
    'address',
    'intro',
    'certificates',
    'status',
    'refuse_reason'
  ];

  /**
   * @var array
   */
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'certificates' => 'array'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function images()
  {
    return $this->morphMany(Image::class, 'imageable');
  }
}
