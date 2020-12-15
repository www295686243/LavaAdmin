<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\Info\InfoCheck;

class InfoCheckController extends Controller
{
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
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    $data = InfoCheck::findOrAuth($id);
    return $data->delete() ? $this->success() : $this->error();
  }
}
