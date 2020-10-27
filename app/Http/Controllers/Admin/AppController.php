<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppRequest;
use App\Models\Config;
use App\Models\Coupon\CouponTemplate;
use App\Models\Info\Industry;

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
      $data['industry'] = Industry::all()->toTree();
      $this->removeEmptyChildren($data['industry']);
    }
    if (!$guard_name || $guard_name === 'coupon_template') {
      $data['coupon_template'] = CouponTemplate::orderBy('id', 'asc')->orderBy('sort', 'desc')->get();
    }
    return $this->setParams($data)->success();
  }

  private function removeEmptyChildren($elements)
  {
    foreach ($elements as $element) {
      if($element->children->isNotEmpty()) {
        $this->removeEmptyChildren($element->children);
      } else {
        $element->unsetRelation('children');
      }
    }
  }
}
