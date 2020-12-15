<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserCashRequest;
use App\Models\User\User;
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
    $data = UserCash::where('user_id', User::getUserId())
      ->orderByDesc('id')
      ->simplePagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param UserCashRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(UserCashRequest $request)
  {
    $amount = $request->input('amount');

    $userWalletData = UserWallet::where('user_id', User::getUserId())->firstOrFail();
    if ($amount > $userWalletData->money) {
      return $this->error('您的金额不足');
    }

    DB::beginTransaction();
    try {
      UserCash::create([
        'user_id' => User::getUserId(),
        'status' => UserCash::getStatusValue(1, '申请中'),
        'amount' => $amount
      ]);
      $userWalletData->money -= $amount;
      $userWalletData->save();
      DB::commit();
      return $this->success('申请成功，请等待审核');
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      return $this->error();
    }
  }

  /**
   * @param UserCashRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function update(UserCashRequest $request, $id)
  {
    $userCashData = UserCash::findOrFail($id);
    if ($userCashData->status !== UserCash::getStatusValue(1, '申请中')) {
      return $this->error('状态错误，请刷新后重试');
    }
    $userWalletData = UserWallet::where('user_id', User::getUserId())->firstOrFail();

    DB::beginTransaction();
    try {
      $userCashData->update(['status' => UserCash::getStatusValue(4, '已撤回')]);
      $userWalletData->money += $userCashData->amount;
      $userWalletData->save();
      DB::commit();
      return $this->success('撤回成功');
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      return $this->error();
    }
  }
}
