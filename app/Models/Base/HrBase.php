<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/7
 * Time: 11:21
 */

namespace App\Models\Base;

use App\Models\Info\Hr\Traits\InfoQueryTraits;
use App\Models\Info\Industry;
use App\Models\Info\InfoCheck;
use App\Models\Info\InfoComplaint;
use App\Models\Info\InfoProvide;
use App\Models\Info\InfoPush;
use App\Models\Info\InfoSub;
use App\Models\Info\InfoView;
use App\Models\Notify\NotifyTemplate;
use App\Models\Task\TaskRecord;
use App\Models\Task\Traits\ShareTaskTraits;
use App\Models\Traits\IndustryTrait;
use App\Models\Traits\PayContactsTrait;
use App\Models\User\User;
use App\Models\User\UserOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class HrBase extends Base {
  use SoftDeletes, IndustryTrait, InfoQueryTraits, ShareTaskTraits, PayContactsTrait;

  /**
   * @var array
   */
  protected $hidden = [
    'updated_at',
    'deleted_at'
  ];

  protected $casts = [
    'admin_user_id' => 'string',
    'provide_user_id' => 'string',
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
    $input['status'] = optional($input)['status'] ?? static::getStatusValue(1, '已发布');
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
      $tempId = $this->NotifyConfig['checkEditSuccess']['id'];
      $tempTitle = $this->NotifyConfig['checkEditSuccess']['title'];
    } else {
      $tempId = $this->NotifyConfig['checkCreateSuccess']['id'];
      $tempTitle = $this->NotifyConfig['checkCreateSuccess']['title'];
    }
    NotifyTemplate::send($tempId, $tempTitle, $input['user_id'], [
      'id' => $id ?: $infoId,
      'title' => $input['title'],
      'datetime' => date('Y-m-d H:i:s'),
      'result' => '通过',
      'remark' => '感谢您使用原草互助，人人为我，我为人人！'
    ]);
    return $id ?: $infoId;
  }

  /**
   * @param $input
   * @param int $id
   */
  public function checkInfoFail($input, $id = 0)
  {
    if ($id) {
      $tempId = $this->NotifyConfig['checkEditFail']['id'];
      $tempTitle = $this->NotifyConfig['checkEditFail']['title'];
    } else {
      $tempId = $this->NotifyConfig['checkEditFail']['id'];
      $tempTitle = $this->NotifyConfig['checkEditFail']['title'];
    }
    NotifyTemplate::send($tempId, $tempTitle, $input['user_id'], [
      'id' => $id,
      'title' => $input['title'],
      'datetime' => date('Y-m-d H:i:s'),
      'result' => '未通过',
      'remark' => $input['refuse_reason']
    ]);
  }

  /**
   * @param $input
   * @return mixed
   * @throws \Throwable
   */
  private function createData($input)
  {
    $data = $this->create(Arr::only($input, $this->getFillable()));
    $data->info_sub()->create(Arr::only($input, InfoSub::getFillFields()));
    $data->attachIndustry($input);
    $data->attachInfoProvide();
    return $data->id;
  }

  public function attachInfoProvide()
  {
    $info_provide_id = request()->input('info_provide_id');
    if ($info_provide_id) {
      $infoProvideData = InfoProvide::findOrFail($info_provide_id);
      $infoProvideData->info_provideable_id = $this->id;
      $infoProvideData->save();
    }
  }

  /**
   * @param $input
   * @param $id
   * @throws \Throwable
   */
  private function updateData($input, $id)
  {
    $data = static::findOrAuth($id);
    $data->update(Arr::only($input, $this->getFillable()));
    $data->info_sub()->update(Arr::only($input, InfoSub::getFillFields()));
    $data->attachIndustry($input);
    $tempId = 0;
    $tempTitle = '';
    if ($input['status'] === static::getStatusValue(3, '已下架')) {
      $tempId = $this->NotifyConfig['infoDisable']['id'];
      $tempTitle = $this->NotifyConfig['infoDisable']['title'];
    } else if ($input['status'] === static::getStatusValue(2, '已解决')) {
      $tempId = $this->NotifyConfig['infoResolve']['id'];
      $tempTitle = $this->NotifyConfig['infoResolve']['title'];
    }
    if ($tempId) {
      NotifyTemplate::send($tempId, $tempTitle, $data->user_id, [
        'id' => $id,
        'nickname' => $data->user->nickname,
        'title' => $data->title,
        'created_at' => $data->created_at->format('Y-m-d H:i:s'),
        'end_time' => $data->end_time.' 23:59:59'
      ]);
    }
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

  /**
   * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\MorphMany|null|object
   */
  public function modelGetComplaint()
  {
    return $this->info_complaint()->where('user_id', User::getUserId())->first();
  }

  /**
   * @param $input
   * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\MorphMany|null|object
   */
  public function modelComplaint($input)
  {
    $userData = User::getUserData();
    $input['user_id'] = $userData->id;
    $infoComplaintData = $this->modelGetComplaint();
    if ($infoComplaintData) {
      (new static())->error('您已投诉过该信息');
    }

    $userOrderData = $this->modelGetPayOrder();
    if (!$userOrderData) {
      return $this->error('您未查看该信息的联系方式');
    }

    $infoComplaintData = $this->info_complaint()->create($input);

    if ($this->modelStatusIsEqualTo(1, '已发布')) {
      // 如果信息到期被投诉了就立即下架并退券
      if ($this->end_time < date('Y-m-d')) {
        $this->status = $this->modelGetStatusValue(3, '已下架');
        $this->save();
        $userOrderData->modelRefund();
      }
      // 如果有3个投诉已找到那么设置该信息为已解决
      $foundCount = $this->info_complaint()
        ->where('complaint_type', InfoComplaint::getOptionsValue('complaint_type', 1, '已招到'))
        ->count();
      if ($foundCount >= 3) {
        $this->status = $this->modelGetStatusValue(2, '已解决');
        $this->save();
      }
    }

    NotifyTemplate::sendAdmin(28, '运营管理员审核投诉信息通知', [
      'nickname' => $userData->id.'-'.$userData->nickname,
      'phone' => $userData->phone ?? '--',
      'title' => $this->id.'-'.$this->title,
      'content' => InfoComplaint::getOptionsLabel('complaint_type', $infoComplaintData->complaint_type).'：'.$infoComplaintData->complaint_content,
      '_model' => 'Info/Hr/HrJob,Info/Hr/HrResume'
    ]);
    return $infoComplaintData;
  }

  /**
   * @return bool
   */
  public function modelIsPay()
  {
    return $this->user_order()
      ->where('user_id', User::getUserId())
      ->where('pay_status', UserOrder::getPayStatusValue(2, '已支付'))
      ->exists();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\MorphMany|null|object
   */
  public function modelGetPayOrder()
  {
    return $this->user_order()
      ->where('user_id', User::getUserId())
      ->where('pay_status', UserOrder::getPayStatusValue(2, '已支付'))
      ->first();
  }

  /**
   * @param $id
   * @param $_title
   * @return bool
   */
  public function modelStatusIsEqualTo($id, $_title)
  {
    $className = get_class($this);
    return $this->status === $className::getStatusValue($id, $_title);
  }

  /**
   * @param $id
   * @param $_title
   * @return mixed
   */
  public function modelGetStatusValue($id, $_title)
  {
    $className = get_class($this);
    return $className::getStatusValue($id, $_title);
  }

  /**
   * @return array
   */
  public function modelGetRecommendList()
  {
    $industryIds = $this->industry->pluck('id');
    $city = $this->city;
    $modelPath = get_class($this);
    $data = $modelPath::aiQuery($industryIds, $city, 0);
    return collect($data)->filter(function ($item) {
      return $item->id !== $this->id;
    })->values();
  }

  /**
   * @return mixed
   */
  public function modelGetInfoViews()
  {
    $share_user_id = request()->input('share_user_id');
    $is_new_user = request()->input('is_new_user');
    return $this->info_view()
      ->with('user:id,nickname')
      ->when($share_user_id, function (Builder $query, $share_user_id) {
        return $query->where('share_user_id', $share_user_id);
      })
      ->when($is_new_user, function (Builder $query, $is_new_user) {
        return $query->where('is_new_user', $is_new_user);
      })
      ->orderByDesc('id')
      ->pagination();
  }
}
