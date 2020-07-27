<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;

/**
 * \App\Models\AdminMenu
 *
 * @property int $id
 * @property string $display_name 菜单名称
 * @property string|null $desc 菜单描述
 * @property string|null $route 路由
 * @property string|null $icon icon图标
 * @property array|null $params 所需参数(一般二级以上的菜单会用到)
 * @property int|null $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\AdminMenu[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\AdminMenu|null $parent
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu d()
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\AdminMenu newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\AdminMenu newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\AdminMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereUpdatedAt($value)
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
}
