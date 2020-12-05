<?php

namespace App\Models\Info;

use App\Jobs\InfoPushQueue;
use App\Models\Base;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\User\User;
use App\Models\User\UserEnterprise;
use App\Models\User\UserPersonal;
use Illuminate\Support\Str;

class InfoPush extends Base
{
  protected $fillable = [
    'info_pushable_type',
    'info_pushable_id',
    'industries',
    'cities',
    'user_id',
    'push_users',
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'industries' => 'array',
    'cities' => 'array',
    'push_users' => 'array',
    'info_pushable_id' => 'string'
  ];

  /**
   * @param $value
   * @return array|mixed
   */
  public function getIndustriesAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  /**
   * @param $value
   * @return array|mixed
   */
  public function getCitiesAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  /**
   * @param $value
   * @return array|mixed
   */
  public function getPushUsersAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @param $infoData
   */
  public function createQueuePushWeChatNotify($infoData)
  {
    foreach ($this->push_users as $user_id) {
      InfoPushQueue::dispatch($user_id, $infoData);
    }
  }

  /**
   * @param $infoData
   * @param $industries
   * @param $cities
   * @return array
   */
  public function getPushUserIds($infoData, $industries, $cities)
  {
    $className = get_class($infoData);
    /**
     * @var UserPersonal|UserEnterprise $userModelName
     */
    $userModelName = '';
    /**
     * @var HrJob|HrResume $infoModelName
     */
    $infoModelName = '';
    if (Str::contains($className, 'HrJob')) {
      $userModelName = UserPersonal::class;
      $infoModelName = HrResume::class;
    } else if (Str::contains($className, 'HrResume')) {
      $userModelName = UserEnterprise::class;
      $infoModelName = HrJob::class;
    }
    $user_ids = Industrygable::whereIn('industry_id', $industries)
      ->where('industrygable_type', $userModelName)
      ->pluck('industrygable_id');
    $user_ids = $userModelName::whereIn('id', $user_ids)
      ->whereIn('city', $cities)
      ->pluck('user_id')
      ->toArray();

    $info_ids = Industrygable::whereIn('industry_id', $industries)
      ->where('industrygable_type', $infoModelName)
      ->pluck('industrygable_id');
    $info_user_ids = $infoModelName::whereIn('id', $info_ids)
      ->whereIn('city', $cities)
      ->where('status', $infoModelName::getStatusValue(1, '已发布'))
      ->pluck('user_id')
      ->toArray();

    $push_user_ids = array_values(array_unique(array_merge($user_ids, $info_user_ids)));
    // 发送人群中去掉这篇信息的作者
    $key = array_search($infoData->user_id, $push_user_ids);
    if ($key) {
      array_splice($push_user_ids, $key, 1);
    }

    $push_user_ids = User::whereIn('id', $push_user_ids)
      ->where('is_follow_official_account', 1)
      ->pluck('id')
      ->toArray();
    return $push_user_ids;
  }
}
