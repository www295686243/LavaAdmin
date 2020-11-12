<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\InfoProvideRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoProvide;
use Illuminate\Http\Request;

class InfoProvideController extends Controller
{
  /**
   * @param InfoProvideRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(InfoProvideRequest $request)
  {
    $input = $request->only(InfoProvide::getFillFields());
    $input['user_id'] = User::getUserId();
    $input['description'] = trim($input['description']);
    $input['status'] = InfoProvide::getStatusValue(1, '待审核');
    $input['info_provideable_type'] = HrJob::class;

    $data = InfoProvide::where('description', $input['description'])->first();
    if ($data) {
      return $this->error('该信息已被提交过，不能被再次提交！');
    }
    $data = InfoProvide::where('phone', $input['phone'])->first();
    InfoProvide::create($input);
    return $this->success($data ? '该号码发布过，请等待客服审核确认！' : '请等待客服审核！');
  }
}
