<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

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

  public static function getNames($id, $format = ' ')
  {
    $paths = self::getGather($id);
    $between = $paths[0];
    return (new self())->getCacheIndex($between[0], $between[1])
      ->filter(function ($row) use ($paths) {
        return in_array($row->id, $paths);
      })
      ->sortBy('deep') // 升序
      ->unique('name') // 根据name去重
      ->implode('name', $format);
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
