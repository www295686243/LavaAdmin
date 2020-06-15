<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{
  private $menuConfig = [
    [
      'display_name' => '系统管理',
      'route' => '/system',
      'children' => [
        [
          'display_name' => '系统配置',
          'icon' => 'el-icon-s-custom',
          'route' => '/system/config',
          'children' => [
            [
              'display_name' => '配置列表',
              'route' => '/system/config/config'
            ],
            [
              'display_name' => '配置选项',
              'route' => '/system/config/config-option'
            ]
          ]
        ],
        [
          'display_name' => '后台操作日志',
          'icon' => 'el-icon-edit-outline',
          'route' => '/system/admin-log'
        ]
      ]
    ],
    [
      'display_name' => '新闻管理',
      'route' => '/info',
      'children' => [
        [
          'display_name' => '新闻列表',
          'icon' => 'el-icon-news',
          'route' => '/info/news'
        ]
      ]
    ],
    [
      'display_name' => '用户管理',
      'route' => '/user',
      'children' => [
        [
          'display_name' => '后台管理',
          'icon' => 'el-icon-s-custom',
          'route' => '/user/admin',
          'children' => [
            [
              'display_name' => '员工列表',
              'route' => '/user/admin/employee'
            ],
            [
              'display_name' => '职位列表',
              'route' => '/user/admin/position'
            ]
          ]
        ],
        [
          'display_name' => '会员管理',
          'icon' => 'el-icon-user-solid',
          'route' => '/user/member',
          'children' => [
            [
              'display_name' => '会员列表',
              'route' => '/user/member/user'
            ],
            [
              'display_name' => '会员角色',
              'route' => '/user/member/role'
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
