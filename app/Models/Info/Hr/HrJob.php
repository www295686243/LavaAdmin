<?php

namespace App\Models\Info\Hr;

use App\Models\Base;
use App\Models\Info\Industry;
use App\Models\Info\InfoCheck;
use App\Models\Info\InfoComplaint;
use App\Models\Info\InfoProvide;
use App\Models\Info\InfoSub;
use App\Models\Info\InfoView;
use App\Models\Task\TaskRecord;
use App\Models\Traits\IndustryTrait;
use App\Models\User\User;
use App\Models\User\UserOrder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HrJob extends Base
{
  use SoftDeletes, IndustryTrait;

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

  protected $casts = [
    'admin_user_id' => 'string',
    'provide_user_id' => 'string',
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
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function provide_user()
  {
    return $this->belongsTo(User::class, 'provide_user_id');
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
   * @param $input
   * @param int $id
   * @return int|mixed
   * @throws \Throwable
   */
  public function createOrUpdateData($input, $id = 0)
  {
    $input['status'] = optional($input)['status'] ?? self::getStatusValue(1, '已发布');
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
      $data->attachInfoProvide();
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
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      $this->error();
    }
  }

  private function attachInfoProvide()
  {
    $info_provide_id = request()->input('info_provide_id');
    if ($info_provide_id) {
      $infoProvideData = InfoProvide::findOrFail($info_provide_id);
      $infoProvideData->info_provideable_id = $this->id;
      $infoProvideData->save();
    }
  }

  /**
   * @param UserOrder $userOrderData
   */
  public function payCallback(UserOrder $userOrderData)
  {
    $userOrderData->createUserBill('查看职位联系方式');
  }
}
