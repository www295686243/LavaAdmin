<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserEnterpriseRequest;
use App\Models\Api\User;
use App\Models\User\UserEnterprise;
use Illuminate\Support\Facades\DB;

class UserEnterpriseController extends Controller
{
  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $userId = User::getUserId();
    $data = UserEnterprise::where('user_id', $userId)->firstOrFail();
    $data->industry;
    return $this->setParams($data)->success();
  }

  /**
   * @param UserEnterpriseRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function update(UserEnterpriseRequest $request, $id)
  {
    $userId = User::getUserId();
    $data = UserEnterprise::where('user_id', $userId)->firstOrFail();
    $input = $request->only(UserEnterprise::getUpdateFillable());
    DB::beginTransaction();
    try {
      $data->update($input);
      $data->attachIndustry();
      if (isset($input['city'])) {
        $userData = User::getUserData();
        $userData->city = $input['city'];
        $userData->save();
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
