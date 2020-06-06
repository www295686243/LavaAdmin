<?php

namespace App\Models;

use App\Models\Traits\ResourceTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Exceptions\HttpResponseException;
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
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 */
class User extends Authenticatable
{
  use Notifiable, HasSnowflakePrimary, HasRoles, HasApiTokens, ResourceTrait;

  /**
   * @var string
   */
  protected $guard_name = 'api';

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
    'is_admin'
  ];

  /**
   * @var array
   */
  protected $hidden = [
    'updated_at',
    'remember_token',
    'password'
  ];

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
   * @param $username
   * @param $password
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
   */
  public function getToken($username, $password)
  {
    $userData = self::where('username', $username)->first();
    if (!$userData || !Hash::check($password, $userData->password)) {
      $this->error('用户名或密码错误!');
    }
    $plainTextToken = $userData->createToken('token')->plainTextToken;
    [$id, $token] = explode('|', $plainTextToken, 2);
    $userData->token = $token;
    return $userData;
  }
}
