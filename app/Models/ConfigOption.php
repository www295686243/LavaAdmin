<?php

namespace App\Models;

/**
 * \App\Models\ConfigOption
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $config_id
 * @property string $display_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereConfigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption whereUpdatedAt($value)
 */
class ConfigOption extends Base
{
  protected $fillable = [
    'config_id',
    'display_name'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];
}
