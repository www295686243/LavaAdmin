<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/9/4
 * Time: 11:39
 */

namespace App\Http\Controllers\Api\Traits;

use App\Http\Requests\Api\WeChatRequest;
use App\Models\Api\User;
use App\Models\Base;
use App\Models\User\UserCoupon;
use App\Models\User\UserOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait PayTrait
{
  /**
   * @return mixed
   */
  public function payCallback()
  {
    $app = app('wechat.payment');
    return $app->handlePaidNotify(function ($res, $fail) {
      $orderId = $res['out_trade_no'];
      if ($res['return_code'] === 'SUCCESS') {
        // 表示通信状态，不代表支付状态
        DB::beginTransaction();
        if ($res['result_code'] === 'SUCCESS') {
          // 支付成功
          try {
            $userOrderData = UserOrder::findOrFail($orderId);
            $userOrderData->paySuccess();
            $userOrderData->user_orderable->payCallback($userOrderData);
            DB::commit();
            return true;
          } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage().':'.__LINE__);
            return $fail($e->getMessage());
          }
        } else {
          // 支付失败
          try {
            $userOrderData = UserOrder::findOrFail($orderId);
            $userOrderData->payFail();
            DB::commit();
            return $fail('支付失败');
          } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage().':'.__LINE__);
            return $fail($e->getMessage());
          }
        }
      } else {
        return $fail('通信失败');
      }
    });
  }
}