<?php

namespace App\Models\Info\Hr;

use App\Models\Base;
use App\Models\Info\Hr\Traits\InfoQueryTraits;
use App\Models\Info\Industry;
use App\Models\Info\InfoCheck;
use App\Models\Info\InfoComplaint;
use App\Models\Info\InfoPush;
use App\Models\Info\InfoSub;
use App\Models\Info\InfoView;
use App\Models\Notify\NotifyTemplate;
use App\Models\Task\TaskRecord;
use App\Models\Task\Traits\ShareTaskTraits;
use App\Models\Traits\IndustryTrait;
use App\Models\User\User;
use App\Models\User\UserOrder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HrResume extends Base
{
  use SoftDeletes, IndustryTrait, InfoQueryTraits, ShareTaskTraits;

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

  protected $casts = [
    'admin_user_id' => 'string',
  ];

  /**
   * @var array
   */
  protected $hidden = [
    'updated_at',
    'deleted_at'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function admin_user()
  {
    return $this->belongsTo(User::class, 'admin_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function info_sub()
  {
    return $this->morphMany(InfoSub::class, 'info_subable');
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
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function info_complaint()
  {
    return $this->morphMany(InfoComplaint::class, 'info_complaintable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function info_view()
  {
    return $this->morphMany(InfoView::class, 'info_viewable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function task_record()
  {
    return $this->morphMany(TaskRecord::class, 'task_recordable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function user_order()
  {
    return $this->morphMany(UserOrder::class, 'user_orderable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function info_push()
  {
    return $this->morphMany(InfoPush::class, 'info_pushable');
  }

  /**
   * @param $input
   * @param int $id
   * @return int|mixed
   * @throws \Throwable
   */
  public function createOrUpdateData($input, $id = 0)
  {
    $input['status'] = optional($input)['status'] ?: self::getStatusValue(1, '已发布');
    $input['intro'] = $input['description'] ? mb_substr($input['description'], 0, 60) : '';
    $input['refresh_at'] = date('Y-m-d H:i:s');
    if ($id) {
      $this->updateData($input, $id);
      return $id;
    } else {
      return $this->createData($input);
    }
  }

  /**
   * @param $input
   * @param int $id
   * @return int|mixed
   * @throws \Throwable
   */
  public function checkInfoSuccess($input, $id = 0)
  {
    $infoId = $this->createOrUpdateData($input, $id);
    if ($id) {
      NotifyTemplate::send(8, '简历信息修改审核通过通知', $input['user_id'], [
        'id' => $id,
        'title' => $input['title'],
        'datetime' => date('Y-m-d H:i:s'),
        'result' => '通过',
        'remark' => '感谢您使用原草互助，人人为我，我为人人！'
      ]);
    } else {
      NotifyTemplate::send(7, '简历信息添加审核通过通知', $input['user_id'], [
        'id' => $infoId,
        'title' => $input['title'],
        'datetime' => date('Y-m-d H:i:s'),
        'result' => '通过',
        'remark' => '感谢您使用原草互助，人人为我，我为人人！'
      ]);
    }
    return $infoId;
  }

  /**
   * @param $input
   * @param int $id
   */
  public function checkInfoFail($input, $id = 0)
  {
    if ($id) {
      NotifyTemplate::send(12, '简历信息修改审核失败通知', $input['user_id'], [
        'id' => $id,
        'title' => $input['title'],
        'datetime' => date('Y-m-d H:i:s'),
        'result' => '未通过',
        'remark' => $input['refuse_reason']
      ]);
    } else {
      NotifyTemplate::send(11, '简历信息添加审核失败通知', $input['user_id'], [
        'id' => $id,
        'title' => $input['title'],
        'datetime' => date('Y-m-d H:i:s'),
        'result' => '未通过',
        'remark' => $input['refuse_reason']
      ]);
    }
  }

  /**
   * @param $input
   * @return mixed
   * @throws \Throwable
   */
  private function createData($input)
  {
    DB::beginTransaction();
    try {
      $data = $this->create(Arr::only($input, $this->getFillable()));
      $data->info_sub()->create(Arr::only($input, InfoSub::getFillFields()));
      $data->attachIndustry($input);
      DB::commit();
      return $data->id;
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      $this->error();
    }
  }

  /**
   * @param $input
   * @param $id
   * @throws \Throwable
   */
  private function updateData($input, $id)
  {
    $data = self::findOrAuth($id);
    DB::beginTransaction();
    try {
      $data->update(Arr::only($input, $this->getFillable()));
      $data->info_sub()->update(Arr::only($input, InfoSub::getFillFields()));
      $data->attachIndustry($input);
      if ($input['status'] === self::getStatusValue(3, '已下架')) {
        NotifyTemplate::send(18, '简历信息下架通知', $data->user_id, [
          'id' => $id,
          'nickname' => $data->user->nickname,
          'title' => $data->title,
          'created_at' => $data->created_at->format('Y-m-d H:i:s'),
          'end_time' => $data->end_time.' 23:59:59'
        ]);
      } else if ($input['status'] === self::getStatusValue(2, '已解决')) {
        NotifyTemplate::send(20, '简历信息解决通知', $data->user_id, [
          'id' => $id,
          'nickname' => $data->user->nickname,
          'title' => $data->title,
          'created_at' => $data->created_at->format('Y-m-d H:i:s'),
          'end_time' => $data->end_time.' 23:59:59'
        ]);
      }
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getTraceAsString());
      $this->error();
    }
  }

  /**
   * @param UserOrder $userOrderData
   */
  public function payCallback(UserOrder $userOrderData)
  {
    $userOrderData->createUserBill('查看简历联系方式');
  }

  /**
   * @param $industries
   * @param $cities
   */
  public function infoPush($industries, $cities)
  {
    $push_user_ids = (new InfoPush())->getPushUserIds($this, $industries, $cities);
    /**
     * @var InfoPush $infoPushData
     */
    $infoPushData = $this->info_push()->create([
      'industries' => $industries,
      'cities' => $cities,
      'user_id' => User::getUserId(),
      'push_users' => $push_user_ids
    ]);

    $infoPushData->createQueuePushWeChatNotify($this);
  }
}
