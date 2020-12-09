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
          'display_name' => '职位管理',
          'icon' => 'el-icon-s-custom',
          'route' => '/hr/job',
          'children' => [
            [
              'display_name' => '信息审核',
              'route' => '/hr/job/info-check',
              'icon' => 'el-icon-s-claim',
              'default_params' => ['_model' => 'Info/Hr/HrJob']
            ],
            [
              'display_name' => '信息列表',
              'icon' => 'el-icon-s-shop',
              'route' => '/hr/job/list'
            ],
            [
              'display_name' => '信息提供',
              'route' => '/hr/job/info-provide',
              'icon' => 'el-icon-s-management',
              'default_params' => ['_model' => 'Info/Hr/HrJob']
            ],
            [
              'display_name' => '信息投诉',
              'route' => '/hr/job/info-complaint',
              'icon' => 'el-icon-s-release',
              'default_params' => ['_model' => 'Info/Hr/HrJob']
            ],
            [
              'display_name' => '信息投递',
              'route' => '/hr/job/info-delivery',
              'icon' => 'el-icon-share',
              'default_params' => ['_model' => 'Info/Hr/HrJob']
            ]
          ]
        ],
        [
          'display_name' => '简历管理',
          'icon' => 'el-icon-user-solid',
          'route' => '/hr/resume',
          'children' => [
            [
              'display_name' => '信息审核',
              'route' => '/hr/resume/info-check',
              'icon' => 'el-icon-s-claim',
              'default_params' => ['_model' => 'Info/Hr/HrResume']
            ],
            [
              'display_name' => '信息列表',
              'icon' => 'el-icon-s-shop',
              'route' => '/hr/resume/list'
            ],
            [
              'display_name' => '信息提供',
              'route' => '/hr/resume/info-provide',
              'icon' => 'el-icon-s-management',
              'default_params' => ['_model' => 'Info/Hr/HrResume']
            ],
            [
              'display_name' => '信息投诉',
              'route' => '/hr/resume/info-complaint',
              'icon' => 'el-icon-s-release',
              'default_params' => ['_model' => 'Info/Hr/HrResume']
            ],
            [
              'display_name' => '信息投递',
              'route' => '/hr/resume/info-delivery',
              'icon' => 'el-icon-share',
              'default_params' => ['_model' => 'Info/Hr/HrResume']
            ]
          ]
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
          'display_name' => '优惠券市场',
          'icon' => 'el-icon-s-shop',
          'route' => '/operation/coupon-market'
        ],
        [
          'display_name' => '优惠券订单',
          'icon' => 'el-icon-s-order',
          'route' => '/operation/coupon-order'
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
              'icon' => 'el-icon-s-custom',
              'route' => '/user/admin/employee'
            ],
            [
              'display_name' => '职位列表',
              'icon' => 'el-icon-s-management',
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
              'icon' => 'el-icon-user-solid',
              'route' => '/user/member/user'
            ],
            [
              'display_name' => '会员角色',
              'icon' => 'el-icon-s-opportunity',
              'route' => '/user/member/role'
            ],
            [
              'display_name' => '资料审核',
              'icon' => 'el-icon-s-claim',
              'route' => '/user/info-check',
              'default_params' => ['_model' => 'User/UserPersonal,User/UserEnterprise']
            ],
            [
              'display_name' => '个人认证',
              'icon' => 'el-icon-s-check',
              'route' => '/user/member/personal-auth'
            ],
            [
              'display_name' => '企业认证',
              'icon' => 'el-icon-s-check',
              'route' => '/user/member/enterprise-auth'
            ],
            [
              'display_name' => '通知记录',
              'icon' => 'el-icon-s-promotion',
              'route' => '/user/member/notify'
            ],
            [
              'display_name' => '订单记录',
              'icon' => 'el-icon-s-order',
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
              'icon' => 'el-icon-s-grid',
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
