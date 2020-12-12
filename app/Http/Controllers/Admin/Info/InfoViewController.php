<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;

class InfoViewController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $infoData = $this->getModelData();
    $data = $infoData->modelGetInfoViews();
    return $this->setParams($data)->success();
  }
}
