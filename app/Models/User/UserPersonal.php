<?php

namespace App\Models\User;

use App\Models\Base;
use App\Models\Info\Industry;
use App\Models\Info\InfoCheck;
use App\Models\Traits\IndustryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class UserPersonal extends Base
{
  use SoftDeletes, IndustryTrait;

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
   * @return array
   */
  public static function getUpdateFillable()
  {
    return collect(static::getFillFields())->diff(['user_id', 'avatar', 'tags', 'education_experience', 'work_experience', 'honorary_certificate'])->values()->toArray();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function industry()
  {
    return $this->morphToMany(Industry::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function info_check()
  {
    return $this->morphMany(InfoCheck::class, 'info_checkable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * 信息审核用到
   * @param $input
   * @param int $id
   * @return int
   */
  public function createOrUpdateData($input, $id = 0)
  {
    $data = self::findOrFail($id);
    $data->update(Arr::only($input, ['avatar', 'tags', 'education_experience', 'work_experience', 'honorary_certificate']));
    return $id;
  }

  /**
   * @param $input
   * @param int $id
   * @return int
   */
  public function checkInfoSuccess($input, $id = 0)
  {
    $infoId = $this->createOrUpdateData($input, $id);
    return $infoId;
  }

  /**
   * @param $input
   * @param int $id
   */
  public function checkInfoFail($input, $id = 0)
  {
  }

  /**
   * @param $input
   * @param int $userId
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
  }
}
