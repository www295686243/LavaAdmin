<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserPersonalRequest;
use App\Models\Api\User;
use App\Models\Info\Industry;
use App\Models\Info\InfoCheck;
use App\Models\User\UserPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    $data = UserPersonal::findOrFail($id);
    $input = $request->only(UserPersonal::getUpdateFillable());
    DB::beginTransaction();
    try {
      $data->update($input);
      $data->attachIndustry();
      DB::commit();
      return $this->success();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      return $this->error();
    }
  }

  /**
   * @param UserPersonalRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function check(UserPersonalRequest $request)
  {
    $input = $request->getAll();
    $input['_model'] = UserPersonal::class;
    $input['user_id'] = User::getUserId();
    $input['title'] = User::getUserData()->nickname.'的资料审核';
    InfoCheck::createInfo($input);
    return $this->success();
  }
}
