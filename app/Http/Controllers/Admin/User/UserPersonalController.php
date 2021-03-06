<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserPersonalRequest;
use App\Models\User\UserPersonal;
use Illuminate\Support\Facades\DB;

class UserPersonalController extends Controller
{
  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = UserPersonal::where('user_id', $id)->firstOrFail();
    $data->industry;
    return $this->setParams($data)->success();
  }

  /**
   * @param UserPersonalRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function update(UserPersonalRequest $request, $id)
  {
    $input = $request->only(UserPersonal::getFillFields());
    return DB::transaction(function () use ($input, $id) {
      UserPersonal::updateInfo($input, $id);
      return $this->success();
    });
  }
}
