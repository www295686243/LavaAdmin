<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WeChatRequest;
use App\Models\Api\User;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\UserAuth;

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
    \Log::info($userData);
    return $this->setParams($userData)->success('微信登陆成功');
  }

  /**
   * @param WeChatRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function pay(WeChatRequest $request)
  {
    $amount = $request->input('amount');
    $app = app('wechat.payment');
    $userData = User::getUserData();
    $userAuthData = $userData->auth;

    $order = $app->order->unify([
      'body' => '查看联系方式',
      'out_trade_no' => time(),
      'total_fee' => $amount * 100,
      'trade_type' => 'JSAPI',
      'openid' => $userAuthData->wx_openid
    ]);
    $config = $app->jssdk->sdkConfig($order['prepay_id']);
    return $this->setParams($config)->success('获取支付配置成功');
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
