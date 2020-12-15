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
use Database\Seeders\Permissions\Base;

class Hr extends Base {
  protected $data = [];

  public function __construct()
  {
    $this->data = [
      'name' => '/hr',
      'display_name' => '求职招聘',
      'children' => [
        (new HrJob())->get(),
        (new HrResume())->get(),
      ]
    ];
    $this->data = $this->setPlatform($this->data, 'admin');
  }
}
