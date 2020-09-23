<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserPersonalRequest;
use App\Models\Api\User;
use App\Models\User\UserPersonal;
use Illuminate\Http\Request;

class UserPersonalController extends Controller
{
  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $userId = User::getUserId();
    $data = UserPersonal::where('user_id', $userId)->firstOrFail();
    return $this->setParams($data)->success();
  }

  /**
   * @param UserPersonalRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UserPersonalRequest $request, $id)
  {
    $userId = User::getUserId();
    $data = UserPersonal::where('user_id', $userId)->firstOrFail();
    $input = $request->only(UserPersonal::getUpdateFillable());
    $data->update($input);
    return $this->success();
  }
}
