<?php

namespace App\Models;

use App\Models\Base\Base;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Version
 *
 * @property int|null|string $id
 * @property string $name
 * @property string $display_name
 * @property int $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Version newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Version newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|Version query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereValue($value)
 * @mixin \Eloquent
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
