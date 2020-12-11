<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserPersonalAuthRequest;
use App\Models\Api\User;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\UserPersonal;
use App\Models\User\UserPersonalAuth;
use Illuminate\Support\Facades\DB;

class UserPersonalAuthController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = UserPersonalAuth::with('user:id,nickname,phone')
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
    $data = UserPersonalAuth::with('user:id,nickname,phone')->findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param UserPersonalAuthRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function update(UserPersonalAuthRequest $request, $id)
  {
    $status = (int)$request->input('status');
    $authData = UserPersonalAuth::findOrFail($id);
    $userData = User::findOrFail($authData->user_id);

    $passed = UserPersonalAuth::getStatusValue(2, '已通过');
    $notPass = UserPersonalAuth::getStatusValue(3, '已拒绝');

    // 如果未改变状态，直接返回
    if ($status === $authData->status) {
      return $this->success();
    }
    return DB::transaction(function () use ($status, $passed, $authData, $userData, $notPass, $request) {
      if ($status === $passed) {
        if ($authData->status === $passed) {
          return $this->error('该申请已经审核通过了');
        }
        $userPersonalData = UserPersonal::where('user_id', $authData->user_id)->firstOrFail();
        $userPersonalData->name = $authData->name;
        $userPersonalData->company = $authData->company;
        $userPersonalData->position = $authData->position;
        $userPersonalData->city = $authData->city;
        $userPersonalData->address = $authData->address;
        $userPersonalData->intro = $authData->intro;
        $userPersonalData->save();
        $userData->assignRole('Personal Auth');
        NotifyTemplate::send(1, '个人认证通过通知', $userData, [
          'nickname' => $userData->nickname,
          'name' => $authData->name,
          'datetime' => date('Y-m-d H:i:s')
        ]);
      } else if ($status === $notPass) {
        $authData->refuse_reason = $request->input('refuse_reason');
        NotifyTemplate::send(2, '个人认证不通过通知', $userData, [
          'refuse_reason' => $authData->refuse_reason,
          'name' => '原草客服'
        ]);
      }

      $authData->status = $status;
      $authData->save();
      return $this->success();
    });
  }
}
