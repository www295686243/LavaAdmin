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
   * @param $field
   * @param $where
   * @param $value
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function intQuery ($field, $where, $value, $query) {
    $value = is_array($value) ?: trim($value);
    if ($where === '包含' || $where === '不包含') {
      $values = is_array($value) ? $value : explode(',', $value);
      if (count($values) === 0) {
        return $query;
      }
      if ($where === '包含') {
        $query->whereIn($field, $values);
      } else if ($where === '不包含') {
        $query->whereNotIn($field, $values);
      }
    } else {
      $value = intval($value);
      if ($value === -1) {
        return $query;
      }
      $query->where($field, $this->INT_WHERE[$where], $value);
    }
    return $query;
  }

  /**
   * @param $field
   * @param $where
   * @param $value
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function dateQuery ($field, $where, $value, $query) {
    if ($where === '日期范围') {
      $query->where($field, '>=', $value[0])->where($field, '<=', $value[1]);
    } else {
      $query->where($field, $this->INT_WHERE[$where], $value);
    }
    return $query;
  }

  /**
   * @param $field
   * @param $value
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function jsonQuery($field, $value, $query)
  {
    $query->whereJsonContains($field, $value);
    return $query;
  }

  /**
   * @param $field
   * @param $value
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function classifyQuery($field, $value, $query)
  {
    $values = collect($value)->map(function ($item) {
      return collect($item)->last();
    });
    $query->whereIn($field, $values);
    return $query;
  }

  /**
   * @param $field
   * @param $where
   * @param $value
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function stringQuery($field, $where, $value, $query)
  {
    if (is_string($value)) {
      $value = trim($value);
      if ($where === '等于') {
        $query->where($field, $this->STR_WHERE[$where], $value);
      } else {
        $query->where($field, $this->STR_WHERE[$where], '%'.$value.'%');
      }
    } else if (is_array($value)) {
      if ($where === '包含') {
        $query->whereIn($field, $value);
      } else if ($where === '不包含') {
        $query->whereNotIn($field, $value);
      }
    }
    return $query;
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
        $query = $this->intQuery($item['field'], $item['where'], $item['value'], $query);
      } else if ($this->isDate($item['type'])) { // 日期型
        $query = $this->dateQuery($item['field'], $item['where'], $item['value'], $query);
      } else if ($item['type'] === 'json') {
        $query = $this->jsonQuery($item['field'], $item['value'], $query);
      } else if ($item['type'] === 'classify') {
        $query = $this->classifyQuery($item['field'], $item['value'], $query);
      } else { // 字符串
        $query = $this->stringQuery($item['field'], $item['where'], $item['value'], $query);
      }
    }
    return $query;
  }
}
