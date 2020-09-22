<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserPersonalAuthRequest;
use App\Models\Api\User;
use App\Models\Image;
use App\Models\User\UserPersonalAuth;
use Illuminate\Http\Request;

class UserPersonalAuthController extends Controller
{

  /**
   * @param UserPersonalAuthRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(UserPersonalAuthRequest $request)
  {
    $checking = UserPersonalAuth::getOptionsValue(41, '审核中');
    $isExistCheckData = UserPersonalAuth::where('user_id', User::getUserId())
      ->where('auth_status', $checking)
      ->exists();
    if ($isExistCheckData) {
      return $this->error('请等待管理员审核');
    }

    $input = $request->only(['name', 'company', 'position', 'city', 'address', 'intro', 'certificates']);
    $input['auth_status'] = $checking;
    $input['user_id'] = User::getUserId();

    $data = UserPersonalAuth::create($input);
    (new Image())->updateImageableId($data->id);

    return $this->success('提交成功，请等待审核！');
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function show()
  {
    $data = UserPersonalAuth::where('user_id', User::getUserId())
      ->orderByDesc('id')
      ->first();
    return $this->setParams($data)->success();
  }
}