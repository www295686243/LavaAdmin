<?php

namespace App\Models\User;

use App\Models\AdminMenu;
use App\Models\Permission;
use App\Models\Task\TaskRecord;
use App\Models\Task\Traits\BindPhoneTaskTraits;
use App\Models\Task\Traits\EnterpriseEveryDayLoginTaskTraits;
use App\Models\Task\Traits\FollowWeChatTaskTraits;
use App\Models\Task\Traits\InviteUserTaskTraits;
use App\Models\Task\Traits\PersonalEveryDayLoginTaskTraits;
use App\Models\Traits\IdToStrTrait;
use App\Models\Traits\ResourceTrait;
use App\Services\SearchQueryService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Kra8\Snowflake\HasSnowflakePrimary;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User\User
 *
 * @property string $id
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
 * @property-read \App\Models\User\UserWallet|null $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\User withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $invite_user_id 邀请人
 * @property string|null $head_url
 * @property int|null $city 当前所在地
 * @property int $is_follow_official_account 是否关注公众号
 * @property string|null $follow_official_account_scene 关注来源
 * @property string|null $last_login_at 最后登录时间
 * @property-read \App\Models\User\UserAuth|null $auth
 * @property-read \App\Models\User\UserControl|null $control
 * @property-read \App\Models\User\UserEnterprise|null $enterprise
 * @property-read string $user_id
 * @property-read \App\Models\User\UserPersonal|null $personal
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereFollowOfficialAccountScene($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereHeadUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereInviteUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereIsFollowOfficialAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\User whereLastLoginAt($value)
 */
class User extends Authenticatable
{
  use
    Notifiable,
    HasRoles,
    HasApiTokens,
    ResourceTrait,
    SoftDeletes,
    IdToStrTrait,
    HasSnowflakePrimary,
    BindPhoneTaskTraits,
    FollowWeChatTaskTraits,
    PersonalEveryDayLoginTaskTraits,
    EnterpriseEveryDayLoginTaskTraits,
    InviteUserTaskTraits;

  /**
   * @var array
   */
  protected $fillable = [
    'invite_user_id',
    'username',
    'nickname',
    'email',
    'phone',
    'head_url',
    'city',
    'current_role',
    'is_follow_official_account',
    'follow_official_account_scene',
    'password',
    'is_admin',
    'api_token',
    'last_login_at',
    'register_at'
  ];

  /**
   * @var array
   */
  protected $hidden = [
    'updated_at',
    'remember_token',
    'password',
    'deleted_at',
    'email_verified_at',
    'api_token'
  ];

  protected $casts = [
    'invite_user_id' => 'string'
  ];

  protected $guard_name = 'api';

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function wallet()
  {
    return $this->hasOne(UserWallet::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function control()
  {
    return $this->hasOne(UserControl::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function personal()
  {
    return $this->hasOne(UserPersonal::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function enterprise()
  {
    return $this->hasOne(UserEnterprise::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function auth()
  {
    return $this->hasOne(UserAuth::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function task_record()
  {
    return $this->morphMany(TaskRecord::class, 'task_recordable');
  }

  /**
   * @param \DateTimeInterface $date
   * @return string
   */
  protected function serializeDate(\DateTimeInterface $date)
  {
    return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
  }

  /**
   * @param $value
   */
  public function setPasswordAttribute($value)
  {
    if ($value) {
      $this->attributes['password'] = Hash::make($value);
    }
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeSearchQuery($query)
  {
    return (new SearchQueryService())->searchQuery($query);
  }

  /**
   * @param \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function scopePagination($query)
  {
    $limit = request()->input('limit', 10);
    return $query->paginate($limit);
  }

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
   * @param \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeExceptRoot($query)
  {
    return $query->when(!User::getUserData()->hasRoot(), function ($query) {
      $root_ids = self::role('root')->pluck('id');
      return $query->whereNotIn('id', $root_ids);
    });
  }

  /**
   * @param $username
   * @param $password
   * @param bool $isAdmin
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
   */
  public function getToken($username, $password, $isAdmin = false)
  {
    $userData = self::where('username', $username)->first();
    if ($isAdmin && (!$userData || !$userData->is_admin)) {
      $this->error('用户名或密码错误!');
    }
    if (!$userData || !Hash::check($password, $userData->password)) {
      $this->error('用户名或密码错误!');
    }
    $userData->tokens()->delete();
    $userData->makeVisible('api_token');
    $plainTextToken = $userData->createToken('token')->plainTextToken;
    [$id, $token] = explode('|', $plainTextToken, 2);
    $userData->api_token = $token;
    $userData->save();
    return $userData;
  }

  /**
   * @param int $user_id
   * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
   */
  public static function getUserData($user_id = 0)
  {
    if ($user_id) {
      return static::where('id', $user_id)->firstOrFail();
    } else {
      return auth()->user();
    }
  }

  /**
   * @return int|null|string
   */
  public static function getUserId()
  {
    return auth()->id();
  }

  /**
   * @return bool
   */
  public function hasRoot()
  {
    return $this->hasRole('root');
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function getInterfacePermissions()
  {
    return $this->getAllPermissions()->pluck('name');
  }

  /**
   * @param $attributes
   * @return mixed
   * @throws \Throwable
   */
  public static function createUser($attributes)
  {
    return DB::transaction(function () use ($attributes) {
      $userData = static::create(Arr::only($attributes, (new static())->getFillable()));
      $userData->wallet()->create();
      $userData->control()->create();
      $userData->personal()->create();
      $userData->enterprise()->create();
      return $userData;
    });
  }

  /**
   * @param $attributes
   * @param $userId
   * @return mixed
   * @throws \Throwable
   */
  public static function updateUser($attributes, $userId)
  {
    return DB::transaction(function () use ($attributes, $userId) {
      $userData = static::findOrFail($userId);
      $userData->update(Arr::only($attributes, (new static())->getFillable()));
      $userData->control()->update(Arr::only($attributes, UserControl::getUpdateFillable()));
      $userData->personal()->update(Arr::only($attributes, UserPersonal::getFillFields()));
      $userData->enterprise()->update(Arr::only($attributes, UserEnterprise::getFillFields()));
      return $userData;
    });
  }

  /**
   * @param $userId
   * @return mixed
   * @throws \Throwable
   */
  public static function destroyUser($userId)
  {
    return DB::transaction(function () use ($userId) {
      $userData = static::findOrFail($userId);
      $userData->wallet()->delete();
      $userData->control()->delete();
      $userData->personal()->delete();
      $userData->enterprise()->delete();
      $userData->delete();
      return $userData;
    });
  }

  /**
   * 验证这个手机号是否绑定过
   * @param $phone
   */
  public function checkIsBindPhone($phone)
  {
    $phoneUser = self::where('phone', $phone)->first();
    // 如果该手机号已绑定别的账户
    if ($phoneUser && $phoneUser->id !== auth()->id()) {
      $this->error('该手机号已被其它账户绑定');
    }
  }

  /**
   * @return array
   */
  private function getAssignMenu () {
    return $this->roles()->get()->pluck('assign_menu')->flatten()->unique()->toArray();
  }

  /**
   * @param $platform
   * @return mixed
   */
  private function getAssignInterface($platform)
  {
    $roleIds = $this->roles()->pluck('id');
    $permissionIds = UserAssignPermission::whereIn('role_id', $roleIds)
      ->where('platform', $platform)
      ->pluck('permission_id');
    return Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
  }

  /**
   * @return \Kalnoy\Nestedset\Collection
   */
  public function getAssignMenuTree()
  {
    if ($this->hasRoot()) {
      return AdminMenu::all()->toTree();
    } else {
      return AdminMenu::whereIn('id', $this->getAssignMenu())->get()->toTree();
    }
  }

  /**
   * @param $platform
   * @return \Kalnoy\Nestedset\Collection
   */
  public function getAssignInterfaceTree($platform)
  {
    if ($this->hasRoot()) {
      return Permission::getAllPermissionTree($platform);
    } else {
      return Permission::whereIn('name', $this->getAssignInterface($platform))
        ->where('platform', $platform)
        ->get()
        ->toTree();
    }
  }

  /**
   * @param $menus
   * @return bool
   */
  public function checkAssignMenu($menus)
  {
    if (!$this->hasRoot()) {
      $assignMenu = $this->getAssignMenu();
      $result = collect($menus)->every(function ($value) use ($assignMenu) {
        return in_array($value, $assignMenu);
      });
      return $result;
    }
    return true;
  }

  /**
   * @param $permissions
   * @param $platform
   * @return bool
   */
  public function checkAssignInterface($permissions, $platform)
  {
    if (!$this->hasRoot()) {
      $assignInterface = $this->getAssignInterface($platform);
      $result = collect($permissions)->every(function ($value) use ($assignInterface) {
        return in_array($value, $assignInterface);
      });
      return $result;
    }
    return true;
  }

  public function checkPerfectPersonalInfo()
  {
    return $this->personal->isPerfectInfo();
  }

  public function checkPerfectEnterpriseInfo()
  {
    return $this->enterprise->isPerfectInfo();
  }
}
