<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\InfoProvideRequest;
use App\Models\Admin\User;
use App\Models\Coupon\CouponTemplate;
use App\Models\Info\InfoProvide;
use Illuminate\Support\Facades\DB;

class InfoProvideController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = InfoProvide::with(['user:id,nickname', 'admin_user:id,nickname'])
      ->searchQuery()
      ->searchModel('info_provideable_type')
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param InfoProvideRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(InfoProvideRequest $request)
  {
    $input = $request->only(InfoProvide::getFillFields());
    $input['user_id'] = User::getUserId();
    $input['info_provideable_type'] = $this->getModelPath();
    $input['is_admin'] = InfoProvide::$ENABLE;
    $input['description'] = trim($input['description']);
    if ($input['status'] !== InfoProvide::getStatusValue(1, '待审核')) {
      $input['admin_user_id'] = User::getUserId();
    }
    $data = InfoProvide::create($input);
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = InfoProvide::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param InfoProvideRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function update(InfoProvideRequest $request, $id)
  {
    $status = $request->input('status');
    $rewards = $request->input('rewards', []);
    $pushText = $request->input('push_text');
    $infoProvideData = InfoProvide::findOrFail($id);

    DB::beginTransaction();
    try {
      if ($status !== InfoProvide::getStatusValue(1, '待审核')) {
        $infoProvideData->status = $status;
        $infoProvideData->admin_user_id = User::getUserId();

        if ($infoProvideData->is_admin === InfoProvide::$DISABLE && $infoProvideData->is_reward === InfoProvide::$DISABLE) {
          CouponTemplate::giveManyCoupons($infoProvideData->user_id, $rewards, '招聘信息提供：'.$infoProvideData->id);
          if (count($rewards) > 0) {
            $infoProvideData->is_reward = InfoProvide::$ENABLE;
          }
        }
        $infoProvideData->save();
      }
      DB::commit();
      return $this->success();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage());
      return $this->error();
    }
  }
}
