<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Models\Info\InfoDelivery;
use Illuminate\Http\Request;

class InfoDeliveryController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = InfoDelivery::searchQuery()
      ->with(['send_user:id,nickname', 'receive_user:id,nickname', 'send_info:id,title', 'receive_info:id,title'])
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
