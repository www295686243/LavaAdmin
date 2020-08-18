<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notify\Notify;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = Notify::with('user:id,nickname')->searchQuery()->orderByDesc('id')->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = Notify::findOrFail($id);
    return $this->setParams($data)->success();
  }
}
