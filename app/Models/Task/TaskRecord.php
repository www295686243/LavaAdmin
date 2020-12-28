<?php

namespace App\Models\Task;

use App\Models\Base\Base;
use App\Models\User\User;

/**
 * App\Models\Task\TaskRecord
 *
 * @property int|null|string $id
 * @property string $user_id 任务领取用户
 * @property int $task_id 任务id
 * @property string $title 任务名
 * @property string|null $task_recordable_type
 * @property string|null $task_recordable_id
 * @property int $task_type 任务类型(看配置表)
 * @property array|null $rewards 任务奖励(同任务规则表)
 * @property int $is_complete 是否完成任务
 * @property string|null $task_end_time 任务结束时间
 * @property string|null $task_complete_time 任务完成时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $task_recordable
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task\TaskRuleRecord[] $task_rule_record
 * @property-read int|null $task_rule_record_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereIsComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereRewards($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereTaskCompleteTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereTaskEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereTaskRecordableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereTaskRecordableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereTaskType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRecord whereUserId($value)
 * @mixin \Eloquent
 */
class TaskRecord extends Base
{
  protected $fillable = [
    'user_id',
    'task_id',
    'title',
    'task_recordable_type',
    'task_recordable_id',
    'task_type',
    'rewards',
    'is_complete',
    'task_end_time',
    'task_complete_time'
  ];

  protected $casts = [
    'rewards' => 'array',
    'task_recordable_id' => 'string'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function task_recordable()
  {
    return $this->morphTo();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function task_rule_record()
  {
    return $this->hasMany(TaskRuleRecord::class);
  }
}
