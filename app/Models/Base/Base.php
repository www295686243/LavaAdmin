<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/7
 * Time: 11:21
 */

namespace App\Models\Base;

use App\Models\Config;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\Traits\IdToStrTrait;
use App\Models\Traits\ResourceTrait;
use App\Services\SearchQueryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Kra8\Snowflake\HasSnowflakePrimary;

class Base extends Model {
  use ResourceTrait, IdToStrTrait, HasSnowflakePrimary;

  public static $ENABLE = 1;
  public static $DISABLE = 0;

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
      return $query->where('user_id', auth($this->getPrefix())->id());
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
   * @param $typeField
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSearchModel($query, $typeField)
  {
    $_model = request()->input('_model');
    $_models = collect(array_filter(explode(',', $_model)))->map(function ($type) {
      if (Str::contains($type, 'App\Models')) {
        return $type;
      } else {
        return 'App\Models\\'.str_replace('/', '\\', $type);
      }
    })->toArray();
    return $query->whereIn($typeField, $_models);
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
    $userData = auth((new self())->getPrefix())->user();
    $data = static::findOrFail($id);
    $_this = new self();
    if ($_this->checkMyself() && $userData->id !== $data->user_id) {
      $_this->setStatusCode(423)->error('您没有该权限');
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
    $userData = auth($this->getPrefix())->user();
    if (!$userData->hasRole('root')) {
      list($controllerName, $methodName) = explode('@', class_basename(request()->route()->getActionName()));
      if (in_array($methodName, ['index', 'show', 'update', 'destroy']) && $userData->can($controllerName.'@_myself')) {
        return true;
      }
    }
    return false;
  }

  /**
   * @param $className
   * @param $field
   * @return Config|\Illuminate\Database\Eloquent\Builder|Model
   */
  private static function getConfig($className, $field)
  {
    return Config::where('name', $className.'@'.$field)->firstOrFail();
  }

  private static function getOptions ($className, $field) {
    return Config::with('options')
      ->orWhere('name', $className.':'.$field)
      ->orWhere('name', '_global:'.$field)
      ->firstOrFail();
  }

  /**
   * @param $field
   * @param $value
   * @return mixed
   */
  private static function getOptionItem($field, $value)
  {
    $className = class_basename(static::class);
    $configData = self::getOptions($className, $field);
    $configOptionData = $configData->options->where('value', $value)->first();
    return $configOptionData;
  }

  /**
   * @param $field
   * @param $value
   * @param $display_name
   * @return int
   */
  public static function getOptionsValue($field, $value, $display_name)
  {
    $configOptionData = static::getOptionItem($field, $value);
    return $configOptionData->value;
  }

  /**
   * @param $field
   * @param $value
   * @return mixed
   */
  public static function getOptionsLabel($field, $value)
  {
    $configOptionData = static::getOptionItem($field, $value);
    return $configOptionData->display_name;
  }

  /**
   * @param $field
   * @param $value
   * @return mixed
   */
  public static function getOptionsItem($field, $value)
  {
    $configOptionData = static::getOptionItem($field, $value);
    return $configOptionData;
  }

  /**
   * @param $field
   * @param $display_name
   * @return int
   */
  public static function getOptionsValue2($field, $display_name)
  {
    $className = class_basename(static::class);
    $configData = self::getOptions($className, $field);
    $configOptionData = $configData->options->where('display_name', $display_name)->first();
    return $configOptionData->value;
  }

  /**
   * @param $name
   * @return mixed
   */
  public static function getConfigValue($name)
  {
    $className = class_basename(static::class);
    $configData = self::getConfig($className, $name);
    return $configData->value;
  }

  /**
   * @param $value
   * @param $display_name
   * @return int
   */
  public static function getStatusValue($value, $display_name)
  {
    return static::getOptionsValue('status', $value, $display_name);
  }

  /**
   * @param $value
   * @return mixed
   */
  public static function getStatusLabel($value)
  {
    return static::getOptionsLabel('status', $value);
  }

  /**
   * @return string
   */
  public function getPrefix()
  {
    return Str::beforeLast(request()->route()->getPrefix(), '/');
  }

  /**
   * @return HrJob|HrJob[]|HrResume|HrResume[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
   */
  public function getModelData () {
    $id = request()->input('id');
    $modelPath = $this->getModelPath();
    /**
     * @var HrJob|HrResume $Model
     */
    $Model = new $modelPath();
    $infoData = $Model->findOrFail($id);
    return $infoData;
  }

  /**
   * @param string $modelPath
   * @return string
   */
  public function getModelPath ($modelPath = '') {
    $innerModelPath = $modelPath ? $modelPath : request()->input('_model');
    if (Str::contains($innerModelPath, 'App\Models')) {
      return $innerModelPath;
    } else {
      return 'App\Models\\'.str_replace('/', '\\', $innerModelPath);
    }
  }

  /**
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function cacheGetAll () {
    return Cache::tags(self::class)->rememberForever($this->getTable(), function () {
      return self::orderBy('id')->get();
    });
  }
}
