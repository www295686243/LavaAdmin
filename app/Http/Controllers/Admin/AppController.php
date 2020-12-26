<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppRequest;
use App\Models\Config;
use App\Models\Coupon\CouponTemplate;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\Info\Industry;
use App\Models\Info\InfoCheck;
use App\Models\Info\InfoComplaint;
use App\Models\Info\InfoProvide;
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
      $this->removeEmptyChildren($data['industry']);
    }
    if (!$guard_name || $guard_name === 'coupon_template') {
      $data['coupon_template'] = (new CouponTemplate())->cacheGetAll();
    }
    if (!$guard_name || $guard_name === 'task') {
      $data['task'] = (new Task())->cacheGetAll();
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

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getMenuInfoStat()
  {
    return $this->setParams([
      '/hr/job/info-check' => InfoCheck::where('info_checkable_type', HrJob::class)->where('status', InfoCheck::getStatusValue(1, '待审核'))->count(),
      '/hr/job/info-provide' => InfoProvide::where('info_provideable_type', HrJob::class)->where('status', InfoCheck::getStatusValue(1, '待审核'))->count(),
      '/hr/job/info-complaint' => InfoComplaint::where('info_complaintable_type', HrJob::class)->where('is_solve', 0)->count(),
      '/hr/resume/info-check' => InfoCheck::where('info_checkable_type', HrResume::class)->where('status', InfoCheck::getStatusValue(1, '待审核'))->count(),
      '/hr/resume/info-provide' => InfoProvide::where('info_provideable_type', HrResume::class)->where('status', InfoCheck::getStatusValue(1, '待审核'))->count(),
      '/hr/resume/info-complaint' => InfoComplaint::where('info_complaintable_type', HrResume::class)->where('is_solve', 0)->count()
    ])->success();
  }
}
