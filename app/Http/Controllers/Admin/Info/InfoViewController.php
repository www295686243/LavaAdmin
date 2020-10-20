<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoViewController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $infoData = $this->getModelData();
    $data = $infoData->info_view()
      ->with('user:id,nickname')
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
