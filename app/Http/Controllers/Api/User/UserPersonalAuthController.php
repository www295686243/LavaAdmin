<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserPersonalAuthRequest;
use App\Models\Api\User;
use App\Models\Image;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\UserPersonalAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPersonalAuthController extends Controller
{

  /**
   * @param UserPersonalAuthRequest $request
   * @return \Illuminate\Http\JsonResponse|mixed
   * @throws \Throwable
   */
  public function store(UserPersonalAuthRequest $request)
  {
    $checking = UserPersonalAuth::getStatusValue(1, '审核中');
    $isExistCheckData = UserPersonalAuth::where('user_id', User::getUserId())
      ->where('status', $checking)
      ->exists();
    if ($isExistCheckData) {
      return $this->error('请等待管理员审核');
    }

    $input = $request->only(['name', 'company', 'position', 'city', 'address', 'intro', 'certificates']);
    $input['status'] = $checking;
    $input['user_id'] = User::getUserId();

    return DB::transaction(function () use ($input) {
      $data = UserPersonalAuth::create($input);
      (new Image())->updateImageableId($data->id);

      NotifyTemplate::sendAdmin(26, '运营管理员审核个人认证通知', [
        'id' => $data->id,
        'title' => '个人认证',
        'contacts' => $data->name,
        'description' => $data->intro,
        'created_at' => $data->created_at->format('Y-m-d H:i:s')
      ]);

      return $this->success('提交成功，请等待审核！');
    });
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
