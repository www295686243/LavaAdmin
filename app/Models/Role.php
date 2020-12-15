<?php

namespace App\Models;

use App\Models\Traits\IdToStrTrait;
use App\Models\Traits\ResourceTrait;
use App\Models\User\UserAssignPermission;
use Kra8\Snowflake\HasSnowflakePrimary;

/**
 * \App\Models\Role
 *
 * @property int $id
 * @property string $name 标识
 * @property string $display_name 名称
 * @property array|null $menu_permissions 栏目权限
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereMenuPermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends \Spatie\Permission\Models\Role
{
  use ResourceTrait;

  protected $fillable = [
    'name',
    'display_name',
    'menu_permissions',
    'assign_menu',
    'guard_name',
    'platform'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'menu_permissions' => 'array',
    'assign_menu' => 'array'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function assign_permissions()
  {
    return $this->hasMany(UserAssignPermission::class);
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function modelGetAssignPermissions()
  {
    return $this->assign_permissions()->pluck('permission_id');
  }
}
