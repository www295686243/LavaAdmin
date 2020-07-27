<?php

namespace App\Models\Admin;

use App\Models\AdminMenu;

/**
 * \App\Models\Admin\User
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User exceptRoot()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\User whereUsername($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User searchQuery()
 */
class User extends \App\Models\User
{
  /**
   * @var string
   */
  protected $guard_name = 'admin';

  /**
   * @return \Illuminate\Support\Collection
   */
  public function getMenuPermissions()
  {
    $query = AdminMenu::query();
    if (!$this->hasRole('root')) {
      $menu_ids = $this->roles->pluck('menu_permissions')->flatten()->unique();
      $query->whereIn('id', $menu_ids);
    }
    return $query
      ->orderBy('sort', 'asc')
      ->orderBy('id', 'asc')
      ->get();
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function getInterfacePermissions()
  {
    return $this->getAllPermissions()->pluck('name');
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeExceptRoot($query)
  {
    return $query->when(!self::hasRoot(), function ($query) {
      $root_ids = self::role('root')->pluck('id');
      return $query->whereNotIn('id', $root_ids);
    });
  }
}
