<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\Job
 *
 * @property int $id
 * @property int $user_id
 * @property array|null $industries 行业集合
 * @property int|null $industry 顶级行业
 * @property string $title 招聘标题
 * @property string|null $intro 简介
 * @property string|null $company_name 企业名称
 * @property int $monthly_pay_min 最小月薪
 * @property int $monthly_pay_max 最大月薪
 * @property int $is_negotiate 是否面议
 * @property int $recruiter_number 招聘人数
 * @property int $education 学历
 * @property int $seniority 工作年限
 * @property int|null $city 工作城市(省市区)
 * @property string|null $end_time 截止日期
 * @property string|null $contacts 联系人
 * @property string|null $phone 联系电话
 * @property int $status 0审核1发布2解决3下架4到期
 * @property int $views 查看数
 * @property int $pay_count 支付数
 * @property int $is_other_user 是否帮其它人发
 * @property int|null $admin_user_id 信息归属人，用于员工后台发布能知道谁发的
 * @property int|null $provide_user_id 信息提供人
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $refresh_at
 * @property-read \App\Models\Old\JobSub|null $job_sub
 * @method static \Illuminate\Database\Eloquent\Builder|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job query()
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereIndustries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereIsNegotiate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereIsOtherUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereMonthlyPayMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereMonthlyPayMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job wherePayCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereProvideUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereRecruiterNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereRefreshAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereSeniority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereViews($value)
 * @mixin \Eloquent
 */
class Job extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'industries' => 'array',
  ];

  public function job_sub()
  {
    return $this->hasOne(JobSub::class, 'id', 'id');
  }
}
