<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\InfoCheckRequest;
use App\Models\Api\User;
use App\Models\Info\InfoCheck;
use Illuminate\Http\Request;

class InfoCheckController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = InfoCheck::select(['id', 'user_id', 'info_title', 'status', 'refuse_reason', 'created_at'])
      ->where('user_id', User::getUserId())
      ->where('info_checkable_type', $this->getModelPath())
      ->where('status', '!=', InfoCheck::getOptionsValue(48, '已审核'))
      ->orderByDesc('id')
      ->get();
    return $this->setParams($data)->success();
  }

  /**
   * @param InfoCheckRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(InfoCheckRequest $request)
  {
    $input = $request->all();
    $input['contents']['user_id'] = User::getUserId();
    InfoCheck::create([
      'info_checkable_type' => $this->getModelPath(),
      'info_title' => $input['contents']['title'],
      'user_id' => $input['contents']['user_id'],
      'contents' => $input['contents'],
      'status' => InfoCheck::getOptionsValue(47, '待审核')
    ]);

    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = InfoCheck::findOrAuth($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param InfoCheckRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(InfoCheckRequest $request, $id)
  {
    $input = $request->input('contents');
    $data = InfoCheck::findOrAuth($id);
    if ($data->status !== InfoCheck::getOptionsValue(49, '未通过')) {
      return $this->error('状态异常');
    }
    $data->info_title = $input['title'];
    $data->contents = $input;
    $data->status = InfoCheck::getOptionsValue(47, '待审核');
    $data->save();
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    $data = InfoCheck::findOrAuth($id);
    return $data->delete() ? $this->success() : $this->error();
  }
}
