<?php

namespace App\Models\Notify;

use App\Jobs\NotifyQueue;
use App\Models\Base\Base;
use App\Models\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * App\Models\Notify\NotifyTemplate
 *
 * @property int|null|string $id
 * @property string $template_id 微信模板id
 * @property string $title 通知标题
 * @property string $content 通知内容
 * @property string $remark 通知备注
 * @property string $host 域名,格式：https://m.yuancaowang.com
 * @property string $url 跳转地址，格式：/xxx
 * @property string|null $url_params 地址参数
 * @property string|null $keyword_names 字段名称
 * @property int $queue 优先级
 * @property int $is_push_official_account 是否推送微信公众号
 * @property int $is_push_message 是否推送站内信
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notify\NotifyUser[] $notify_user
 * @property-read int|null $notify_user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate newQuery()
 * @method static \Illuminate\Database\Query\Builder|NotifyTemplate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereIsPushMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereIsPushOfficialAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereKeywordNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereQueue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTemplate whereUrlParams($value)
 * @method static \Illuminate\Database\Query\Builder|NotifyTemplate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|NotifyTemplate withoutTrashed()
 * @mixin \Eloquent
 */
class NotifyTemplate extends Base
{
  use SoftDeletes;

  protected $fillable = [
    'id',
    'title',
    'template_id',
    'content',
    'remark',
    'host',
    'queue',
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
   * @param $_title
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
    $data['template_id'] = $this->template_id;
    $data['host'] = $this->host;
    $data['url'] = $this->url;
    $data['url_params'] = $this->resolveUrlParams($this->url_params, $params);
    $data['content'] = $this->resolveContent($this->content, $params);
    $data['remark'] = $this->resolveContent($this->remark, $params);
    $keywordParams = $this->resolveKeywords($this->keyword_names, $params);
    $data['keywords'] = $keywordParams['keywords'];
    $data['keyword_names'] = $keywordParams['keyword_names'];
    $data['is_push_official_account'] = $this->is_push_official_account;
    $data['is_push_message'] = $this->is_push_message;
    if (env('APP_ENV') === 'dev') {
      $data['openid'] = '开发环境模拟openid';
      $data['is_follow_official_account'] = 1;
    } else {
      $data['openid'] = optional($userData->auth)->wx_openid;
      $data['is_follow_official_account'] = $userData->is_follow_official_account;
    }
    $this->pushNotify($data);
  }

  /**
   * @param $data
   */
  private function pushNotify($data)
  {
    $notify = Notify::create(Arr::only($data, Notify::getFillFields()));
    if ($notify->is_push_official_account && $notify->openid && $notify->is_follow_official_account) {
      NotifyQueue::dispatch($notify)->onQueue($this->queue);
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
   * @param $id
   * @param $title
   * @param $user
   * @param $params
   */
  public static function sendGiveCoupon($id, $title, $user, $params)
  {
    $expiry_day = 30;
    $start_at = date('Y-m-d 00:00:00');
    $end_at = date('Y-m-d 05:00:00', strtotime('+'.$expiry_day.' day'));
    static::send($id, $title, $user, array_merge([
      'expiry_day' => $expiry_day.'天',
      'start_at' => $start_at,
      'end_at' => $end_at,
    ], $params));
  }
}
