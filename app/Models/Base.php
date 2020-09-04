<?php

namespace App\Models;

use App\Models\Traits\IdToStrTrait;
use App\Models\Traits\ResourceTrait;
use App\Models\User\User;
use App\Services\SearchQueryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * App\Models\Base
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @mixin \Eloquent
 */
class Base extends Model
{
  use ResourceTrait, IdToStrTrait;

  /**
   * @param \DateTimeInterface $date
   * @return string
   */
  protected function serializeDate(\DateTimeInterface $date)
  {
    return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
  }

  /**
   * @return array
   */
  public static function getFillFields()
  {
    return (new static())->getFillable();
  }

  /**
   * @param array $except
   * @return array
   */
  public static function getFillFieldAndExcept($except = [])
  {
    $array = static::getFillFields();
    return Arr::except($array, $except);
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeListQuery($query)
  {
    return $query->when($this->checkMyself(), function ($query) {
      return $query->where('user_id', auth(request()->route()->getPrefix())->id());
    })->searchQuery($query);
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSearchQuery($query)
  {
    return (new SearchQueryService())->searchQuery($query);
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function scopePagination($query)
  {
    $limit = request()->input('limit', 10);
    return $query->paginate($limit);
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Contracts\Pagination\Paginator
   */
  public function scopeSimplePagination($query)
  {
    $limit = request()->input('limit', 10);
    return $query->simplePaginate($limit);
  }

  /**
   * @param $id
   * @return mixed
   */
  public static function findOrAuth($id)
  {
    $userData = auth(request()->route()->getPrefix())->user();
    $data = static::findOrFail($id);
    $_this = new self();
    if ($_this->checkMyself() && $userData->id !== $data->user_id) {
      $_this->error('您没有该权限');
    }
    return $data;
  }

  /**
   * @return bool
   */
  private function checkMyself () {
    /**
     * @var User $userData
     */
    $userData = auth(request()->route()->getPrefix())->user();
    if (!$userData->hasRole('root')) {
      list($controllerName, $methodName) = explode('@', class_basename(request()->route()->getActionName()));
      if (in_array($methodName, ['index', 'show', 'update', 'destroy']) && $userData->can($controllerName.'@_myself')) {
        return true;
      }
    }
    return false;
  }

  /**
   * @param $guard_name
   * @param $name
   * @return \Illuminate\Database\Eloquent\Builder
   */
  private static function getOptions($guard_name, $name)
  {
    $configData = self::getConfig($guard_name, $name);
    return $configData->options()->get();
  }

  /**
   * @param $guard_name
   * @param $name
   * @return \Illuminate\Database\Eloquent\Builder|Model
   */
  private static function getConfig($guard_name, $name)
  {
    return Config::with('options')
      ->where('name', $name)
      ->where('guard_name', $guard_name)
      ->firstOrFail();
  }

  /**
   * @param $name
   * @param $display_name
   * @return int
   */
  public static function getOptionsValue($name, $display_name)
  {
    $className = class_basename(static::class);
    $options = static::getOptions('options', $className.':'.$name);
    $item = $options->firstWhere('display_name', $display_name);
    return $item->id;
  }

  /**
   * @param $name
   * @return mixed
   */
  public static function getConfigValue($name)
  {
    $className = class_basename(static::class);
    $configData = self::getConfig('system', $className.'@'.$name);
    return $configData->value;
  }
}
