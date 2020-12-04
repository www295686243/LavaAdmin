<?php

namespace App\Models\Task;

use App\Models\Api\User;
use App\Models\Base;
use App\Models\Info\InfoCheck;
use App\Models\Task\Traits\BindPhoneTaskTraits;
use App\Models\Task\Traits\EnterpriseEveryDayLoginTaskTraits;
use App\Models\Task\Traits\FollowWeChatTaskTraits;
use App\Models\Task\Traits\InviteUserTaskTraits;
use App\Models\Task\Traits\PerfectEnterpriseInfoTaskTraits;
use App\Models\Task\Traits\PerfectPersonalInfoTaskTraits;
use App\Models\Task\Traits\PersonalEveryDayLoginTaskTraits;
use App\Models\Task\Traits\InfoProvideTaskTraits;
use App\Models\Task\Traits\ShareTaskTraits;
use App\Models\Task\Traits\StatTraits;
use App\Models\User\UserPersonal;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Task extends Base
{
  protected $fillable = [
    'title',
    'desc',
    'task_type',
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
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function task_rule()
  {
    return $this->hasMany(TaskRule::class);
  }

  public static function bootHasSnowflakePrimary() {}
}
