<?php

namespace App\Models;

use App\Models\Base\Base;

/**
 * \App\Models\Config
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $value
 * @property string $guard_name 守卫(system)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConfigOption[] $options
 * @property-read int|null $options_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config whereValue($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base pagination()
 */
class Config extends Base
{
  protected $fillable = [
    'name',
    'display_name',
    'value',
    'guard_name'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public static function bootHasSnowflakePrimary() {}

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function options()
  {
    return $this->hasMany(ConfigOption::class);
  }
}
