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
  /**
   * @param $field
   * @param $value
   * @param $type
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function inQuery ($field, $value, $type, $query) {
    if (is_string($value)) {
      $value = trim($value);
      $value = explode(',', $value);
    }
    $whereName = $this->getWhereType('whereIn', $type);
    return $query->$whereName($field, $value);
  }

  /**
   * @param $field
   * @param $value
   * @param $type
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function notInQuery ($field, $value, $type, $query) {
    if (is_string($value)) {
      $value = trim($value);
      $value = explode(',', $value);
    }
    $whereName = $this->getWhereType('whereNotIn', $type);
    return $query->$whereName($field, $value);
  }

  /**
   * @param $field
   * @param $value
   * @param $type
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function likeQuery($field, $value, $type, $query)
  {
    $value = trim($value);
    $whereName = $this->getWhereType('where', $type);
    return $query->$whereName($field, 'like', '%'.$value.'%');
  }

  /**
   * @param $field
   * @param $value
   * @param $type
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function notLikeQuery($field, $value, $type, $query)
  {
    $value = trim($value);
    $whereName = $this->getWhereType('where', $type);
    return $query->$whereName($field, 'not like', '%'.$value.'%');
  }

  /**
   * @param $field
   * @param $value
   * @param $type
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function betweenQuery($field, $value, $type, $query)
  {
    $whereName = $this->getWhereType('whereBetween', $type);
    return $query->$whereName($field, $value);
  }

  /**
   * @param $field
   * @param $operator
   * @param $value
   * @param $type
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function defaultQuery($field, $operator, $value, $type, $query)
  {
    $value = trim($value);
    $whereName = $this->getWhereType('where', $type);
    return $query->$whereName($field, $operator, $value);
  }

  /**
   * @param $whereName
   * @param $whereType
   * @return string
   */
  private function getWhereType ($whereName, $whereType) {
    if ($whereType === 'or') {
      return 'or'.ucfirst($whereName);
    } else {
      return $whereName;
    }
  }

  /**
   * @param $item
   * @param $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private function _search($item, $query)
  {
    if (in_array($item['operator'], ['in', 'notIn', 'like', 'notLike', 'between'])) {
      $methodName = $item['operator'].'Query';
      $query = $this->$methodName($item['field'], $item['value'], $item['type'], $query);
    } else {
      $query = $this->defaultQuery($item['field'], $item['operator'], $item['value'], $item['type'], $query);
    }
    return $query;
  }

  /**
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function searchQuery($query)
  {
    $searchList = \Request::input('_search', []);
    foreach ($searchList as $search) {
      $search = json_decode($search, true);
      if (isset($search['operator'])) {
        $query = $this->_search($search, $query);
      } else {
        $query = $query->where(function ($query) use ($search) {
          foreach ($search as $item) {
            $query = $this->_search($item, $query);
          }
        });
      }
    }
    return $query;
  }
}
