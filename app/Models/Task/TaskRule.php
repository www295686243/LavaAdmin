<?php

namespace App\Models\Task;

use App\Models\Base\Base;

/**
 * App\Models\Task\TaskRule
 *
 * @property int|null|string $id
 * @property int $task_id 任务id
 * @property string|null $title 子任务标题
 * @property int $target_number 目标数量
 * @property array|mixed $rewards 任务奖励
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRule whereRewards($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRule whereTargetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRule whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRule whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskRule extends Base
{
  protected $fillable = [
    'task_id',
    'title',
    'target_number',
    'rewards'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'rewards' => 'array'
  ];

  /**
   * @param $value
   * @return array|mixed
   */
  public function getRewardsAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  public static function bootHasSnowflakePrimary() {}
}
