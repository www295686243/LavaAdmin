<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserCashRequest;
use App\Models\Api\User;
use App\Models\User\UserCash;
use App\Models\User\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCashController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = UserCash::with('user:id,nickname')
      ->orderByDesc('id')
      ->pagination();
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
    if ($status === UserCash::getOptionsValue(85, '已通过') && $userCashData->status !== UserCash::getOptionsValue(84, '申请中')) {
      return $this->error('状态错误');
    }
    if ($status === UserCash::getOptionsValue(86, '已拒绝') && !in_array($userCashData->status, [UserCash::getOptionsValue(84, '申请中'), UserCash::getOptionsValue(85, '申请中')])) {
      return $this->error('状态错误');
    }
    DB::beginTransaction();
    try {
      $userCashData->status = $status;
      $userCashData->save();
      $userWalletData = UserWallet::where('user_id', User::getUserId())->firstOrFail();
      if ($status === UserCash::getOptionsValue(86, '已拒绝')) {
        $userWalletData->money += $userCashData->amount;
        $userWalletData->save();
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
