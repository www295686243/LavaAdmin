<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WeChatRequest;
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
    return $this->setParams($userData)->success('微信'.($userData['is_register'] ? '注册' : '登录').'成功');
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function notify()
  {
    return $this->success('发送成功');
  }
}
