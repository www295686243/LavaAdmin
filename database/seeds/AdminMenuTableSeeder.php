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
          'display_name' => '参数配置',
          'icon' => 'el-icon-setting',
          'route' => '/system/config',
          'default_params' => ['guard_name' => 'system']
        ],
        [
          'display_name' => '后台操作日志',
          'icon' => 'el-icon-edit-outline',
          'route' => '/system/admin-log'
        ],
        [
          'display_name' => '版本控制',
          'icon' => 'el-icon-set-up',
          'route' => '/system/version'
        ]
      ]
    ],
    [
      'display_name' => '新闻管理',
      'route' => '/info',
      'children' => [
        [
          'display_name' => '参数配置',
          'icon' => 'el-icon-setting',
          'route' => '/info/news/config',
          'default_params' => ['guard_name' => 'News']
        ],
        [
          'display_name' => '选项配置',
          'icon' => 'el-icon-s-operation',
          'route' => '/info/news/options/config',
          'default_params' => ['guard_name' => 'options.News']
        ],
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
