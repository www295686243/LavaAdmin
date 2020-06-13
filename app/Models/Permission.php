<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;

/**
 * \App\Models\Permission
 *
 * @property int $id
 * @property string $name 标识
 * @property string $display_name 名称
 * @property int|null $sort 排序
 * @property string $guard_name
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Permission[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Permission|null $parent
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Api\User[] $users
 * @property-read int|null $users_count
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission d()
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Permission newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission permission($permissions)
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends \Spatie\Permission\Models\Permission
{
  use NodeTrait;

  protected $fillable = [
    'name',
    'display_name',
    'sort',
    'guard_name',
    'parent_id'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**
   * @param $guard
   * @return \Illuminate\Support\Collection
   */
  public static function getAllPermissionNames($guard)
  {
    return Permission::where('guard_name', $guard)->pluck('name');
  }

  /**
   * @param $guard
   * @return mixed
   */
  public static function getAllPermissionTree($guard)
  {
    return self::where('guard_name', $guard)->get()->toTree();
  }
}
