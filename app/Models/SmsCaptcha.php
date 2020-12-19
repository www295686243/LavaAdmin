<?php

namespace App\Models;

use App\Models\Base\Base;
use App\Models\User\User;
use Illuminate\Support\Carbon;
use Overtrue\EasySms\EasySms;

/**
 * \App\Models\SmsCaptcha
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property int $code
 * @property string $type_name 验证码类型
 * @property int $status 状态(0未验证，1已验证)
 * @property int $result 发送结果(0未发送，1已发送, 2发送失败)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCaptcha whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base pagination()
 */
class SmsCaptcha extends Base
{
  protected $fillable = [
    'user_id',
    'phone',
    'code',
    'type_name',
    'status',
    'result'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public $TYPE = [
    'bind-phone' => '绑定手机号',
    'update-phone' => '更新手机号',
    'verify-phone' => '验证手机号'
  ];

  public $STATUS = [
    0 => '未验证',
    1 => '已验证'
  ];

  public $RESULT = [
    0 => '未发送',
    1 => '已发送',
    2 => '发送失败'
  ];

  /**
   * 有效分钟数
   * @var int
   */
  protected $valid_time = 5;

  /**
   * 发送间隔分钟数
   * @var int
   */
  protected $interval_time = 1;

  /**
   * 发送短信验证码
   * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
   * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
   */
  public function sendSmsCaptcha()
  {
    $config = config('easysms');
    $easySms = new EasySms($config);
    $res = $easySms->send($this->phone, [
      'template' => 'SMS_181865342',
      'data' => [
        'code' => $this->code
      ],
    ]);
    if ($res['aliyun']['status'] === 'success') {
      $this->created_at = date('Y-m-d H:i:s');
      $this->result = array_search('已发送', $this->RESULT);
      $this->save();
    } else {
      $this->result = array_search('发送失败', $this->RESULT);
      $this->save();
      $this->error('发送失败');
    }
  }

  /**
   * @return \Carbon\Carbon
   */
  private function getValidTime()
  {
    return Carbon::now()->subMinutes($this->valid_time);
  }

  /**
   * @return \Carbon\Carbon
   */
  private function getIntervalTime () {
    return Carbon::now()->subMinutes($this->interval_time);
  }

  /**
   * @param $phone
   * @param $typeName
   * @return SmsCaptcha|\Illuminate\Database\Eloquent\Model
   */
  private function createSmsModel($phone, $typeName)
  {
    return $this->create([
      'user_id' => auth()->id(),
      'phone' => $phone,
      'code' => rand(1000, 9999),
      'type_name' => $typeName
    ]);
  }

  /**
   * @param $phone
   * @param $typeName
   * @return SmsCaptcha|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
   */
  public function getSmsModel($phone, $typeName)
  {
    $sms = $this->where('user_id', User::getUserId())
      ->where('phone', $phone)
      ->where('created_at', '>', $this->getValidTime())
      ->where('type_name', $typeName)
      ->orderByDesc('id')
      ->first();
    if ($sms) {
      if ($sms->created_at > $this->getIntervalTime()) {
        $this->error('您的操作频率太快，请稍后再试');
      }
      if ($sms->status === array_search('已验证', $this->STATUS)) {
        $sms = null;
      }
    }
    if (!$sms) {
      $sms = $this->createSmsModel($phone, $typeName);
    }
    return $sms;
  }

  /**
   * @param $phone
   * @param $code
   * @param $typeName
   */
  public function checkSmsCaptcha($phone, $code, $typeName)
  {
    $sms = $this->query()
      ->where('user_id', auth()->id())
      ->where('phone', $phone)
      ->where('code', $code)
      ->where('type_name', $typeName)
      ->first();
    if (!$sms) {
      $this->error('验证码输入错误，请重新输入');
    }
    if ($sms->created_at < $this->getValidTime()) {
      $this->error('验证码已过期，请重新发送');
    }
    if ($sms->status === array_search('已验证', $this->STATUS)) {
      $this->error('该验证码已验证过了');
    }
    if ($sms->result !== array_search('已发送', $this->RESULT)) {
      $this->error('该验证码发送异常，请重新发送');
    }
    $sms->status = array_search('已验证', $this->STATUS);
    $sms->save();
  }

  /**
   * 一般用于在修改绑定的手机号前判断是否验证过当前手机号
   * @param $phone
   */
  public function isCheckedCurrentPhone ($phone) {
    $sms = $this
      ->where('user_id', auth()->id())
      ->where('phone', $phone)
      ->where('type_name', array_search('验证手机号', $this->TYPE))
      ->where('status', array_search('已验证', $this->STATUS))
      ->orderByDesc('id')
      ->first();
    if (!$sms) {
      $this->error('请先验证当前手机号');
    }
    if ($sms->created_at < $this->getValidTime()) {
      $this->error('当前手机号验证超时，请重新验证');
    }
  }
}
