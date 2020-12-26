<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:10
 */

namespace Database\Seeders\Permissions\Admin;

use Database\Seeders\Permissions\Base;

class User extends Base {
  protected $data = [
    'name' => '/user',
    'display_name' => '用户管理',
    'children' => [
      [
        'name' => '/user/admin',
        'display_name' => '企业管理',
        'children' => [
          [
            'name' => '/user/admin/employee',
            'display_name' => '员工列表',
            'children' => [
              [
                'name' => 'EmployeeController@index',
                'display_name' => '列表',
              ],
              [
                'name' => 'EmployeeController@store',
                'display_name' => '添加',
              ],
              [
                'name' => 'EmployeeController@show',
                'display_name' => '详情',
              ],
              [
                'name' => 'EmployeeController@update',
                'display_name' => '更新',
              ],
              [
                'name' => 'EmployeeController@destroy',
                'display_name' => '删除',
              ]
            ]
          ],
          [
            'name' => '/user/admin/position',
            'display_name' => '职位列表',
            'children' => [
              [
                'name' => 'PositionController@index',
                'display_name' => '列表',
              ],
              [
                'name' => 'PositionController@store',
                'display_name' => '添加',
              ],
              [
                'name' => 'PositionController@show',
                'display_name' => '详情',
              ],
              [
                'name' => 'PositionController@update',
                'display_name' => '更新',
              ],
              [
                'name' => 'PositionController@updatePermissions',
                'display_name' => '权限管理',
              ]
            ]
          ]
        ]
      ],
      [
        'name' => '/user/member',
        'display_name' => '会员管理',
        'children' => [
          [
            'name' => '/user/member/user',
            'display_name' => '会员列表',
            'children' => [
              [
                'name' => 'UserController@index',
                'display_name' => '列表',
              ],
              [
                'name' => 'UserController@show',
                'display_name' => '详情',
              ],
              [
                'name' => 'UserController@update',
                'display_name' => '更新',
              ],
              [
                'name' => 'UserController@destroy',
                'display_name' => '删除',
              ],
              [
                'name' => 'UserCouponController@store',
                'display_name' => '赠送优惠券',
              ],
              [
                'name' => 'UserBillController@index',
                'display_name' => '账单记录',
              ],
              [
                'name' => 'UserOrderController@index',
                'display_name' => '订单记录',
              ]
            ]
          ],
          [
            'name' => '/user/member/role',
            'display_name' => '会员角色',
            'children' => [
              [
                'name' => 'RoleController@index',
                'display_name' => '列表',
              ],
              [
                'name' => 'RoleController@store',
                'display_name' => '添加',
              ],
              [
                'name' => 'RoleController@show',
                'display_name' => '详情',
              ],
              [
                'name' => 'RoleController@update',
                'display_name' => '更新',
              ],
              [
                'name' => 'RoleController@updatePermissions',
                'display_name' => '权限管理',
              ]
            ]
          ],
          [
            'name' => '/user/member/personal-auth',
            'display_name' => '个人认证',
            'children' => [
              [
                'name' => 'UserPersonalAuthController@index',
                'display_name' => '列表',
              ],
              [
                'name' => 'UserPersonalAuthController@show',
                'display_name' => '详情',
              ],
              [
                'name' => 'UserPersonalAuthController@update',
                'display_name' => '更新',
              ]
            ]
          ],
          [
            'name' => '/user/member/enterprise-auth',
            'display_name' => '企业认证',
            'children' => [
              [
                'name' => 'UserEnterpriseAuthController@index',
                'display_name' => '列表',
              ],
              [
                'name' => 'UserEnterpriseAuthController@show',
                'display_name' => '详情',
              ],
              [
                'name' => 'UserEnterpriseAuthController@update',
                'display_name' => '更新',
              ]
            ]
          ],
          [
            'name' => '/user/member/notify',
            'display_name' => '通知记录',
            'children' => [
              [
                'name' => 'NotifyController@index',
                'display_name' => '列表',
              ],
              [
                'name' => 'NotifyController@show',
                'display_name' => '详情',
              ]
            ]
          ]
        ]
      ]
    ]
  ];

  public function __construct()
  {
    $this->data = $this->setPlatform($this->data, 'admin');
  }
}
