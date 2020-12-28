<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\User
 *
 * @property int $id
 * @property int|null $invite_user_id 邀请人
 * @property string|null $username 用户名
 * @property string|null $phone 手机号
 * @property string|null $nickname 昵称
 * @property string|null $head_url 头像
 * @property string $money 金额
 * @property string $total_earning 总金额
 * @property int $coupon 优惠券数量
 * @property string|null $email
 * @property string|null $password
 * @property string|null $name 姓名/运营人姓名(实名后不可修改)
 * @property string|null $id_card 身份证号/运营人身份证(实名后不可修改)
 * @property string|null $position 职位/运营人职位
 * @property string|null $company 公司名(认证后不可修改)
 * @property string|null $business_license 营业执照(企业认证后不可修改)
 * @property int|null $seniority 工作年限
 * @property int|null $city 省市区
 * @property string|null $address 详细地址
 * @property array|null $industries 行业集合
 * @property int|null $industry 顶级行业
 * @property int|null $industry_attr 行业属性
 * @property string|null $email_verified_at
 * @property int $is_real_name_auth 是否实名认证
 * @property int $is_follow_official_account 是否关注公众号
 * @property string|null $follow_official_account_scene 关注来源
 * @property int $is_admin 是否管理员
 * @property string|null $last_login_at 最后登录时间
 * @property string|null $register_at 注册时间/绑定手机号时间
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Old\Auth|null $user_auth
 * @property-read \App\Models\Old\UserInfo|null $user_info
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBusinessLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCoupon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFollowOfficialAccountScene($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHeadUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIndustries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIndustryAttr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereInviteUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsFollowOfficialAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsRealNameAuth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRegisterAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSeniority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTotalEarning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'industries' => 'array',
  ];

  public function user_info()
  {
    return $this->hasOne(UserInfo::class, 'id', 'id');
  }

  public function user_auth()
  {
    return $this->hasOne(Auth::class);
  }
}
