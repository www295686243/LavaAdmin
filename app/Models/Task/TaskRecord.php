<?php

namespace App\Models\Task;

use App\Models\Base;
use App\Models\Coupon\CouponTemplate;
use App\Models\User\User;

class TaskRecord extends Base
{
  protected $fillable = [
    'user_id',
    'task_id',
    'title',
    'task_recordable_type',
    'task_recordable_id',
    'task_mode',
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

  /**
   * @throws \Exception
   */
  public function checkRewards()
  {
    $this->task_rule_record->each(function ($taskRuleRecord) {
      if (!$taskRuleRecord->is_complete && $this->_calc($taskRuleRecord->complete_number, $taskRuleRecord->target_number, $taskRuleRecord->operator)) {
        $taskRuleRecord->is_complete = 1;
        $taskRuleRecord->task_complete_time = date('Y-m-d H:i:s');
        $taskRuleRecord->save();
        if ($this->task_mode === 3) {
          $taskRuleRecordOption = TaskRuleRecord::getOptionsItem('task_rule_name', $taskRuleRecord->task_rule_name);
          CouponTemplate::giveManyCoupons($this->user_id, $taskRuleRecord->rewards, $this->title.'-'.$taskRuleRecordOption->display_name);
        }
      }
    });
    $result = false;
    if ($this->task_mode === 1 || $this->task_mode === 3) {
      $result = $this->task_rule_record->every(function ($taskRuleRecord) {
        return $taskRuleRecord->is_complete;
      });
    } else if ($this->task_mode === 2) {
      $result = $this->task_rule_record->some(function ($taskRuleRecord) {
        return $taskRuleRecord->is_complete;
      });
    }
    if ($result) {
      if ($this->task_mode === 1 || $this->task_mode === 2) {
        CouponTemplate::giveManyCoupons($this->user_id, $this->rewards, $this->title);
      }
      $this->is_complete = $result;
      $this->task_complete_time = date('Y-m-d H:i:s');
      $this->save();
    }
  }

  /**
   * @param $target_number
   * @param $complete_number
   * @param $operator
   * @return bool
   */
  private function _calc($target_number, $complete_number, $operator) {
    switch ($operator) {
      case '>':
        return $target_number > $complete_number;
      case '>=':
        return $target_number >= $complete_number;
      case '=':
        return $target_number === $complete_number;
      case '<':
        return $target_number < $complete_number;
      case '<=':
        return $target_number <= $complete_number;
      default:
        return false;
    }
  }
}
