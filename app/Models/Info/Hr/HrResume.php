<?php

namespace App\Models\Info\Hr;

use App\Models\Base\HrBase;
use App\Models\User\UserOrder;

/**
 * App\Models\Info\Hr\HrResume
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string $title 简历标题
 * @property string|null $intro 简介
 * @property int|null $monthly_salary_min 最小月薪
 * @property int|null $monthly_salary_max 最大月薪
 * @property int $is_negotiate 是否面议
 * @property int|null $education 学历
 * @property int|null $seniority 工作年限
 * @property string|null $treatment 待遇
 * @property string|null $treatment_input 待遇手输
 * @property int|null $city 期望城市(省市区)
 * @property string|null $end_time 截止日期
 * @property string|null $contacts 联系人
 * @property string|null $phone 联系电话
 * @property int $status 0审核1发布2解决3下架
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
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereIsNegotiate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereMonthlySalaryMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereMonthlySalaryMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume wherePayCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereProvideUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereRefreshAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereSeniority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereTreatment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereTreatmentInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrResume whereViews($value)
 * @mixin \Eloquent
 */
class HrResume extends HrBase
{
  protected $fillable = [
    'user_id',
    'title',
    'intro',
    'monthly_salary_min',
    'monthly_salary_max',
    'is_negotiate',
    'education',
    'seniority',
    'treatment',
    'treatment_input',
    'city',
    'end_time',
    'contacts',
    'phone',
    'status',
    'refresh_at',
    'admin_user_id',
    'provide_user_id'
  ];

  public $NotifyConfig = [
    'checkEditSuccess' => [
      'id' => 8,
      'title' => '简历信息修改审核通过通知'
    ],
    'checkCreateSuccess' => [
      'id' => 7,
      'title' => '简历信息添加审核通过通知'
    ],
    'checkEditFail' => [
      'id' => 12,
      'title' => '简历信息修改审核失败通知'
    ],
    'checkCreateFail' => [
      'id' => 11,
      'title' => '简历信息添加审核失败通知'
    ],
    'infoDisable' => [
      'id' => 18,
      'title' => '简历信息下架通知'
    ],
    'infoResolve' => [
      'id' => 20,
      'title' => '简历信息解决通知'
    ]
  ];

  /**
   * @return array
   */
  public function getComplaintNotify()
  {
    return [
      'id' => 30,
      'title' => '推送给用户简历投诉结果通知'
    ];
  }

  /**
   * @return array
   */
  public function getDeliveryNotify()
  {
    return [
      'id' => 22,
      'title' => '投递后职位信息推送'
    ];
  }

  /**
   * @param UserOrder $userOrderData
   */
  public function payCallback(UserOrder $userOrderData)
  {
    $userOrderData->createUserBill('查看简历联系方式');
  }
}
