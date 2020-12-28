<?php

namespace App\Models;

use App\Models\Base\Base;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Models\AdminMenu
 *
 * @property int|null|string $id
 * @property string $display_name 菜单名称
 * @property string|null $desc 菜单描述
 * @property string|null $route 路由
 * @property string|null $icon icon图标
 * @property array|null $params 所需参数(一般二级以上的菜单会用到)
 * @property array|null $default_params 默认参数
 * @property int|null $sort 排序
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|AdminMenu[] $children
 * @property-read int|null $children_count
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @property-read AdminMenu|null $parent
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu fixTree($root = null)
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Base listQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Base pagination()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Base searchModel($typeField, $model = '')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Base searchQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Base simplePagination()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereCreatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereDefaultParams($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereDesc($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereDisplayName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereIcon($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereLft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereNodeBetween($values, $boolean = 'and', $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereParams($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereRgt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereRoute($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereSort($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu whereUpdatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu withDepth(string $as = 'depth')
 * @method static \Kalnoy\Nestedset\QueryBuilder|AdminMenu withoutRoot()
 * @mixin \Eloquent
 */
class AdminMenu extends Base
{
  use NodeTrait;

  protected $fillable = [
    'display_name',
    'desc',
    'route',
    'icon',
    'params',
    'default_params',
    'sort'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    '_lft',
    '_rgt'
  ];

  protected $casts = [
    'params' => 'array',
    'default_params' => 'array'
  ];

  public static function bootHasSnowflakePrimary() {}

  /**
   * @param $children
   * @return array
   */
  public static function getParentNodes($children)
  {
    $parentNodes = self::hasChildren()->get();
    return $parentNodes->filter(function ($item) use ($children) {
      $leafIds = $item->descendants()->pluck('id');
      return collect($leafIds)->intersect($children)->count();
    })->pluck('id')->toArray();
  }
}
