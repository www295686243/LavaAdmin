<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{
  private $menuConfig = [
    [
      'display_name' => '系统管理',
      'children' => [
        [
          'display_name' => '系统配置',
          'icon' => 'el-icon-s-custom',
          'route' => '/system/config'
        ],
        [
          'display_name' => '后台操作日志',
          'icon' => 'el-icon-edit-outline',
          'route' => '/system/admin-log'
        ]
      ]
    ],
    [
      'display_name' => '用户管理',
      'children' => [
        [
          'display_name' => '后台管理',
          'icon' => 'el-icon-s-custom',
          'children' => [
            [
              'display_name' => '员工列表',
              'route' => '/member/admin-user'
            ],
            [
              'display_name' => '职位列表',
              'route' => '/member/admin-role'
            ]
          ]
        ],
        [
          'display_name' => '会员管理',
          'icon' => 'el-icon-user-solid',
          'children' => [
            [
              'display_name' => '会员列表',
              'route' => '/member/user'
            ],
            [
              'display_name' => '会员角色',
              'route' => '/member/user-role'
            ]
          ]
        ]
      ]
    ]
  ];
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \App\Models\AdminMenu::rebuildTree($this->menuConfig);
  }
}