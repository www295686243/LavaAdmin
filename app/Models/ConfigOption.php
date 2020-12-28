<?php

namespace App\Models;

use App\Models\Base\Base;

/**
 * App\Models\ConfigOption
 *
 * @property int|null|string $id
 * @property string|null $name 标识
 * @property string $config_id
 * @property string $display_name
 * @property int $value 值
 * @property string|null $color
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Config $config
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption whereConfigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigOption whereValue($value)
 * @mixin \Eloquent
 */
class ConfigOption extends Base
{
  protected $fillable = [
    'config_id',
    'display_name',
    'color',
    'sort',
    'value',
    'name'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'config_id' => 'string'
  ];

  public static function bootHasSnowflakePrimary() {}

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function config()
  {
    return $this->belongsTo('App\Models\Config');
  }
}
