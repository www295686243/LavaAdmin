<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\Resume
 *
 * @property int $id
 * @property int $user_id
 * @property array|null $industries 行业集合
 * @property int|null $industry 顶级行业
 * @property string $title 简历标题
 * @property string|null $intro 简介
 * @property int|null $monthly_pay_min 最小月薪
 * @property int|null $monthly_pay_max 最大月薪
 * @property int $is_negotiate 是否面议
 * @property int|null $education 学历
 * @property int|null $seniority 工作年限
 * @property int|null $city 期望城市(省市区)
 * @property string|null $end_time 截止日期
 * @property string|null $contacts 联系人
 * @property string|null $phone 联系电话
 * @property int $is_force_show_user_info 是否强制显示个人详情(支付前也可显示)
 * @property int $status 0审核1发布2解决3下架
 * @property int $views 查看数
 * @property int $pay_count 支付数
 * @property int $is_other_user 是否帮其它人发
 * @property int|null $admin_user_id 信息归属人，用于员工后台发布能知道谁发的
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $refresh_at
 * @property-read \App\Models\Old\ResumeSub|null $resume_sub
 * @method static \Illuminate\Database\Eloquent\Builder|Resume newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resume newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resume query()
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereIndustries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereIsForceShowUserInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereIsNegotiate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereIsOtherUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereMonthlyPayMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereMonthlyPayMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume wherePayCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereRefreshAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereSeniority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resume whereViews($value)
 * @mixin \Eloquent
 */
class Resume extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'industries' => 'array',
  ];

  public function resume_sub()
  {
    return $this->hasOne(ResumeSub::class, 'id', 'id');
  }
}
