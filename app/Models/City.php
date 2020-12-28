<?php

namespace App\Models;

use App\Models\Base\Base;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\City
 *
 * @property int|null|string $id
 * @property int $deep
 * @property string $display_name
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Query\Builder|City onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDeep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|City withTrashed()
 * @method static \Illuminate\Database\Query\Builder|City withoutTrashed()
 * @mixin \Eloquent
 */
class City extends Base
{
  use SoftDeletes;
  /**
   * @var array
   */
  protected $fillable = [
    'id',
    'deep',
    'display_name',
    'sort'
  ];

  /**
   * @var array
   */
  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  private function fillCode($code)
  {
    return intval(str_pad($code, 6, '0'));
  }

  /**
   * 传参：101010
   * 结果：[[100000, 110000], [101000, 101100], [101010]]
   * @param $code
   * @return array
   */
  public static function getGather($code)
  {
    if (!$code || intval($code) === 0) return [];
    $result = collect(str_split($code, 2))->reduce(function ($carry, $itemCode) {
      $carry['currentCode'] = $carry['currentCode'].$itemCode;
      if (strlen($carry['currentCode']) === 6) {
        $carry['codes'][] = [$carry['currentCode']];
      } else {
        $min = intval($carry['currentCode']);
        $max = $min + 1;
        $minCode = (new self())->fillCode($min);
        $maxCode = (new self())->fillCode($max);
        $carry['codes'][] = [$minCode, $maxCode];
      }
      return $carry;
    }, ['currentCode' => '', 'codes' => []]);
    return $result['codes'];
  }

  /**
   * @param $id
   * @param string $format
   * @return mixed
   */
  public static function getNames($id, $format = ' ')
  {
    $paths = self::getGather($id);
    $flatPaths = collect($paths)->map(function ($item) {
      return $item[0];
    })->toArray();
    $between = $paths[0];
    return (new self())->getCacheIndex($between[0], $between[1])
      ->filter(function ($row) use ($flatPaths) {
        return in_array($row->id, $flatPaths);
      })
      ->sortBy('deep') // 升序
      ->unique('display_name') // 根据name去重
      ->implode('display_name', $format);
  }

  /**
   * @param $minId
   * @param $maxId
   * @return mixed
   */
  public function getCacheIndex($minId, $maxId)
  {
    $query = self::query()
      ->where('id', '>=', $minId)
      ->where('id', '<', $maxId);
    return Cache::tags($this->getTable().$minId.'-'.$maxId)->rememberForever($query->toSql(), function () use ($query) {
      return $query->get();
    });
  }
}
