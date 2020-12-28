<?php

namespace App\Models\User;

use App\Models\Base\Base;
use App\Models\Info\Industry;
use App\Models\Task\Traits\PerfectEnterpriseInfoTaskTraits;
use App\Models\Traits\IndustryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * App\Models\User\UserEnterprise
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string|null $avatar 企业LOGO
 * @property string|null $company 公司名(企业认证后不可修改)
 * @property string|null $business_license 营业执照(企业认证后不可修改)
 * @property int|null $city 省市区
 * @property string|null $address 详细地址
 * @property string|null $intro 公司简介
 * @property int|null $industry_attr 行业属性
 * @property string|null $tags 公司标签
 * @property array|null $company_images 公司图片
 * @property int|null $company_scale 企业规模
 * @property string|null $name 运营人姓名
 * @property string|null $id_card 运营人身份证
 * @property string|null $position 运营人职位
 * @property string|null $phone 运营人电话
 * @property string|null $email 运营人邮箱
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \Kalnoy\Nestedset\Collection|Industry[] $industry
 * @property-read int|null $industry_count
 * @property-read \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserEnterprise onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereBusinessLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereCompanyImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereCompanyScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereIndustryAttr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEnterprise whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserEnterprise withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserEnterprise withoutTrashed()
 * @mixin \Eloquent
 */
class UserEnterprise extends Base
{
  use SoftDeletes, IndustryTrait, PerfectEnterpriseInfoTaskTraits;

  protected $fillable = [
    'user_id',
    'avatar',
    'company',
    'business_license',
    'city',
    'address',
    'intro',
    'industry_attr',
    'email',
    'tags',
    'company_images',
    'company_scale',
    'name',
    'id_card',
    'position',
    'phone'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $casts = [
    'company_images' => 'array'
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
    $data->checkPerfectEnterpriseInfoFinishTask();
  }

  /**
   * @return bool
   */
  public function isPerfectInfo()
  {
    return $this->tags && $this->intro && $this->company_scale;
  }
}
