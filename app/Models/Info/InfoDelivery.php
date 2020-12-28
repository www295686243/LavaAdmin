<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use App\Models\User\User;

/**
 * App\Models\Info\InfoDelivery
 *
 * @property int|null|string $id
 * @property string $send_user_id
 * @property string $send_info_type
 * @property string $send_info_id
 * @property string $receive_user_id
 * @property string $receive_info_type
 * @property string $receive_info_id
 * @property string $user_order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $receive_info
 * @property-read User $receive_user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $send_info
 * @property-read User $send_user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery whereReceiveInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery whereReceiveInfoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery whereReceiveUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery whereSendInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery whereSendInfoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery whereSendUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoDelivery whereUserOrderId($value)
 * @mixin \Eloquent
 */
class InfoDelivery extends Base
{
  protected $fillable = [
    'send_user_id',
    'send_info_type',
    'send_info_id',
    'receive_user_id',
    'receive_info_type',
    'receive_info_id',
    'user_order_id'
  ];

  protected $casts = [
    'send_user_id' => 'string',
    'send_info_id' => 'string',
    'receive_user_id' => 'string',
    'receive_info_id' => 'string',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function send_user()
  {
    return $this->belongsTo(User::class, 'send_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function receive_user()
  {
    return $this->belongsTo(User::class, 'receive_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function send_info()
  {
    return $this->morphTo('send_info', 'send_info_type', 'send_info_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function receive_info()
  {
    return $this->morphTo('receive_info', 'receive_info_type', 'receive_info_id');
  }
}
