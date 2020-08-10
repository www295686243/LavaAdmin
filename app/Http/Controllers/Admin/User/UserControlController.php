<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserControlRequest;
use App\Models\User\UserControl;

class UserControlController extends Controller
{
  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = UserControl::where('user_id', $id)->first();
    return $this->setParams($data)->success();
  }

  /**
   * @param UserControlRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UserControlRequest $request, $id)
  {
    $input = $request->only(UserControl::getUpdateFillable());
    $data = UserControl::where('user_id', $id)->first();
    $data->update($input);
    return $this->success();
  }
}
