<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\NotifyUserRequest;
use App\Models\User\User;
use App\Models\Notify\NotifyUser;

class NotifyUserController extends Controller
{
  /**
   * @param NotifyUserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(NotifyUserRequest $request)
  {
    $notify_template_id = $request->input('notify_template_id');
    $data = NotifyUser::with('user:id,nickname')
      ->where('notify_template_id', $notify_template_id)
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param NotifyUserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(NotifyUserRequest $request)
  {
    $input = $request->only(NotifyUser::getFillFields());
    $isExistRecord = NotifyUser::where('user_id', $input['user_id'])
      ->where('notify_template_id', $input['notify_template_id'])
      ->exists();
    if ($isExistRecord) {
      return $this->error('已存在该用户');
    }

    $isExistUser = User::find($input['user_id']);
    if (!$isExistUser) {
      return $this->error('不存在该用户');
    }

    NotifyUser::create($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $data = NotifyUser::findOrFail($id);
    return $data->delete() ? $this->success() : $this->error();
  }
}
