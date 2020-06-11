<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/6/11
 * Time: 20:07
 */

namespace App\Services;

class SearchQueryService
{
  private $STR_WHERE = [
    '等于' => '=',
    '包含' => 'like',
    '不包含' => 'not like'
  ];

  private $INT_WHERE = [
    '等于' => '=',
    '大于' => '>',
    '大于等于' => '>=',
    '小于' => '<',
    '小于等于' => '<=',
    '不等于' => '<>',
  ];

  private function isInt($type)
  {
    return in_array($type, ['tinyInt', 'smallInt', 'int', 'bigInt', 'decimal', 'double', 'float']);
  }

  private function isDate ($type) {
    return in_array($type, ['date', 'datetime', 'timestamp']);
  }

  /**
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function searchQuery($query)
  {
    $_search = \Request::input('_search', []);
    foreach ($_search as $item) {
      $item = json_decode($item, true);
      if ($this->isInt($item['type'])) { // 数字型
        if ($item['where'] === '包含') {
          $values = is_array($item['value']) ? $item['value'] : explode(',', $item['value']);
          $query = $query->whereIn($item['field'], $values);
        } else if ($item['where'] === '不包含') {
          $query = $query->whereNotIn($item['field'], explode(',', $item['value']));
        } else {
          $query = $query->where($item['field'], $this->INT_WHERE[$item['where']], $item['value']);
        }
      } else if ($this->isDate($item['type'])) { // 日期型
        if ($item['where'] === '日期范围') {
          $query = $query->where($item['field'], '>=', $item['value'][0])->where($item['field'], '<=', $item['value'][1]);
        } else {
          $query = $query->where($item['field'], $this->INT_WHERE[$item['where']], $item['value']);
        }
      } else if ($item['type'] === 'json') {
        $query = $query->whereJsonContains($item['field'], $item['value']);
      } else if ($item['type'] === 'classify') {
        $values = collect($item['value'])->map(function ($item) {
          return collect($item)->last();
        });
        $query = $query->whereIn($item['field'], $values);
      } else { // 字符串
        if ($item['where'] === '等于') {
          $query = $query->where($item['field'], $this->STR_WHERE[$item['where']], $item['value']);
        } else {
          $query = $query->where($item['field'], $this->STR_WHERE[$item['where']], '%'.$item['value'].'%');
        }
      }
    }
    return $query;
  }
}
