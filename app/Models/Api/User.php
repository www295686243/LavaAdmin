<?php

namespace App\Models\Api;

/**
 * App\Models\Api\User
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Api\User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends \App\Models\User
{
  /**
   * @var string
   */
  protected $guard_name = 'api';
}
