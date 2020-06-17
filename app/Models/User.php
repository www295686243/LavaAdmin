<?php

namespace App\Models;

use App\Models\Traits\ResourceTrait;
use App\Services\SearchQueryService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Kra8\Snowflake\HasSnowflakePrimary;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * \App\Models\User
 *
 * @property int $id
 * @property string|null $nickname 昵称
 * @property string|null $username 用户名
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $email_verified_at
 * @property string $password
 * @property float $money 金额
 * @property string|null $api_token
 * @property string|null $remember_token
 * @property int $is_admin 是否管理员
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
  use Notifiable, HasSnowflakePrimary, HasRoles, HasApiTokens, ResourceTrait, SoftDeletes;

  /**
   * @var array
   */
  protected $fillable = [
    'username',
    'nickname',
    'email',
    'phone',
    'password',
    'money',
    'is_admin',
    'api_token'
  ];

  /**
   * @var array
   */
  protected $hidden = [
    'updated_at',
    'remember_token',
    'password',
    'deleted_at',
    'email_verified_at'
  ];

  /**
   * @param \DateTimeInterface $date
   * @return string
   */
  protected function serializeDate(\DateTimeInterface $date)
  {
    return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
  }

  /**
   * @param $value
   */
  public function setPasswordAttribute($value)
  {
    if ($value) {
      $this->attributes['password'] = Hash::make($value);
    }
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSearchQuery($query)
  {
    return (new SearchQueryService())->searchQuery($query);
  }

  /**
   * @param $username
   * @param $password
   * @param bool $isAdmin
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
   */
  public function getToken($username, $password, $isAdmin = false)
  {
    $userData = self::where('username', $username)->first();
    if ($isAdmin && !$userData->is_admin) {
      $this->error('用户名或密码错误!');
    }
    if (!$userData || !Hash::check($password, $userData->password)) {
      $this->error('用户名或密码错误!');
    }
    $plainTextToken = $userData->createToken('token')->plainTextToken;
    [$id, $token] = explode('|', $plainTextToken, 2);
    $userData->api_token = $token;
    $userData->save();
    return $userData;
  }

  /**
   * @return \Illuminate\Contracts\Auth\Authenticatable|static|null
   */
  public static function getUserData()
  {
    return auth((new self())->guard_name)->user();
  }

  /**
   * @return int|null|string
   */
  public static function getUserId()
  {
    return auth((new self())->guard_name)->id();
  }

  /**
   * @return bool
   */
  public static function hasRoot()
  {
    $userData = static::getUserData();
    return $userData->hasRole('root');
  }
}
