<?php

namespace App\Models\User;

use App\Models\Base\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\User\UserControl
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property int $is_disable_all_push 是否关闭所有推送
 * @property int $is_open_resume_push 是否开启简历推送
 * @property int $is_open_job_push 是否开启职位推送
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserControl onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl whereIsDisableAllPush($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl whereIsOpenJobPush($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl whereIsOpenResumePush($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserControl whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserControl withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserControl withoutTrashed()
 * @mixin \Eloquent
 */
class UserControl extends Base
{
  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'is_disable_all_push',
    'is_open_resume_push',
    'is_open_job_push'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  /**
   * @return array
   */
  public static function getUpdateFillable()
  {
    return collect(static::getFillFields())->diff(['user_id'])->values()->toArray();
  }
}
