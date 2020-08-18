<?php

namespace App\Models\Notify;

use App\Jobs\NotifyQueue;
use App\Models\Base;
use App\Models\User\User;
use Illuminate\Support\Arr;
use Kra8\Snowflake\HasSnowflakePrimary;

class Notify extends Base
{
  use NotifyTemplateTrait, HasSnowflakePrimary;

  protected $fillable = [
    'title',
    'user_id',
    'openid',
    'template_id',
    'url',
    'url_params',
    'content',
    'tips',
    'keywords',
    'keyword_names',
    'is_read',
    'type_name'
  ];

  protected $casts = [
    'keywords' => 'array',
    'keyword_names' => 'array',
    'url_params' => 'array'
  ];

  /**
   * @param $method
   * @param $user
   * @param array $params
   */
  public function send($method, $user, $params = [])
  {
    $data = $this->getData($method, $user, $params);
    $data['type_name'] = 'all';
    $this->pushNotify($data);
  }

  /**
   * @param $method
   * @param $user
   * @param array $params
   */
  public function sendWeChat($method, $user, $params = [])
  {
    $data = $this->getData($method, $user, $params);
    $data['type_name'] = 'wechat';
    $this->pushNotify($data);
  }

  /**
   * @param $method
   * @param $user
   * @param array $params
   */
  public function sendMessage($method, $user, $params = [])
  {
    $data = $this->getData($method, $user, $params);
    $data['type_name'] = 'message';
    $this->pushNotify($data);
  }

  /**
   * @param $method
   * @param $user
   * @param array $params
   * @return mixed
   */
  private function getData($method, $user, $params = []) {
    if (is_numeric($user)) {
      $userData = User::findOrFail($user);
    } else {
      $userData = $user;
    }
    $data = $this->$method($userData, $params);
    $data['openid'] = optional($userData->auth)->wx_openid;
    $data['is_follow_official_account'] = $userData->is_follow_official_account;
    return $data;
  }

  /**
   * @param $data
   */
  private function pushNotify($data)
  {
    $notify = self::create(Arr::only($data, Notify::getFillFields()));
    if ($notify->type_name !== 'message' && $notify->openid && $data['is_follow_official_account']) {
      NotifyQueue::dispatch($notify);
    }
  }

  public function pushWeChatNotify()
  {
    $app = app('wechat.official_account');
    $app->template_message->send([
      'touser' => $this->openid,
      'template_id' => $this->template_id,
      'url' => $this->resolveFullUrl(),
      'data' => array_merge([
        'first' => $this->content,
        'remark' => [$this->tips, '#1775CC']
      ], $this->keywords),
    ]);
  }

  /**
   * @return string
   */
  private function resolveFullUrl () {
    $urlParams = collect($this->url_params ?? [])->map(function ($value, $key) {
      return $key.'='.$value;
    })->implode('&');
    return env('APP_M_URL').$this->url.($urlParams ? '?'.$urlParams : '');
  }
}
