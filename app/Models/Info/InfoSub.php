<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Info\InfoSub
 *
 * @property int|null|string $id
 * @property string $info_subable_type
 * @property int $info_subable_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $info_subable
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoSub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoSub newQuery()
 * @method static \Illuminate\Database\Query\Builder|InfoSub onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoSub query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoSub whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoSub whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoSub whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoSub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoSub whereInfoSubableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoSub whereInfoSubableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoSub whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|InfoSub withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InfoSub withoutTrashed()
 * @mixin \Eloquent
 */
class InfoSub extends Base
{
  use SoftDeletes;
  protected $fillable = [
    'description'
  ];

  protected $hidden = [
    'id',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function info_subable()
  {
    return $this->morphTo();
  }
}
