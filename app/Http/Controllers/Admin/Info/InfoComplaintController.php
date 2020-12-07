<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\InfoComplaintRequest;
use App\Models\Info\InfoComplaint;
use App\Models\Notify\NotifyTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    $className = get_class($data->info_complaintable);
    $tempId = 0;
    $tempTitle = '';
    if (Str::contains($className, 'HrJob')) {
      $tempId = 29;
      $tempTitle = '推送给用户职位投诉结果通知';
    } else if (Str::contains($className, 'HrResume')) {
      $tempId = 30;
      $tempTitle = '推送给用户简历投诉结果通知';
    }
    if ($tempId) {
      NotifyTemplate::send($tempId, $tempTitle, $data->user_id, [
        'id' => $data->info_complaintable_id,
        'updated_at' => $data->updated_at->format('Y-m-d H:i:s'),
        'handle_content' => $data->handle_content
      ]);
    }
    return $this->success();
  }
}
