<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserEnterpriseRequest;
use App\Models\User\User;
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
    $input = $request->only(UserEnterprise::getFillFields());
    DB::beginTransaction();
    try {
      UserEnterprise::updateInfo($input);
      DB::commit();
      return $this->success();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      return $this->error();
    }
  }
}
