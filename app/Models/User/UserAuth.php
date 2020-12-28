<?php

namespace App\Models\User;

use App\Models\Base\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\User\UserAuth
 *
 * @property int|null|string $id
 * @property string $user_id 关联的用户id
 * @property string|null $wx_openid 微信用户唯一id
 * @property string|null $wx_unionid 微信跨平台登录id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAuth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAuth newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserAuth onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAuth query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAuth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAuth whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAuth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAuth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAuth whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAuth whereWxOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAuth whereWxUnionid($value)
 * @method static \Illuminate\Database\Query\Builder|UserAuth withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserAuth withoutTrashed()
 * @mixin \Eloquent
 */
class UserAuth extends Base
{
  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'wx_openid',
    'wx_unionid'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  /**
   * @return \Illuminate\Http\JsonResponse|array
   */
  public function getWeChatAuthInfo()
  {
    $app = app('wechat.official_account');
    try {
      $user = $app->oauth->user();
      $data = $user->original;
      $userWechatData = $app->user->get($data['openid']);
      $data['subscribe'] = isset($userWechatData['subscribe']) ? $userWechatData['subscribe'] : 0;
      $data['subscribe_scene'] = isset($userWechatData['subscribe_scene']) ? $userWechatData['subscribe_scene'] : '';
      return $data;
    } catch (\Exception $e) {
      $code = $this->getErrorCode($e->getMessage());
      if (in_array($code, [40029, 40163, 42001, 42002, 42003, 41008])) {
        return $this->setStatus('re-auth')->error('授权失败，请再试一次');
      } else {
        \Log::info($e->getMessage());
        return $this->error('授权失败，请联系客服');
      }
    }
  }

  /**
   * @param $authInfo
   * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
   * @throws \Throwable
   */
  public function getUserData($authInfo)
  {
    // 后面可能考虑优化这段代码
    $unionid = isset($authInfo['unionid']) ? $authInfo['unionid'] : '';
    $openid = isset($authInfo['openid']) ? $authInfo['openid'] : '';

    $authData = null;
    if ($unionid) {
      $authData = self::where('wx_unionid', $unionid)->first();
    }
    if (!$authData && $openid) {
      $authData = self::where('wx_openid', $openid)->first();
      if ($authData) {
        $authData->wx_unionid = $unionid;
        $authData->save();
      }
    }
    if (!$authData) {
      $userData = User::createUser([
        'nickname' => $authInfo['nickname']
      ]);
      $userData->auth()->create([
        'wx_openid' => $openid,
        'wx_unionid' => $unionid
      ]);
      $is_register = true;
    } else {
      $userData = User::findOrFail($authData->user_id);
      $is_register = false;
    }
    $headimgurl = isset($authInfo['headimgurl']) ? $authInfo['headimgurl'] : '';
    $userData->head_url = str_replace('http:', 'https:', $headimgurl);
    $userData->is_follow_official_account = isset($authInfo['subscribe']) ? $authInfo['subscribe'] : 0;
    $userData->follow_official_account_scene = $authInfo['subscribe_scene'];

    $plainTextToken = $userData->createToken('token')->plainTextToken;
    [$id, $token] = explode('|', $plainTextToken, 2);
    $userData->api_token = $token;
    $userData->save();

    $userData->checkFollowWeChatFinishTask();
    return [
      'is_register' => $is_register,
      'api_token' => $token,
      'user_id' => $userData->id
    ];
  }

  /**
   * @param $message
   * @return number
   */
  private function getErrorCode($message)
  {
    $message = str_replace('Authorize Failed: ', '', $message);
    $arr = json_decode($message, true);
    return $arr['errcode'];
  }
}
