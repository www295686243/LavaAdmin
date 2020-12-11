<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserEnterpriseRequest;
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
    $data = UserEnterprise::where('user_id', $id)->firstOrFail();
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
    $input = $request->only(UserEnterprise::getFillFields());
    return DB::transaction(function () use ($input, $id) {
      UserEnterprise::updateInfo($input, $id);
      return $this->success();
    });
  }
}
