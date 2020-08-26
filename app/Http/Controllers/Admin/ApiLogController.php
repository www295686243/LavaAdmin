<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApiLogRequest;
use App\Models\ApiLog;
use Illuminate\Http\Request;

class ApiLogController extends Controller
{
  /**
   * @param ApiLogRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(ApiLogRequest $request)
  {
    $user_id = $request->input('user_id');
    $data = ApiLog::where('user_id', $user_id)->orderByDesc('created_at')->pagination();
    return $this->setParams($data)->success();
  }
}
