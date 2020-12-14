<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:10
 */

namespace Database\Seeders\Permissions\Admin;

class User {
  public function get()
  {
    return [
      'name' => '/user',
      'display_name' => '用户管理',
      'guard_name' => 'admin',
      'children' => [
        [
          'name' => '/user/admin',
          'display_name' => '企业管理',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => '/user/admin/employee',
              'display_name' => '员工列表',
              'guard_name' => 'admin',
              'children' => [
                [
                  'name' => 'EmployeeController@index',
                  'display_name' => '列表',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'EmployeeController@store',
                  'display_name' => '添加',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'EmployeeController@show',
                  'display_name' => '详情',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'EmployeeController@update',
                  'display_name' => '更新',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'EmployeeController@destroy',
                  'display_name' => '删除',
                  'guard_name' => 'admin',
                ]
              ]
            ],
            [
              'name' => '/user/admin/position',
              'display_name' => '职位列表',
              'guard_name' => 'admin',
              'children' => [
                [
                  'name' => 'PositionController@index',
                  'display_name' => '列表',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'PositionController@store',
                  'display_name' => '添加',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'PositionController@show',
                  'display_name' => '详情',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'PositionController@update',
                  'display_name' => '更新',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'PositionController@updatePermissions',
                  'display_name' => '权限管理',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'PositionController@updateAssignPermissions',
                  'display_name' => '权限分配',
                  'guard_name' => 'admin',
                ]
              ]
            ]
          ]
        ],
        [
          'name' => '/user/member',
          'display_name' => '会员管理',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => '/user/member/user',
              'display_name' => '会员列表',
              'guard_name' => 'admin',
              'children' => [
                [
                  'name' => 'UserController@index',
                  'display_name' => '列表',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'UserController@show',
                  'display_name' => '详情',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'UserController@update',
                  'display_name' => '更新',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'UserController@destroy',
                  'display_name' => '删除',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'UserCouponController@store',
                  'display_name' => '赠送优惠券',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'UserBillController@index',
                  'display_name' => '账单记录',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'UserOrderController@index',
                  'display_name' => '订单记录',
                  'guard_name' => 'admin',
                ]
              ]
            ],
            [
              'name' => '/user/member/role',
              'display_name' => '会员角色',
              'guard_name' => 'admin',
              'children' => [
                [
                  'name' => 'RoleController@index',
                  'display_name' => '列表',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'RoleController@store',
                  'display_name' => '添加',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'RoleController@show',
                  'display_name' => '详情',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'RoleController@update',
                  'display_name' => '更新',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'RoleController@updatePermissions',
                  'display_name' => '权限管理',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'RoleController@updateAssignPermissions',
                  'display_name' => '权限分配',
                  'guard_name' => 'admin',
                ]
              ]
            ],
            [
              'name' => '/user/member/personal-auth',
              'display_name' => '个人认证',
              'guard_name' => 'admin',
              'children' => [
                [
                  'name' => 'UserPersonalAuthController@index',
                  'display_name' => '列表',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'UserPersonalAuthController@show',
                  'display_name' => '详情',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'UserPersonalAuthController@update',
                  'display_name' => '更新',
                  'guard_name' => 'admin',
                ]
              ]
            ],
            [
              'name' => '/user/member/enterprise-auth',
              'display_name' => '企业认证',
              'guard_name' => 'admin',
              'children' => [
                [
                  'name' => 'UserEnterpriseAuthController@index',
                  'display_name' => '列表',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'UserEnterpriseAuthController@show',
                  'display_name' => '详情',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'UserEnterpriseAuthController@update',
                  'display_name' => '更新',
                  'guard_name' => 'admin',
                ]
              ]
            ],
            [
              'name' => '/user/member/notify',
              'display_name' => '通知记录',
              'guard_name' => 'admin',
              'children' => [
                [
                  'name' => 'NotifyController@index',
                  'display_name' => '列表',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'NotifyController@show',
                  'display_name' => '详情',
                  'guard_name' => 'admin',
                ]
              ]
            ]
          ]
        ]
      ]
    ];
  }
}
