<?php

namespace App\Models\Info\Hr;

use App\Models\Base\HrBase;
use App\Models\User\UserOrder;

/**
 * App\Models\Info\Hr\HrJob
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string $title
 * @property string|null $intro 简介
 * @property string|null $company_name 企业名称
 * @property int|null $monthly_salary_min 最小月薪
 * @property int|null $monthly_salary_max 最大月薪
 * @property int $is_negotiate 是否面议
 * @property int $recruiter_number 招聘人数
 * @property int|null $education 学历
 * @property int|null $seniority 工作年限
 * @property string|null $treatment 待遇
 * @property string|null $treatment_input 待遇手输
 * @property int|null $city 工作城市(省市区)
 * @property string|null $address 工作详细地址
 * @property string|null $end_time 截止日期
 * @property string|null $contacts 联系人
 * @property string|null $phone 联系电话
 * @property int $status 0审核1发布2解决3下架4到期
 * @property int $views 查看数
 * @property int $pay_count 支付数
 * @property string|null $refresh_at 刷新时间
 * @property string|null $admin_user_id 信息归属人，用于员工后台发布能知道谁发的
 * @property string|null $provide_user_id 信息提供人
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User\User|null $admin_user
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Info\Industry[] $industry
 * @property-read int|null $industry_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Info\InfoCheck[] $info_check
 * @property-read int|null $info_check_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Info\InfoComplaint[] $info_complaint
 * @property-read int|null $info_complaint_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Info\InfoPush[] $info_push
 * @property-read int|null $info_push_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Info\InfoSub[] $info_sub
 * @property-read int|null $info_sub_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Info\InfoView[] $info_view
 * @property-read int|null $info_view_count
 * @property-read \App\Models\User\User|null $provide_user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task\TaskRecord[] $task_record
 * @property-read int|null $task_record_count
 * @property-read \App\Models\User\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|UserOrder[] $user_order
 * @property-read int|null $user_order_count
 * @method static Builder|HrBase aiQuery($industries, $city, $order)
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereIsNegotiate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereMonthlySalaryMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereMonthlySalaryMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob wherePayCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereProvideUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereRecruiterNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereRefreshAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereSeniority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereTreatment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereTreatmentInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrJob whereViews($value)
 * @mixin \Eloquent
 */
class HrJob extends HrBase
{
  protected $fillable = [
    'user_id',
    'title',
    'intro',
    'company_name',
    'monthly_salary_min',
    'monthly_salary_max',
    'is_negotiate',
    'recruiter_number',
    'education',
    'seniority',
    'treatment',
    'treatment_input',
    'city',
    'address',
    'end_time',
    'contacts',
    'phone',
    'status',
    'refresh_at',
    'admin_user_id',
    'provide_user_id',
  ];

  public $NotifyConfig = [
    'checkEditSuccess' => [
      'id' => 6,
      'title' => '职位信息修改审核通过通知'
    ],
    'checkCreateSuccess' => [
      'id' => 5,
      'title' => '职位信息添加审核通过通知'
    ],
    'checkEditFail' => [
      'id' => 10,
      'title' => '职位信息修改审核失败通知'
    ],
    'checkCreateFail' => [
      'id' => 9,
      'title' => '职位信息添加审核失败通知'
    ],
    'infoDisable' => [
      'id' => 17,
      'title' => '职位信息下架通知'
    ],
    'infoResolve' => [
      'id' => 19,
      'title' => '职位信息解决通知'
    ]
  ];

  /**
   * @return array
   */
  public function getComplaintNotify()
  {
    return [
      'id' => 29,
      'title' => '推送给用户职位投诉结果通知'
    ];
  }

  /**
   * @return array
   */
  public function getDeliveryNotify()
  {
    return [
      'id' => 24,
      'title' => '投递后简历信息推送'
    ];
  }

  /**
   * @param UserOrder $userOrderData
   */
  public function payCallback(UserOrder $userOrderData)
  {
    $userOrderData->createUserBill('查看职位联系方式');
  }
}
