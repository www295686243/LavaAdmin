<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/8/17
 * Time: 14:26
 */

namespace App\Models\Notify;

trait NotifyTemplateTrait
{
  protected $TEMPLATE = [
    // 个人/企业认证成功
    'member_auth_success' => '-JrKtqryqqHGkwPmLxRGsUh-Utcn4nz1uJFJX0zCar0',
    // 个人/企业认证失败
    'member_auth_fail' => '2bOJ-heIY_2IQc8M968w7BkA3cb0L6HZXD0qUD5UCPA',
    // 信息发布待审核通知
    'info_send_check_pending' => 'f8stXVSnivzceRtjq5oSqveoRmrTUz4-c4lgFKWqbXM',
    // 发布信息审核结果通知
    'info_check_result' => 'R2HkhhoO9sul3aR6aOqJldE3incm1dz_wXJIsdMeDdQ',
    // 发布信息过期通知
    'info_expire' => 'CYqMq0rj4Vc7c28JGJZvbK83Dct8Zg5-fvQ4Ztp66-Q',
    // 推送招聘消息
    'push_job_info' => '1h1a7y7pLYmKVYwhpXHvz4YQbXsnFgVdxDYvqIfMaro',
    // 推送求职消息
    'push_resume_info' => 'GqdTmbzbOJGpO0G30Kw_OQi7b1cnHk8T9Z_iIFIDG-A',
    // 给运营管理员推送审核消息
    'admin_check_info' => 'vmsl5BmY3Dk1pXHSrIbbJiLSuMFTCAmVBe99Jn9a6Zo',
    // 用户投诉后给管理员推送消息
    'admin_complaint_info' => 'WouafHsnIV6HfqZvT5KZHlEK7Fzi38DeCCEZCQ0AQ6Y',
    // 用户投诉成功提醒
    'push_complaint_success' => 'vZksz3lMMfsKTDOuAV19dmvUDvM5_wUTwzYCLcDZFPw',
    // 推送给用户投诉结果
    'push_complaint_result' => 'BPTCSvr53VLsucbFd6z4CZ3VJkXlQU4LHMZd4OP_FGQ',
    // 互助券赠送成功通知
    'coupon_give_success' => 'sQUHqkEfnxiIKwuFXPnh8smOAD8lm6dHPH8aDA6I-pw',
    // 通用券出售成功通知
    'coupon_sell_success' => 'FbzwkSKeRTH7cOpBWDS_CxGzscxw1dP-HaRG2MHLbtQ',
    // 交易市场优惠券到期
    'coupon_market_expired' => 'yShlcXGqSl-jN7H61OopQlnqHdA7FAY4ylQPwIyjfh8'
  ];

  // 个人认证审核成功
  protected function personalAuthSuccess($userData, $params)
  {
    return [
      'title' => '个人认证通过通知',
      'user_id' => $userData->id,
      'template_id' => $this->TEMPLATE['member_auth_success'],
      'content' => '亲爱的'.$userData->nickname.'，您好，您的个人认证已通过！',
      'tips' => '您的个人认证申请已通过，进入【我的-设置-清除缓存】可更新状态！',
      'url' => '/user',
      'url_params' => [],
      'full_url' => env('APP_M_URL').'/user',
      'keywords' => [
        'keyword1' => $params['name'],
        'keyword2' => date('Y-m-d H:i:s')
      ],
      'keyword_names' => [
        'keyword1' => '姓名',
        'keyword2' => '日期'
      ]
    ];
  }
}