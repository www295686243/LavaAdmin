<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\User\UserEnterprise;
use App\Models\User\UserPersonal;
use Illuminate\Support\Arr;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Models\Info\Industry
 *
 * @property int|null|string $id
 * @property string $display_name 名称
 * @property int|null $sort 排序
 * @property float|null $hr_job_amount 招聘金额
 * @property float|null $hr_resume_amount 求职金额
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|Industry[] $children
 * @property-read int|null $children_count
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @property-read \Illuminate\Database\Eloquent\Collection|HrJob[] $hr_job
 * @property-read int|null $hr_job_count
 * @property-read \Illuminate\Database\Eloquent\Collection|HrResume[] $hr_resume
 * @property-read int|null $hr_resume_count
 * @property-read Industry|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|UserEnterprise[] $user_enterprise
 * @property-read int|null $user_enterprise_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UserPersonal[] $user_personal
 * @property-read int|null $user_personal_count
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry fixTree($root = null)
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Base listQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Base pagination()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Base searchModel($typeField, $model = '')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Base searchQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Base simplePagination()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereCreatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereDisplayName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereHrJobAmount($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereHrResumeAmount($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereLft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereNodeBetween($values, $boolean = 'and', $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereRgt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereSort($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry whereUpdatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry withDepth(string $as = 'depth')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Industry withoutRoot()
 * @mixin \Eloquent
 */
class Industry extends Base
{
  use NodeTrait;

  protected $fillable = [
    'parent_id',
    'display_name',
    'sort',
    'hr_job_amount',
    'hr_resume_amount',
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'hr_job_amount' => 'float',
    'hr_resume_amount' => 'float',
  ];

  public static function bootHasSnowflakePrimary() {}

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function user_personal()
  {
    return $this->morphedByMany(UserPersonal::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function user_enterprise()
  {
    return $this->morphedByMany(UserEnterprise::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function hr_job()
  {
    return $this->morphedByMany(HrJob::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function hr_resume()
  {
    return $this->morphedByMany(HrResume::class, 'industrygable');
  }

  /**
   * [20, 21, 22] // 第三级id
   * @param array $industries
   * @return array [[父级下的所有根id], [子级下的所有根id], [根id]]
   */
  public static function getGather($industries = [])
  {
    if (!$industries || count($industries) === 0) return [];
    $industries = Arr::sort($industries);
    $industryGather = collect($industries)
      ->map(function ($industryId) { // [[1, 2, 20], [3, 4, 21], [5, 6, 22]] 每个根id的父级路径
        return Industry::ancestorsAndSelf($industryId)->pluck('id');
      })
      ->map(function ($industryPaths) { // [[[父级下的所有根id], [子级下的所有根id], [根id]], [[父级下的所有根id], [子级下的所有根id], [根id]]]
        return collect($industryPaths)->map(function ($industryId) {
          return Industry::withDepth()->having('depth', '=', 2)->descendantsAndSelf($industryId)->pluck('id');
        });
      })
      ->toArray();
    return array_map(function(...$item){
      return array_unique(array_merge(...$item));
    }, ...$industryGather);
  }
}
