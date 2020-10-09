<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\InfoComplaintRequest;
use App\Models\Info\InfoComplaint;
use Illuminate\Http\Request;

class InfoComplaintController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = InfoComplaint::with(['info_complaintable:id,title', 'user:id,nickname'])
      ->searchModel('info_complaintable_type')
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = InfoComplaint::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param InfoComplaintRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(InfoComplaintRequest $request, $id)
  {
    $input = $request->only(['handle_content']);
    $input['is_solve'] = InfoComplaint::$ENABLE;
    $data = InfoComplaint::findOrFail($id);
    $data->update($input);
    return $this->success();
  }
}
