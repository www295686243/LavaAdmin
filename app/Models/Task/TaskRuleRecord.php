<?php

namespace App\Models\Task;

use App\Models\Base\Base;

/**
 * App\Models\Task\TaskRuleRecord
 *
 * @property int|null|string $id
 * @property string $user_id 任务领取用户
 * @property string $task_record_id 任务记录主表
 * @property string $title 任务名
 * @property int $target_number 目标数量
 * @property int $complete_number 完成数量
 * @property array|null $rewards 任务奖励(同任务规则表)
 * @property int $is_complete 是否完成任务
 * @property string|null $task_complete_time 任务完成时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereCompleteNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereIsComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereRewards($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereTargetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereTaskCompleteTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereTaskRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskRuleRecord whereUserId($value)
 * @mixin \Eloquent
 */
class TaskRuleRecord extends Base
{
  protected $fillable = [
    'user_id',
    'task_record_id',
    'title',
    'target_number',
    'complete_number',
    'rewards',
    'is_complete',
    'task_complete_time'
  ];

  protected $casts = [
    'task_record_id' => 'string',
    'rewards' => 'array'
  ];
}
