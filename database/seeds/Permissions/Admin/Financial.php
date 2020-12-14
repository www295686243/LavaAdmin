<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:11
 */

namespace Database\Seeders\Permissions\Admin;

class Financial {
  public function get()
  {
    return [
      'name' => '/financial',
      'display_name' => '财务管理',
      'guard_name' => 'admin',
      'children' => [
        [
          'name' => '/financial/cash-apply',
          'display_name' => '提现申请',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'UserCashController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'UserCashController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'UserCashController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/financial/cash-approve',
          'display_name' => '提现审批',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'UserCashController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'UserCashController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'UserCashController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ]
          ]
        ]
      ]
    ];
  }
}
