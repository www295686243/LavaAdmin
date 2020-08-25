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
    'url',
    'url_params',
    'keyword_names'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**
   * @param $title
   * @param $user
   * @param $params
   */
  public static function send($title, $user, $params)
  {
    $notifyTemplateData = (new self())->getData($title);
    $notifyTemplateData->createNotify($user, $params);
  }

  /**
   * @param $title
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
   */
  private function getData($title)
  {
    return self::where('title', $title)->firstOrFail();
  }

  /**
   * @param $user
   * @param $params
   * @param string $channel
   */
  public function createNotify($user, $params, $channel = 'all')
  {
    $data = [];
    if (is_numeric($user)) {
      $userData = User::findOrFail($user);
    } else {
      $userData = $user;
    }
    $data['title'] = $this->title;
    $data['user_id'] = $userData->id;
    $data['openid'] = optional($userData->auth)->wx_openid;
    $data['template_id'] = $this->template_id;
    $data['url'] = $this->url;
    $data['url_params'] = $this->resolveUrlParams($this->url_params, $params);
    $data['content'] = $this->resolveContent($this->content, $params);
    $data['remark'] = $this->resolveContent($this->remark, $params);
    $keywordParams = $this->resolveKeywords($this->keyword_names, $params);
    $data['keywords'] = $keywordParams['keywords'];
    $data['keyword_names'] = $keywordParams['keyword_names'];
    $data['is_follow_official_account'] = $userData->is_follow_official_account;
    $data['channel'] = $channel;
    $this->pushNotify($data);
  }

  /**
   * @param $data
   */
  private function pushNotify($data)
  {
    $notify = Notify::create(Arr::only($data, Notify::getFillFields()));
    if ($notify->channel !== 'message' && $notify->openid && $notify->is_follow_official_account) {
      NotifyQueue::dispatch($notify);
    }
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
}
