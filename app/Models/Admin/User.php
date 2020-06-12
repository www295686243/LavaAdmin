<?php

namespace App\Models\Admin;

use App\Models\AdminMenu;

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
}
