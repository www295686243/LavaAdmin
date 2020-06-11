<?php

namespace App\Models;

/**
 * \App\Models\Config
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConfigOption[] $options
 * @property-read int|null $options_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config query()
 * @mixin \Eloquent
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

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function options()
  {
    return $this->hasMany(ConfigOption::class);
  }
}
