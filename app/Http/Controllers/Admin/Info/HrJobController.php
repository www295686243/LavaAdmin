<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\HrJobRequest;
use App\Models\Admin\User;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoSub;
use Illuminate\Http\Request;

class HrJobController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = HrJob::searchQuery()->with(['user:id,nickname', 'admin_user:id,nickname'])
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(HrJobRequest $request)
  {
    $input = $request->only(HrJob::getFillFields());
    $input['user_id'] = User::getUserId();
    $input['admin_user_id'] = User::getUserId();
    $input['status'] = optional($input)['status'] ?? HrJob::getOptionsValue(50, '已发布');
    $input['intro'] = $request->input('description') ? mb_substr($request->input('description'), 0, 60) : '';
    $input['refresh_at'] = date('Y-m-d H:i:s');
    $data = HrJob::create($input);
    $data->info_sub()->create($request->only(InfoSub::getFillFields()));
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = HrJob::findOrAuth($id);
    $subData = $data->info_sub()->firstOrFail();
    $data = array_merge($data->toArray(), $subData->toArray());
    return $this->setParams($data)->success();
  }

  /**
   * @param HrJobRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(HrJobRequest $request, $id)
  {
    $input = $request->only(HrJob::getFillFields());
    $input['status'] = optional($input)['status'] ?? HrJob::getOptionsValue(50, '已发布');
    $input['intro'] = $request->input('description') ? mb_substr($request->input('description'), 0, 60) : '';
    $input['refresh_at'] = date('Y-m-d H:i:s');
    $data = HrJob::findOrAuth($id);
    $data->update($input);
    $data->info_sub()->update($request->only(InfoSub::getFillFields()));
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    $data = HrJob::findOrAuth($id);
    $data->info_sub()->delete();
    $data->delete();
    return $this->success();
  }
}
