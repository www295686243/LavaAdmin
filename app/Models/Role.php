<?php

namespace App\Models;

use App\Models\Traits\ResourceTrait;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name 标识
 * @property string $display_name 名称
 * @property array|null $menu_permissions 栏目权限
 * @property string|null $guard_name
 * @property string $platform admin=后台，api=C端，business=B端
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|Role[] $children
 * @property-read int|null $children_count
 * @property-read Role|null $parent
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\User[] $users
 * @property-read int|null $users_count
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role fixTree($root = null)
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role permission($permissions)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereCreatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereDisplayName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereGuardName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereLft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereMenuPermissions($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereNodeBetween($values, $boolean = 'and', $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role wherePlatform($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereRgt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role whereUpdatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role withDepth(string $as = 'depth')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Role withoutRoot()
 * @mixin \Eloquent
 */
class Role extends \Spatie\Permission\Models\Role
{
  use ResourceTrait, NodeTrait;

  protected $fillable = [
    'name',
    'display_name',
    'menu_permissions',
    'guard_name',
    'platform'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'menu_permissions' => 'array'
  ];
}
