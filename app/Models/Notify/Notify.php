<?php

namespace App\Models\Notify;

use App\Models\Base\Base;
use App\Models\User\User;

class Notify extends Base
{
  protected $fillable = [
    'title',
    'user_id',
    'openid',
    'template_id',
    'host',
    'url',
    'url_params',
    'content',
    'remark',
    'keywords',
    'keyword_names',
    'is_read',
    'is_follow_official_account',
    'is_push_official_account',
    'is_push_message'
  ];

  protected $casts = [
    'keywords' => 'array',
    'keyword_names' => 'array',
    'url_params' => 'array'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * 通知的队列中会走这个方法
   */
  public function pushWeChatNotify()
  {
    if (env('APP_ENV') === 'dev') return false;
    $app = app('wechat.official_account');
    $app->template_message->send([
      'touser' => $this->openid,
      'template_id' => $this->template_id,
      'url' => $this->resolveFullUrl(),
      'data' => array_merge([
        'first' => $this->content,
        'remark' => [$this->remark, '#1775CC']
      ], $this->keywords),
    ]);
  }

  /**
   * @return string
   */
  private function resolveFullUrl () {
    $urlParams = collect($this->url_params ?? [])->put('notify_id', $this->id)->map(function ($value, $key) {
      return $key.'='.$value;
    })->implode('&');
    return $this->host.$this->url.($urlParams ? '?'.$urlParams : '');
  }
}
