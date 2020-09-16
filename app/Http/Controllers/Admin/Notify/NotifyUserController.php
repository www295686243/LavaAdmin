<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\NotifyUserRequest;
use App\Models\Notify\NotifyUser;
use Illuminate\Http\Request;

class NotifyUserController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = NotifyUser::searchQuery()
      ->with('user:id,nickname')
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
    $isExist = NotifyUser::where('user_id', $input['user_id'])
      ->where('notify_template_id', $input['notify_template_id'])
      ->exists();
    if ($isExist) {
      return $this->error('已存在该用户');
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
