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
          'default_params' => ['guard_name' => 'config']
        ],
        [
          'display_name' => '选项配置',
          'icon' => 'el-icon-s-operation',
          'route' => '/system/options/config',
          'default_params' => ['guard_name' => 'options']
        ],
        [
          'display_name' => '行业配置',
          'icon' => 'el-icon-s-flag',
          'route' => '/system/industry'
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
      'display_name' => '求职招聘',
      'route' => '/hr',
      'children' => [
        [
          'display_name' => '信息审核',
          'icon' => 'el-icon-s-check',
          'route' => '/hr/info-check',
          'default_params' => ['_model' => 'Info/Hr/HrJob,Info/Hr/HrResume']
        ],
        [
          'display_name' => '招聘列表',
          'icon' => 'el-icon-s-custom',
          'route' => '/hr/job'
        ],
        [
          'display_name' => '求职列表',
          'icon' => 'el-icon-user-solid',
          'route' => '/hr/resume'
        ],
        [
          'display_name' => '信息提供',
          'icon' => 'el-icon-document-add',
          'route' => '/hr/info-provide',
          'default_params' => ['_model' => 'Info/Hr/HrJob']
        ],
        [
          'display_name' => '信息投诉',
          'icon' => 'el-icon-phone',
          'route' => '/hr/info-complaint',
          'default_params' => ['_model' => 'Info/Hr/HrJob,Info/Hr/HrResume']
        ],
        [
          'display_name' => '信息投递',
          'icon' => 'el-icon-tickets',
          'route' => '/hr/info-delivery',
          'default_params' => ['_model' => 'Info/Hr/HrJob,Info/Hr/HrResume']
        ]
      ]
    ],
    [
      'display_name' => '运营管理',
      'route' => '/operation',
      'children' => [
        [
          'display_name' => '优惠券模板',
          'icon' => 'el-icon-s-management',
          'route' => '/operation/coupon-template'
        ],
        [
          'display_name' => '优惠券列表',
          'icon' => 'el-icon-s-ticket',
          'route' => '/operation/coupon'
        ],
        [
          'display_name' => '任务管理',
          'icon' => 'el-icon-s-flag',
          'route' => '/operation/task'
        ],
        [
          'display_name' => '任务记录',
          'icon' => 'el-icon-s-order',
          'route' => '/operation/task-record'
        ],
        [
          'display_name' => '优惠券市场',
          'icon' => 'el-icon-s-shop',
          'route' => '/operation/coupon-market'
        ],
        [
          'display_name' => '优惠券订单',
          'icon' => 'el-icon-s-order',
          'route' => '/operation/coupon-order'
        ]
      ]
    ],
    [
      'display_name' => '用户管理',
      'route' => '/user',
      'children' => [
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
              'display_name' => '资料审核',
              'icon' => 'el-icon-s-check',
              'route' => '/user/info-check',
              'default_params' => ['_model' => 'User/UserPersonal,User/UserEnterprise']
            ],
            [
              'display_name' => '个人认证',
              'route' => '/user/member/personal-auth'
            ],
            [
              'display_name' => '企业认证',
              'route' => '/user/member/enterprise-auth'
            ],
            [
              'display_name' => '通知记录',
              'route' => '/user/member/notify'
            ],
            [
              'display_name' => '订单记录',
              'route' => '/user/member/order'
            ]
          ]
        ]
      ]
    ],
    [
      'display_name' => '统计报表',
      'route' => '/report',
      'children' => [
        [
          'display_name' => '用户相关',
          'icon' => 'el-icon-s-marketing',
          'route' => '/report/user'
        ],
        [
          'display_name' => '订单相关',
          'icon' => 'el-icon-s-marketing',
          'route' => '/report/order'
        ]
      ]
    ],
    [
      'display_name' => '财务管理',
      'route' => '/financial',
      'children' => [
        [
          'display_name' => '提现申请',
          'icon' => 'el-icon-s-order',
          'route' => '/financial/cash-apply'
        ],
        [
          'display_name' => '提现审批',
          'icon' => 'el-icon-s-claim',
          'route' => '/financial/cash-approve'
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
