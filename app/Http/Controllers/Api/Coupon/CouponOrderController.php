<?php

namespace App\Http\Controllers\Api\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Coupon\CouponOrderRequest;
use App\Jobs\CouponOrderQueue;
use App\Models\User\User;
use App\Models\Coupon\CouponMarket;
use App\Models\Coupon\CouponOrder;
use Illuminate\Support\Facades\DB;

class CouponOrderController extends Controller
{
  /**
   * @param CouponOrderRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(CouponOrderRequest $request)
  {
    $ids = $request->input('ids', []);
    if (count($ids) === 0) {
      return $this->error('请至少选择一张券');
    }
    $couponMarketList = CouponMarket::whereIn('id', $ids)
      ->where('status', CouponMarket::getStatusValue(1, '出售中'))
      ->get();
    if ($couponMarketList->count() !== count($ids)) {
      return $this->error('您选择的通用券状态错误，请刷新后重试');
    }

    DB::beginTransaction();
    try {
      // 锁定商品
      CouponMarket::whereIn('id', $ids)->update(['status' => CouponMarket::getStatusValue(2, '待支付')]);

      $couponOrderData = CouponOrder::createOrder($couponMarketList);
      $payResult = $couponOrderData->getPayOrderConfig();
      DB::commit();
      CouponOrderQueue::dispatch($couponOrderData->id)->delay(now()->addMinutes(5));
      return $this->setParams($payResult)->success('下单成功');
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getTraceAsString());
      return $this->error($e->getMessage());
    }
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function checkUnpaidOrder()
  {
    $data = CouponOrder::where('user_id', User::getUserId())
      ->where('pay_status', CouponOrder::getPayStatusValue(1, '未支付'))
      ->first();
    return $this->setParams($data)->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function continueUnpaidOrder()
  {
    $couponOrderData = CouponOrder::where('user_id', User::getUserId())
      ->where('pay_status', CouponOrder::getPayStatusValue(1, '未支付'))
      ->first();
    if ($couponOrderData) {
      $payResult = $couponOrderData->getPayOrderConfig();
      return $this->setParams($payResult)->success('下单成功');
    } else {
      return $this->error('该订单已过期，请重新下单');
    }
  }

  /**
   * @return mixed
   * @throws \Throwable
   */
  public function cancelUnpaidOrder()
  {
    $couponOrderData = CouponOrder::where('user_id', User::getUserId())
      ->where('pay_status', CouponOrder::getPayStatusValue(1, '未支付'))
      ->first();
    return DB::transaction(function () use ($couponOrderData) {
      if ($couponOrderData) {
        $couponOrderData->pay_status = CouponOrder::getPayStatusValue(4, '已放弃');
        $couponOrderData->save();
        $couponOrderData->unlockCouponMarketData();
      }
      return $this->success('放弃成功');
    });
  }

  /**
   * @return mixed
   */
  public function payCallback()
  {
    \Log::info(123);
    $app = app('wechat.payment');
    return $app->handlePaidNotify(function ($res, $fail) {
      $couponOrderId = $res['out_trade_no'];
      \Log::info($couponOrderId);
      if ($res['return_code'] !== 'SUCCESS') {
        return $fail('通信失败');
      }
      if ($res['result_code'] !== 'SUCCESS') {
        return $fail('支付失败'.$res['result_code']);
      }
      /**
       * @var CouponOrder $couponOrderData
       */
      $couponOrderData = CouponOrder::find($couponOrderId);
      if (!$couponOrderData) {
        return $fail('订单不存在');
      }

      $buyUserData = User::find($couponOrderData->user_id);
      if (!$buyUserData) {
        return $fail('购买用户不存在');
      }
      if ($couponOrderData->pay_status !== CouponOrder::getPayStatusValue(1, '未支付')) {
        // 这里应该退款，暂时没做
        $couponOrderData->remark = '订单状态错误，之前的状态是：'.$couponOrderData->pay_status;
      }
      // 给购买人记录账单
      DB::beginTransaction();
      try {
        $couponOrderData->paid_at = date('Y-m-d H:i:s'); // 更新支付时间为当前时间
        $couponOrderData->pay_status = CouponOrder::getPayStatusValue(2, '已支付');
        $couponOrderData->save();
        $couponOrderData->actionAfterPay();
        DB::commit();
        return true;
      } catch (\Exception $e) {
        DB::rollBack();
        \Log::error($e->getMessage());
        return $fail($e->getMessage());
      }
    });
  }
}
