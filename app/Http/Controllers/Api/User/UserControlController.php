<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserControlRequest;
use App\Models\Api\User;
use App\Models\User\UserControl;
use Illuminate\Http\Request;

class UserControlController extends Controller
{
  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = UserControl::where('user_id', User::getUserId())->firstOrFail();
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
    $userControlData = UserControl::where('user_id', User::getUserId())->firstOrFail();
    $userControlData->update($input);
    return $this->setParams($userControlData)->success();
  }
}
