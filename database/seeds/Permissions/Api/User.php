<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:11
 */

namespace Database\Seeders\Permissions\Api;

class User {
  public function get()
  {
    return [
      'name' => '/user',
      'display_name' => '基本权限',
      'guard_name' => 'api',
      'children' => [
        [
          'name' => 'UserController@login',
          'display_name' => '登录',
          'guard_name' => 'api',
        ]
      ]
    ];
  }
}
