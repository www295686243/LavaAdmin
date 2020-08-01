<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppRequest;
use App\Models\Config;

class AppController extends Controller
{
  /**
   * @param AppRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getAppConfig(AppRequest $request)
  {
    $guard_name = $request->input('guard_name');
    $data = Config::with('options')
      ->when($guard_name, function ($query, $guard_name) {
        return $query->where('guard_name', $guard_name);
      })
      ->get()
      ->groupBy('guard_name');
    return $this->setParams($data)->success();
  }
}
