<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:10
 */

namespace Database\Seeders\Permissions\Admin;

use Database\Seeders\Permissions\Admin\Hr\HrJob;
use Database\Seeders\Permissions\Admin\Hr\HrResume;

class Hr {
  public function get()
  {
    return [
      'name' => '/hr',
      'display_name' => '求职招聘',
      'guard_name' => 'admin',
      'children' => [
        (new HrJob())->get(),
        (new HrResume())->get(),
      ]
    ];
  }
}
