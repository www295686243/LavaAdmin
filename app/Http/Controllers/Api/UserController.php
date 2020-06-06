<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Models\SmsCaptcha;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(UserRequest $request)
  {
    $username = $request->input('username');
    $password = $request->input('password');
    $data = (new User())->getToken($username, $password);
    return $this->setParams($data)->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getUserInfo()
  {
    $data = auth()->user();
    return $this->setParams($data)->success();
  }

  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
   * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
   */
  public function sendSmsCaptcha(UserRequest $request)
  {
    $typeName = $request->input('type_name');
    $phone = $request->input('phone');
    $SmsCaptcha = new SmsCaptcha();
    $smsData = $SmsCaptcha->getSmsModel($phone, $typeName);
    if (env('APP_ENV') === 'dev') {
      $smsData->result = array_search('已发送', $SmsCaptcha->RESULT);
      $smsData->created_at = date('Y-m-d H:i:s');
      $smsData->save();
    } else {
      $smsData->sendSmsCaptcha();
    }
    return $this->setParams($smsData)->success('发送成功');
  }

  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function bindPhone(UserRequest $request)
  {
    $phone = $request->input('phone');
    $code = $request->input('code');
    $type_name = $request->input('type_name');

    $user = auth()->user();
    $SmsCaptcha = new SmsCaptcha();

    if ($type_name === array_search('更新手机号', $SmsCaptcha->TYPE)) {
      $SmsCaptcha->isCheckedCurrentPhone($user->phone);
    } else {
      if ($user->phone) {
        return $this->error('您已经绑定过手机号了');
      }
    }

    $phoneUser = User::where('phone', $phone)->first();
    // 如果该手机号已绑定别的账户
    if ($phoneUser && $phoneUser->id !== auth()->id()) {
      return $this->error('该手机号已被其它账户绑定');
    }

    // 验证短信验证码
    $SmsCaptcha->checkSmsCaptcha($phone, $code, $type_name);
    $user->phone = $phone;
    $user->save();
    return $this->success('绑定成功');
  }

  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function verifyPhone(UserRequest $request)
  {
    $phone = $request->input('phone');
    $code = $request->input('code');
    $SmsCaptcha = new SmsCaptcha();
    // 验证短信验证码
    $SmsCaptcha->checkSmsCaptcha($phone, $code, array_search('验证手机号', $SmsCaptcha->TYPE));
    return $this->success('验证成功，请输入新的手机号进行验证');
  }
}
