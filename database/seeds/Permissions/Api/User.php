<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:11
 */

namespace Database\Seeders\Permissions\Api;

use Database\Seeders\Permissions\Base;

class User extends Base {
  protected $data = [
    'name' => '/user',
    'display_name' => '基本权限',
    'children' => [
      [
        'name' => 'UserController@login',
        'display_name' => '登录',
      ]
    ]
  ];

  public function __construct()
  {
    $this->data = $this->setPlatform($this->data, 'api');
  }
}
