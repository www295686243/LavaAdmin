<?php

namespace App\Models;

use App\Models\Base\Base;
use Illuminate\Support\Facades\Cache;

/**
 * \App\Models\Version
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property int $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Version whereValue($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base pagination()
 */
class Version extends Base
{
  protected $fillable = [
    'name',
    'display_name',
    'value'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public static function bootHasSnowflakePrimary() {}

  public function getList()
  {
    return Cache::tags('app')->rememberForever($this->getTable(), function () {
      return self::all()->flatMap(function ($item) {
        return [$item->name => $item->value];
      });
    });
  }

  public function updateOrCreateVersion($name, $displayName = '')
  {
    $data = self::where('name', $name)->first();
    if (!$data) {
      $data = self::create(['name' => $name, 'display_name' => $displayName]);
    }
    $data->display_name = $displayName;
    $data->value += 1;
    $data->save();
    $this->clearCache();
  }

  public function clearCache()
  {
    Cache::tags('app')->forget($this->getTable());
  }
}
