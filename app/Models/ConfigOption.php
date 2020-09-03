<?php

namespace App\Models;

/**
 * App\Models\ConfigOption
 *
 * @property int $id
 * @property int $config_id
 * @property string $display_name
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Config $config
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereConfigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base pagination()
 */
class ConfigOption extends Base
{
  protected $fillable = [
    'config_id',
    'display_name',
    'color',
    'sort'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function config()
  {
    return $this->belongsTo('App\Models\Config');
  }
}
