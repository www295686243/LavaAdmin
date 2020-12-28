<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name 标识
 * @property string $display_name 名称
 * @property int|null $sort 排序
 * @property string $platform admin=后台，api=C端，business=B端
 * @property string|null $guard_name
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|Permission[] $children
 * @property-read int|null $children_count
 * @property-read Permission|null $parent
 * @property-read \Kalnoy\Nestedset\Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\User[] $users
 * @property-read int|null $users_count
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission fixTree($root = null)
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission permission($permissions)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission role($roles, $guard = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereCreatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereDisplayName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereGuardName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereLft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereNodeBetween($values, $boolean = 'and', $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission wherePlatform($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereRgt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereSort($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission whereUpdatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission withDepth(string $as = 'depth')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Permission withoutRoot()
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
    'platform',
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
    return (new Permission())->cacheGetAll()->where('guard_name', $guard)->pluck('name');
  }

  /**
   * @param $platform
   * @return \Kalnoy\Nestedset\Collection
   */
  public static function getAllPermissionTree($platform)
  {
    return self::where('platform', $platform)->get()->toTree();
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function cacheGetAll () {
    return Cache::tags(static::class)->rememberForever($this->getTable(), function () {
      return static::all();
    });
  }
}
