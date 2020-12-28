<?php

namespace App\Models\Notify;

use App\Models\Base\Base;
use App\Models\User\User;

/**
 * App\Models\Notify\NotifyUser
 *
 * @property int|null|string $id
 * @property string $notify_template_id 通知模板id
 * @property string $user_id 发送用户
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyUser whereNotifyTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyUser whereUserId($value)
 * @mixin \Eloquent
 */
class NotifyUser extends Base
{
  protected $fillable = [
    'notify_template_id',
    'user_id'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'notify_template_id' => 'string'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
