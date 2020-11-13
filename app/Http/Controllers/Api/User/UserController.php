<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Models\Api\User;
use App\Models\SmsCaptcha;
use App\Models\User\UserBill;
use App\Models\User\UserEnterprise;
use App\Models\User\UserPersonal;
use App\Models\User\UserWallet;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  /**
   * 账户密码登陆
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(UserRequest $request)
  {
    $username = $request->input('username');
    $password = $request->input('password');
    $data = (new User())->getToken($username, $password);
    return $this->setParams($data)->success('登陆成功');
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function todayFirstLogin()
  {
    return $this->getUserInfo('每日登陆');
  }

  /**
   * @param string $message
   * @return \Illuminate\Http\JsonResponse
   */
  public function getUserInfo($message = '')
  {
    $userData = User::getUserData();
    $userData->getInterfacePermissions();
    $userData->roles()->get(['name', 'display_name'])->makeHidden('pivot');
    if ($message === '每日登陆') {
      $userData->last_login_at = date('Y-m-d H:i:s');
      $userData->save();
    }
    return $this->setParams($userData)->success($message);
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getBaseUserInfo()
  {
    return $this->setParams(User::getUserData())->success();
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
    return $this->success('发送成功');
  }

  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function bindPhone(UserRequest $request)
  {
    $phone = $request->input('phone');
    $code = $request->input('code');

    $userData = User::getUserData();
    $SmsCaptcha = new SmsCaptcha();
    if ($userData->phone) {
      return $this->error('您已经绑定过手机号了');
    }
    // 验证这个手机号是否绑定过
    (new User())->checkIsBindPhone($phone);
    // 验证短信验证码
    $SmsCaptcha->checkSmsCaptcha($phone, $code, array_search('绑定手机号', $SmsCaptcha->TYPE));
    $userData->phone = $phone;
    if (!$userData->register_at) {
      $userData->register_at = date('Y-m-d H:i:s');
    }
    $userData->save();
    return $this->success('绑定成功');
  }

  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function updatePhone(UserRequest $request)
  {
    $phone = $request->input('phone');
    $code = $request->input('code');
    $userData = User::getUserData();
    $SmsCaptcha = new SmsCaptcha();
    // 判断是否验证过修改前的手机号
    $SmsCaptcha->isCheckedCurrentPhone($userData->phone);
    // 验证这个手机号是否绑定过
    (new User())->checkIsBindPhone($phone);
    // 验证短信验证码
    $SmsCaptcha->checkSmsCaptcha($phone, $code, array_search('更新手机号', $SmsCaptcha->TYPE));
    $userData->phone = $phone;
    $userData->save();
    return $this->success('修改成功');
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

  /**
   * 我的钱包
   * @return \Illuminate\Http\JsonResponse
   */
  public function getWallet()
  {
    $data = UserWallet::where('user_id', User::getUserId())->firstOrFail();
    return $this->setParams($data)->success();
  }

  /**
   * 我的账单
   * @return \Illuminate\Http\JsonResponse
   */
  public function getBill()
  {
    $data = UserBill::where('user_id', User::getUserId())
      ->orderByDesc('id')
      ->simplePagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function setInviteUser(UserRequest $request)
  {
    $invite_user_id = $request->input('iu');
    $userData = User::getUserData();
    if (
      $invite_user_id &&
      !$userData->invite_user_id &&
      $userData->created_at > date('Y-m-d 00:00:00') &&
      $invite_user_id !== $userData->invite_user_id
    ) {
      $userData->invite_user_id = $invite_user_id;
      $userData->save();
    }
    return $this->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getInviteList()
  {
    $invite_user_id = User::getUserId();
    $data = User::select(['id', 'username', 'nickname', 'register_at', 'created_at'])
      ->where('invite_user_id', $invite_user_id)
      ->orderByDesc('id')
      ->simplePaginate();
    return $this->setParams($data)->success();
  }

  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getInviteUser(UserRequest $request)
  {
    $invite_user_id = $request->input('iu');
    $inviteUserData = User::getUserData($invite_user_id);
    return $this->setParams(['nickname' => $inviteUserData->nickname])->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function checkOfficialAccounts()
  {
    if (env('APP_ENV') === 'dev') {
      return $this->success();
    }
    $userData = User::getUserData();
    if ($userData->register_at < date('Y-m-d H:i:s', time() - (3600 * 24 * 7))) {
      return $userData->is_follow_official_account ? $this->success() : $this->error();
    } else {
      return $this->success();
    }
  }

  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function baseInfoUpdate(UserRequest $request)
  {
    $input = $request->only(['role', 'name', 'company', 'industry', 'industry_attr', 'position_attr', 'city']);
    $userData = User::getUserData();

    DB::beginTransaction();
    try {
      if ($input['role'] === 'Enterprise Member') {
        $userData->assignRole($input['role']);
        $userData->current_role = $input['role'];
        UserEnterprise::updateInfo($request->only(UserEnterprise::getUpdateFillable()));
      } else if ($input['role'] === 'Personal Member') {
        $userData->assignRole($input['role']);
        $userData->current_role = $input['role'];
        UserPersonal::updateInfo($request->only(UserPersonal::getUpdateFillable()));
      }
      $userData->save();
      DB::commit();
      return $this->success();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      return $this->error();
    }
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function isFreeForLimitedTime()
  {
    $userData = User::getUserData();
    $exists = $userData->isFreeForLimitedTime();
    return $exists ? $this->success() : $this->error();
  }

  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function switchRole(UserRequest $request)
  {
    $role = $request->input('role');
    $userData = User::getUserData();
    if ($userData->hasRole($role)) {
      $userData->current_role = $role;
      $userData->save();
      return $this->setParams($userData)->success();
    } else {
      return $this->error();
    }
  }
}
