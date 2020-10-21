<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserCashRequest;
use App\Models\User\UserCash;
use App\Models\User\UserWallet;
use Illuminate\Support\Facades\DB;

class UserCashController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = UserCash::searchQuery()->with('user:id,nickname')
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = UserCash::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param UserCashRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function update(UserCashRequest $request, $id)
  {
    $status = $request->input('status');
    $userCashData = UserCash::findOrFail($id);
    if ($status === UserCash::getStatusValue(2, '已通过') && $userCashData->status !== UserCash::getStatusValue(1, '申请中')) {
      return $this->error('无法修改该状态');
    }
    if ($status === UserCash::getStatusValue(3, '已拒绝') && !in_array($userCashData->status, [UserCash::getStatusValue(1, '申请中'), UserCash::getStatusValue(2, '已通过')])) {
      return $this->error('无法修改该状态');
    }
    if ($status === UserCash::getStatusValue(5, '已转款') && $userCashData->status !== UserCash::getStatusValue(2, '已通过')) {
      return $this->error('无法修改该状态');
    }
    DB::beginTransaction();
    try {
      $userCashData->status = $status;
      $userCashData->save();
      if ($status === UserCash::getStatusValue(3, '已拒绝')) {
        (new UserWallet())->incrementAmount($userCashData->amount, $userCashData->user_id);
      }
      DB::commit();
      return $this->success();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      return $this->error();
    }
  }
}
