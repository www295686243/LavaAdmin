<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserEnterpriseRequest;
use App\Models\User\UserEnterprise;

class UserEnterpriseController extends Controller
{
  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = UserEnterprise::where('user_id', $id)->first();
    return $this->setParams($data)->success();
  }

  /**
   * @param UserEnterpriseRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UserEnterpriseRequest $request, $id)
  {
    $input = $request->only(UserEnterprise::getUpdateFillable());
    $data = UserEnterprise::where('user_id', $id)->first();
    $data->update($input);
    return $this->success();
  }
}
