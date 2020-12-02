<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserEnterpriseAuthRequest;
use App\Models\Api\User;
use App\Models\Image;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\UserEnterpriseAuth;
use Illuminate\Http\Request;

class UserEnterpriseAuthController extends Controller
{
  /**
   * @param UserEnterpriseAuthRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(UserEnterpriseAuthRequest $request)
  {
    $checking = UserEnterpriseAuth::getStatusValue(1, '审核中');
    $isExistCheckData = UserEnterpriseAuth::where('user_id', User::getUserId())
      ->where('status', $checking)
      ->exists();
    if ($isExistCheckData) {
      return $this->error('请等待管理员审核');
    }

    $input = $request->only(['company', 'business_license', 'city', 'address', 'intro', 'certificates']);
    $input['status'] = $checking;
    $input['user_id'] = User::getUserId();

    $data = UserEnterpriseAuth::create($input);
    (new Image())->updateImageableId($data->id);

    NotifyTemplate::sendAdmin(27, '运营管理员审核企业认证通知', [
      'id' => $data->id,
      'title' => '企业认证',
      'contacts' => $data->company,
      'description' => $data->intro,
      'created_at' => $data->created_at
    ]);

    return $this->success('提交成功，请等待审核！');
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function show()
  {
    $data = UserEnterpriseAuth::where('user_id', User::getUserId())
      ->orderByDesc('id')
      ->first();
    return $this->setParams($data)->success();
  }
}
