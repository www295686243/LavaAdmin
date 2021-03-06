<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\InfoProvideRequest;
use App\Models\User\User;
use App\Models\Info\InfoProvide;
use Illuminate\Support\Facades\DB;

class InfoProvideController extends Controller
{
  /**
   * @param InfoProvideRequest $request
   * @return \Illuminate\Http\JsonResponse|mixed
   * @throws \Throwable
   */
  public function store(InfoProvideRequest $request)
  {
    $input = $request->only(InfoProvide::getFillFields());
    $input['user_id'] = User::getUserId();
    $input['description'] = trim($input['description']);
    $input['status'] = InfoProvide::getStatusValue(1, '待审核');
    $input['info_provideable_type'] = $this->getModelPath();

    $data = InfoProvide::where('description', $input['description'])->first();
    if ($data) {
      return $this->error('该信息已被提交过，不能被再次提交！');
    }
    $data = InfoProvide::where('phone', $input['phone'])->first();
    return DB::transaction(function () use ($data, $input) {
      $infoProvideData = InfoProvide::create($input);
      $infoProvideData->getTask();
      return $this->success($data ? '该号码发布过，请等待客服审核确认！' : '请等待客服审核！');
    });
  }
}
