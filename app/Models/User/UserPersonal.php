<?php

namespace App\Models\User;

use App\Models\Base\Base;
use App\Models\Info\Industry;
use App\Models\Task\Traits\PerfectPersonalInfoTaskTraits;
use App\Models\Traits\IndustryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * App\Models\User\UserPersonal
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string|null $avatar 头像
 * @property string|null $name 姓名
 * @property string|null $id_card 身份证号(实名后不可修改)
 * @property int|null $seniority 工作年限
 * @property string|null $intro 个人简介
 * @property string|null $company 公司名
 * @property string|null $position 职位
 * @property int|null $position_attr 职位属性
 * @property int|null $city 省市区
 * @property string|null $address 详细地址
 * @property string|null $phone 联系电话
 * @property string|null $email
 * @property string|null $tags 自我评价标签
 * @property array|null $education_experience 教育经历
 * @property array|null $work_experience 工作经历
 * @property array|null $honorary_certificate 荣誉证书
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \Kalnoy\Nestedset\Collection|Industry[] $industry
 * @property-read int|null $industry_count
 * @property-read \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserPersonal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereEducationExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereHonoraryCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal wherePositionAttr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereSeniority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPersonal whereWorkExperience($value)
 * @method static \Illuminate\Database\Query\Builder|UserPersonal withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserPersonal withoutTrashed()
 * @mixin \Eloquent
 */
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
