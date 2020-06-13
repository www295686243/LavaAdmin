<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

/**
 * \App\Models\Version
 *
 * @property int $id
 * @property string $name
 * @property int $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereValue($value)
 * @mixin \Eloquent
 */
class Version extends Base
{
  protected $fillable = [
    'name',
    'value'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public function getList()
  {
    return Cache::tags('app')->rememberForever($this->getTable(), function () {
      return self::all()->flatMap(function ($item) {
        return [$item->name => $item->value];
      });
    });
  }
}
