<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserPersonalRequest;
use App\Models\User\UserPersonal;

class UserPersonalController extends Controller
{
  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = UserPersonal::where('user_id', $id)->first();
    return $this->setParams($data)->success();
  }

  /**
   * @param UserPersonalRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UserPersonalRequest $request, $id)
  {
    $input = $request->only(UserPersonal::getUpdateFillable());
    $data = UserPersonal::where('user_id', $id)->first();
    $data->update($input);
    return $this->success();
  }
}
