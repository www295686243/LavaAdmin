<?php

namespace App\Models\Notify;

use App\Models\Base\Base;
use App\Models\User\User;

/**
 * App\Models\Notify\Notify
 *
 * @property int|null|string $id
 * @property string $title 发送类型标题
 * @property string $user_id 发送人
 * @property string|null $openid 微信用户唯一id
 * @property string $template_id 模板id
 * @property string $host 域名,格式：https://m.yuancaowang.com
 * @property string $url url
 * @property array|null $url_params url参数
 * @property string $content 信息内容
 * @property string $remark 备注
 * @property array|null $keywords 参数
 * @property array|null $keyword_names 参数名
 * @property int $is_read 是否已阅读
 * @property int $is_follow_official_account 是否关注公众号
 * @property int $is_push_official_account 是否推送微信公众号
 * @property int $is_push_message 是否推送站内信
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notify newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notify newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|Notify query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereIsFollowOfficialAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereIsPushMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereIsPushOfficialAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereKeywordNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereUrlParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notify whereUserId($value)
 * @mixin \Eloquent
 */
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
    $urlParams = collect($this->url_params ?? [])->put('_notify_id', $this->id)->map(function ($value, $key) {
      return $key.'='.$value;
    })->implode('&');
    return $this->host.'/#'.$this->url.($urlParams ? '?'.$urlParams : '');
  }
}
