<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WeChatRequest;
use App\Models\Api\User;
use App\Models\News;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\UserAuth;
use App\Models\User\UserCoupon;
use App\Models\User\UserOrder;
use Illuminate\Support\Facades\DB;

class WeChatController extends Controller
{
  /**
   * @param WeChatRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getConfig(WeChatRequest $request)
  {
    $app = app('wechat.official_account');
    $app->jssdk->setUrl($request->input('url'));
    $config = $app->jssdk->buildConfig([
      'updateAppMessageShareData',
      'updateTimelineShareData',
      'chooseImage',
      'previewImage',
      'chooseWXPay'
    ], false, false, false);
    return $this->setParams($config)->success();
  }

  /**
   * @param WeChatRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function auth(WeChatRequest $request)
  {
    $app = app('wechat.official_account');
    $response = $app->oauth->redirect(env('APP_M_URL').'/#/demo/wechat-login?redirect_url='.urlencode($request->input('redirect_url')));
    preg_match('/href="(.*)"/', (string)$response, $str);
    $url = str_replace('amp;', '', $str[1]);
    return $this->setParams(['url' => $url])->success('授权成功');
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function login()
  {
    $UserAuth = new UserAuth();
    $authInfo = $UserAuth->getWeChatAuthInfo();
    $userData = $UserAuth->getUserData($authInfo);
    return $this->setParams($userData)->success('微信'.($userData['is_register'] ? '注册' : '登录').'成功');
  }

  /**
   * @param WeChatRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function pay(WeChatRequest $request)
  {
    $user_coupon_id = $request->input('user_coupon_id');
    DB::beginTransaction();
    try {
      $userData = User::getUserData();
      $userAuthData = $userData->auth;
      $total_amount = 0.01;
      $coupon_amount = (new UserCoupon())->getUsableCouponAmount($user_coupon_id);
      $cash_amount = $total_amount - $coupon_amount;
      $cash_amount = $cash_amount > 0 ? $cash_amount : 0;

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
        $app = app('wechat.payment');
        $order = $app->order->unify([
          'body' => '查看联系方式',
          'out_trade_no' => $userOrderData->id,
          'total_fee' => $userOrderData->total_amount * 100,
          'trade_type' => 'JSAPI',
          'openid' => $userAuthData->wx_openid
        ]);
        $config = $app->jssdk->sdkConfig($order['prepay_id']);
        DB::commit();
        return $this->setParams($config)->success('获取支付配置成功');
      } else {
        $userOrderData->paySuccess();
        $userOrderData->user_orderable->payCallback($userOrderData);
        DB::commit();
        return $this->setParams(['pay_status' => 'success'])->success('支付成功');
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

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function notify()
  {
    NotifyTemplate::send('通知标题', User::getUserId(), [
      'name' => '万鑫',
      'date' => date('Y-m-d H:i:s'),
      'nickname' => '昵称',
      'user_id' => 1,
      'content' => '哈哈哈',
      'give_number' => 1,
      'id' => 1
    ]);
    return $this->success('发送成功');
  }
}
