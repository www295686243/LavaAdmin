<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\HrJobRequest;
use App\Models\Admin\User;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoSub;
use Illuminate\Http\Request;

class HrController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = HrJob::searchQuery()->with(['user:id,nickname'])
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
    $data = Hr::findOrAuth($id);
    return $this->setParams($data)->success();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    $data = Hr::findOrAuth($id);
    return $data->delete() ? $this->success() : $this->error();
  }
}
