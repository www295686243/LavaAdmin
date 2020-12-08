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
   * @throws \Throwable
   */
  public function pay()
  {
    $user_coupon_id = request()->input('user_coupon_id');
    $userData = User::getUserData();
    $userAuthData = $userData->auth;
    $total_amount = $this->getPayAmount();
    $coupon_amount = (new UserCoupon())->getUsableCouponAmount($user_coupon_id);
    $cash_amount = $total_amount - $coupon_amount;
    $cash_amount = $cash_amount > 0 ? $cash_amount : 0;

    DB::beginTransaction();
    try {
      $infoData = $this->getModelData();
      /**
       * @var UserOrder $userOrderData
       */
      $userOrderData = $infoData->user_order()->create([
        'user_id' => $userData->id,
        'total_amount' => $total_amount,
        'cash_amount' => $cash_amount,
        'coupon_amount' => $coupon_amount,
        'user_coupon_id' => $user_coupon_id
      ]);

      if ($cash_amount > 0) {
        if ($userAuthData && $userAuthData->wx_openid) {
          $app = app('wechat.payment');
          $order = $app->order->unify([
            'body' => '查看联系方式',
            'out_trade_no' => $userOrderData->id,
            'total_fee' => $userOrderData->total_amount * 100,
            'trade_type' => 'JSAPI',
            'openid' => $userAuthData->wx_openid,
            'notify_url' => $this->getNotifyUrl()
          ]);
          $config = $app->jssdk->sdkConfig($order['prepay_id']);
          DB::commit();
          return $this->setParams($config)->success('获取支付配置成功');
        } else {
          throw new \Exception('支付失败');
        }
      } else {
        $userOrderData->paySuccess();
        $userOrderData->user_orderable->payCallback($userOrderData);
        DB::commit();
        return $this
          ->setParams(['pay_status' => 'success'])
          ->setExtra([
            'isFirstPay' => $userOrderData->isFirstPay(),
            'isModelFirstPay' => $userOrderData->isModelFirstPay()
          ])
          ->success('支付成功');
      }
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      return $this->error('支付失败');
    }
  }

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

  public function getContacts()
  {
    $infoData = $this->getModelData();
    if ($infoData->modelIsPay()) {
      return $this->setParams([
        'phone' => $infoData->phone,
        'contacts' => $infoData->contacts
      ])->success();
    } else {
      return $this->error();
    }
  }

  /**
   * @return float
   */
  private function getPayAmount()
  {
    /**
     * @var Base $modelPath
     */
    $modelPath = $this->getModelPath();
    $amount = $modelPath::getConfigValue('amount');
    return floatval($amount);
  }

  /**
   * @return string
   */
  private function getNotifyUrl () {
    $modelPath = $this->getModelPath();
    $snakeType = Str::of($modelPath)->basename()->snake();
    return env('APP_URL').'/api/'.$snakeType.'/pay_callback';
  }
}