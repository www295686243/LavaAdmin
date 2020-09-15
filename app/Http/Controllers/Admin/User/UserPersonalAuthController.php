<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserPersonalAuthRequest;
use App\Models\Api\User;
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
    $auth_status = $request->input('auth_status');
    $authData = UserPersonalAuth::findOrFail($id);
    $userData = User::findOrFail($authData->user_id);

    $passed = UserPersonalAuth::getOptionsValue(42, '已通过');
    $notPass = UserPersonalAuth::getOptionsValue(43, '已拒绝');

    DB::beginTransaction();

    try {
      if ($auth_status === $passed) {
        if ($authData->auth_status === $passed) {
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
        $userData->assignRole('Personal Member');
      } else if ($auth_status === $notPass) {
        $authData->refuse_reason = $request->input('refuse_reason');
      }

      $authData->auth_status = $auth_status;
      $authData->save();
      DB::commit();
      return $this->success();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      return $this->error();
    }
  }
}
