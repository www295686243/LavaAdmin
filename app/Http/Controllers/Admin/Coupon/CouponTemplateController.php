<?php

namespace App\Http\Controllers\Admin\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\CouponTemplateRequest;
use App\Models\Coupon\CouponTemplate;

class CouponTemplateController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = CouponTemplate::orderByDesc('id')->paginate(10);
    return $this->setParams($data)->success();
  }

  /**
   * @param CouponTemplateRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(CouponTemplateRequest $request)
  {
    $input = $request->only(CouponTemplate::getFillFields());
    CouponTemplate::create($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = CouponTemplate::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param CouponTemplateRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(CouponTemplateRequest $request, $id)
  {
    $input = $request->only(CouponTemplate::getFillFields());
    $couponTemplateData = CouponTemplate::findOrFail($id);
    $couponTemplateData->update($input);
    return $this->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getAll()
  {
    $data = CouponTemplate::all();
    return $this->setParams($data)->success();
  }
}
