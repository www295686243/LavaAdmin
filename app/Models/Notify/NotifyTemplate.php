<?php

namespace App\Models\Notify;

use App\Jobs\NotifyQueue;
use App\Models\Base;
use App\Models\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class NotifyTemplate extends Base
{
  use SoftDeletes;

  protected $fillable = [
    'title',
    'template_id',
    'content',
    'remark',
    'host',
    'url',
    'url_params',
    'keyword_names',
    'is_push_official_account',
    'is_push_message'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public static function bootHasSnowflakePrimary() {}

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function notify_user()
  {
    return $this->hasMany(NotifyUser::class);
  }

  /**
   * @param $id
   * @param $_title
   * @param $user
   * @param $params
   */
  public static function send($id, $_title, $user, $params)
  {
    /**
     * @var self $notifyTemplateData
     */
    $notifyTemplateData = (new self())->getData($id);
    $notifyTemplateData->createNotify($user, $params);
    $notifyTemplateData->pushAdminNotify($params);
  }

  /**
   * @param $id
   * @param $title
   * @param $params
   */
  public static function sendAdmin($id, $_title, $params)
  {
    /**
     * @var self $notifyTemplateData
     */
    $notifyTemplateData = (new self())->getData($id);
    $notifyTemplateData->pushAdminNotify($params);
  }

  /**
   * @param $id
   * @return NotifyTemplate|NotifyTemplate[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
   */
  private function getData($id)
  {
    return self::findOrFail($id);
  }

  /**
   * 这个方法实例化对象后会用到，不会直接调用
   * @param $user
   * @param $params
   */
  public function createNotify($user, $params)
  {
    $data = [];
    if (is_numeric($user)) {
      $userData = User::findOrFail($user);
    } else {
      $userData = $user;
    }
    $data['title'] = $this->resolveContent($this->title, $params);
    $data['user_id'] = $userData->id;
    $data['openid'] = optional($userData->auth)->wx_openid;
    $data['template_id'] = $this->template_id;
    $data['host'] = $this->host;
    $data['url'] = $this->url;
    $data['url_params'] = $this->resolveUrlParams($this->url_params, $params);
    $data['content'] = $this->resolveContent($this->content, $params);
    $data['remark'] = $this->resolveContent($this->remark, $params);
    $keywordParams = $this->resolveKeywords($this->keyword_names, $params);
    $data['keywords'] = $keywordParams['keywords'];
    $data['keyword_names'] = $keywordParams['keyword_names'];
    $data['is_follow_official_account'] = $userData->is_follow_official_account;
    $data['is_push_official_account'] = $this->is_push_official_account;
    $data['is_push_message'] = $this->is_push_message;
    $this->pushNotify($data);
  }

  /**
   * @param $data
   */
  private function pushNotify($data)
  {
    $notify = Notify::create(Arr::only($data, Notify::getFillFields()));
    if ($notify->is_push_official_account && $notify->openid && $notify->is_follow_official_account) {
      NotifyQueue::dispatch($notify);
    }
  }

  /**
   * @param $params
   */
  private function pushAdminNotify($params)
  {
    $this->notify_user()->get()->each(function ($user) use ($params) {
      $this->createNotify($user->user_id, $params);
    });
  }

  /**
   * @param $url_params
   * @param $params
   * @return array
   */
  private function resolveUrlParams($url_params, $params)
  {
    $arr = [];
    if ($url_params) {
      $urlParamsArr = explode(',', $url_params);
      foreach ($urlParamsArr as $key) {
        $arr[$key] = $params[$key];
      }
    }
    return $arr;
  }

  /**
   * @param $keyword_names
   * @param $params
   * @return array
   */
  private function resolveKeywords($keyword_names, $params)
  {
    $keywords = [];
    $keywordNames = [];
    if ($keyword_names) {
      $keywordNamesArr = explode('|', $keyword_names);
      foreach ($keywordNamesArr as $index => $item) {
        list($key, $label) = explode(',', $item);
        $keywords['keyword'.($index + 1)] = $params[$key];
        $keywordNames['keyword'.($index + 1)] = $label;
      }
    }
    return [
      'keywords' => $keywords,
      'keyword_names' => $keywordNames
    ];
  }

  /**
   * @param $content
   * @param $params
   * @return mixed
   */
  private function resolveContent($content, $params) {
    $result = null;
    preg_match_all('/(?<={)[^}]+/', $content, $result);
    if (count($result[0]) > 0) {
      foreach ($result[0] as $key) {
        $content = str_replace('{'.$key.'}', $params[$key], $content);
      }
    }
    return $content;
  }

  /**
   * @param $params
   */
  public static function sendGiveCoupon($params)
  {
    $start_at = date('Y-m-d 00:00:00');
    $end_at = date('Y-m-d 05:00:00', strtotime('+'.$params['expiry_day'].' day'));
    static::send(36, '信息提供互助券赠送成功通知', $params['user_id'], [
      'push_text' => $params['pushText'],
      'expiry_day' => $params['expiry_day'].'天',
      'start_at' => $start_at,
      'end_at' => $end_at
    ]);
  }
}
