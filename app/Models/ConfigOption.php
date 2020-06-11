<?php

namespace App\Models;

/**
 * \App\Models\ConfigOption
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfigOption query()
 * @mixin \Eloquent
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
