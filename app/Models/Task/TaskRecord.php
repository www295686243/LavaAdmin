<?php

namespace App\Models\Task;

use App\Models\Base;
use App\Models\CouponTemplate;
use App\Models\User\User;

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
    'task_id' => 'string',
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

  public function checkRewards()
  {
    if ($this->task_type === 3) {
      $this->task_rule_record->each(function ($taskRuleRecord) {
        if (!$taskRuleRecord->is_complete && $this->_calc($taskRuleRecord->target_number, $taskRuleRecord->complete_number, $taskRuleRecord->operator)) {
          $couponTemplateData = CouponTemplate::getCouponTemplateData($this->reward['coupon_template_id']);
          $couponTemplateData->giveCoupons($this->user_id, $this->reward['give_number'], $this->reward['amount'], $this->reward['expiry_day'], $this->title);
          $taskRuleRecord->is_complete = 1;
          $taskRuleRecord->task_complete_time = date('Y-m-d H:i:s');
          $taskRuleRecord->save();
        }
      });
      $result = $this->task_rule_record->every(function ($taskRuleRecord) {
        return $taskRuleRecord->is_complete;
      });
      if ($result) {
        $this->is_complete = $result;
        $this->save();
      }
    } else {
      $result = false;
      if ($this->task_type === 1) {
        $result = $this->task_rule_record->every(function ($taskRuleRecord) {
          return $this->_calc($taskRuleRecord->target_number, $taskRuleRecord->complete_number, $taskRuleRecord->operator);
        });
      } else if ($this->task_type === 2) {
        $result = $this->task_rule_record->some(function ($taskRuleRecord) {
          return $this->_calc($taskRuleRecord->target_number, $taskRuleRecord->complete_number, $taskRuleRecord->operator);
        });
      }
      if ($result) {
        $couponTemplateData = CouponTemplate::getCouponTemplateData($this->reward['coupon_template_id']);
        $couponTemplateData->giveCoupons($this->user_id, $this->reward['give_number'], $this->reward['amount'], $this->reward['expiry_day'], $this->title);
        $this->is_complete = $result;
        $this->task_complete_time = date('Y-m-d H:i:s');
        $this->save();
      }
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
