<?php

namespace App\Models\User;

use App\Models\Base;
use App\Models\Info\Industry;
use App\Models\Task\Traits\PerfectPersonalInfoTaskTraits;
use App\Models\Traits\IndustryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class UserPersonal extends Base
{
  use SoftDeletes, IndustryTrait, PerfectPersonalInfoTaskTraits;

  protected $fillable = [
    'user_id',
    'avatar',
    'name',
    'id_card',
    'seniority',
    'intro',
    'email',
    'phone',
    'company',
    'position',
    'position_attr',
    'city',
    'address',
    'tags',
    'education_experience',
    'work_experience',
    'honorary_certificate'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $casts = [
    'education_experience' => 'array',
    'work_experience' => 'array',
    'honorary_certificate' => 'array'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function industry()
  {
    return $this->morphToMany(Industry::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @param $input
   * @param int $userId
   * @throws \Exception
   */
  public static function updateInfo($input, $userId = 0)
  {
    $userId = $userId ?: User::getUserId();
    $data = static::where('user_id', $userId)->firstOrFail();
    $data->update(Arr::only($input, self::getFillFields()));
    $data->attachIndustry($input);
    if (isset($input['city'])) {
      $data->user()->update(['city' => $input['city']]);
    }
    $data->checkPerfectPersonalInfoFinishTask();
  }

  /**
   * @return bool
   */
  public function isPerfectInfo()
  {
    return $this->tags && ($this->education_experience && count($this->education_experience)) && ($this->work_experience && count($this->work_experience));
  }
}
