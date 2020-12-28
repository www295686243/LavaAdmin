<?php

namespace App\Models\Info;

use App\Jobs\InfoPushQueue;
use App\Models\Base\Base;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\User\User;
use App\Models\User\UserEnterprise;
use App\Models\User\UserPersonal;
use Illuminate\Support\Str;

/**
 * App\Models\Info\InfoPush
 *
 * @property int|null|string $id
 * @property string $info_pushable_type
 * @property string|null $info_pushable_id
 * @property array|mixed $industries 推送的3级行业集合
 * @property array|mixed $cities 推送的3级城市集合
 * @property string $user_id 推送人
 * @property array|mixed $push_users 推送给了哪些人
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush whereCities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush whereIndustries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush whereInfoPushableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush whereInfoPushableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush wherePushUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoPush whereUserId($value)
 * @mixin \Eloquent
 */
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
