<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;

/**
 * \App\Models\AdminMenu
 *
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\AdminMenu[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\AdminMenu $parent
 * @property-write mixed $parent_id
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu d()
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\AdminMenu newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\AdminMenu newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminMenu onlyTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\AdminMenu query()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminMenu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminMenu withoutTrashed()
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
    'sort'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    '_lft',
    '_rgt'
  ];

  protected $casts = [
    'params' => 'array'
  ];
}
