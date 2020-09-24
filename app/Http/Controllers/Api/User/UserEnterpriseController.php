<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserEnterpriseRequest;
use App\Models\Api\User;
use App\Models\User\UserEnterprise;

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
    return $this->setParams($data)->success();
  }

  /**
   * @param UserEnterpriseRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UserEnterpriseRequest $request, $id)
  {
    $userId = User::getUserId();
    $data = UserEnterprise::where('user_id', $userId)->firstOrFail();
    $input = $request->only(UserEnterprise::getUpdateFillable());
    $data->update($input);
    return $this->success();
  }
}
