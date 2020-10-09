<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\InfoComplaintRequest;
use App\Models\Api\User;
use App\Models\Info\InfoComplaint;
use Illuminate\Http\Request;

class InfoComplaintController extends Controller
{
  /**
   * @param InfoComplaintRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(InfoComplaintRequest $request)
  {
    $input = $request->only(['complaint_type', 'complaint_content']);
    $input['user_id'] = User::getUserId();
    $input['info_complaintable_type'] = $this->getModelPath();
    $input['info_complaintable_id'] = $request->input('info_id');

    $isExist = $this->_getInfoComplaint($request);
    if ($isExist) {
      return $this->error('您已投诉过该信息');
    }

    $data = InfoComplaint::create($input);

    return $this->setParams($data)->success('反馈成功');
  }

  /**
   * @param InfoComplaintRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getInfoComplaint(InfoComplaintRequest $request)
  {
    $data = $this->_getInfoComplaint($request);
    return $this->setParams($data)->success();
  }

  /**
   * @param InfoComplaintRequest $request
   * @return InfoComplaint|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
   */
  private function _getInfoComplaint(InfoComplaintRequest $request) {
    $model = $this->getModelPath();
    $info_id = $request->input('info_id');
    $data = InfoComplaint::where('user_id', User::getUserId())
      ->where('info_complaintable_type', $model)
      ->where('info_complaintable_id', $info_id)
      ->first();
    return $data;
  }
}
