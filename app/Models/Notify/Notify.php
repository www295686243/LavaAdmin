<?php

namespace App\Models\Notify;

use App\Models\Base;
use App\Models\User\User;
use Kra8\Snowflake\HasSnowflakePrimary;

class Notify extends Base
{
  use HasSnowflakePrimary;

  protected $fillable = [
    'title',
    'user_id',
    'openid',
    'template_id',
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
    $urlParams = collect($this->url_params ?? [])->map(function ($value, $key) {
      return $key.'='.$value;
    })->implode('&');
    return env('APP_M_URL').$this->url.($urlParams ? '?'.$urlParams : '');
  }
}
