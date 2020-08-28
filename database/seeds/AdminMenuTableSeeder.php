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
      'display_name' => '运营管理',
      'route' => '/operation',
      'children' => [
        [
          'display_name' => '选项配置',
          'icon' => 'el-icon-s-operation',
          'route' => '/operation/options/config',
          'default_params' => ['guard_name' => 'options.Operation']
        ],
        [
          'display_name' => '优惠券管理',
          'icon' => 'el-icon-s-ticket',
          'route' => '/operation/coupon',
          'children' => [
            [
              'display_name' => '优惠券模板',
              'route' => '/operation/coupon/coupon-template'
            ],
            [
              'display_name' => '优惠券列表',
              'route' => '/operation/coupon/coupon'
            ]
          ]
        ]
      ]
    ],
    [
      'display_name' => '用户管理',
      'route' => '/user',
      'children' => [
        [
          'display_name' => '用户报表',
          'icon' => 'el-icon-s-marketing',
          'route' => '/user/report',
        ],
        [
          'display_name' => '参数配置',
          'icon' => 'el-icon-setting',
          'route' => '/user/config',
          'default_params' => ['guard_name' => 'User']
        ],
        [
          'display_name' => '选项配置',
          'icon' => 'el-icon-s-operation',
          'route' => '/user/options/config',
          'default_params' => ['guard_name' => 'options.User']
        ],
        [
          'display_name' => '企业管理',
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
            ],
            [
              'display_name' => '通知记录',
              'icon' => 'el-icon-message-solid',
              'route' => '/user/member/notify'
            ]
          ]
        ]
      ]
    ],
    [
      'display_name' => '其它管理',
      'route' => '/other',
      'children' => [
        [
          'display_name' => '微信配置',
          'icon' => 'el-icon-s-tools',
          'route' => '/other/wechat',
          'children' => [
            [
              'display_name' => '通知模板',
              'route' => '/other/wechat/notify-template'
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
