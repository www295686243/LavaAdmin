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
    'task_rule_id',
    'rules',
    'rewards',
    'is_complete'
  ];

  protected $casts = [
    'rules' => 'array',
    'rewards' => 'array',
    'task_id' => 'string',
    'task_rule_id' => 'string'
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
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function task_rule()
  {
    return $this->belongsTo(TaskRule::class);
  }

  public function taskRewards()
  {
    collect($this->rewards)->each(function ($reward) {
      if ($reward['reward_name'] === 'coupon') {
        $couponTemplateData = CouponTemplate::getCouponTemplateData($reward['coupon_template_id']);
        $couponTemplateData->giveCoupons($this->user_id, $reward['give_number'], $reward['amount'], $reward['expiry_day'], $this->task_rule->title);
      }
    });
  }
}
