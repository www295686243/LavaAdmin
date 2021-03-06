<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AppRequest;
use App\Models\Config;
use App\Models\Coupon\CouponTemplate;
use App\Models\Info\Industry;
use App\Models\Task\Task;

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
    if (!$guard_name || $guard_name === 'industry') {
      $data['industry'] = (new Industry())->cacheGetAll()->toTree();
    }
    if (!$guard_name || $guard_name === 'coupon_template') {
      $data['coupon_template'] = (new CouponTemplate())->cacheGetAll();
    }
    if (!$guard_name || $guard_name === 'task') {
      $data['task'] = (new Task())->cacheGetAll();
    }
    return $this->setParams($data)->success();
  }
}
