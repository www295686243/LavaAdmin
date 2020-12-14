<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:10
 */

namespace Database\Seeders\Permissions\Admin;

class Operation {
  public function get()
  {
    return [
      'name' => '/operation',
      'display_name' => '运营管理',
      'guard_name' => 'admin',
      'children' => [
        [
          'name' => '/operation/coupon-template',
          'display_name' => '优惠券模板',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'CouponTemplateController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'CouponTemplateController@store',
              'display_name' => '添加',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'CouponTemplateController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'CouponTemplateController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/operation/coupon',
          'display_name' => '优惠券列表',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'UserCouponController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/operation/coupon-market',
          'display_name' => '优惠券市场',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'CouponMarketController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/operation/coupon-order',
          'display_name' => '优惠券订单',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'UserOrderController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/operation/task',
          'display_name' => '任务管理',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'TaskController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'TaskController@store',
              'display_name' => '添加',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'TaskController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'TaskController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/operation/task-record',
          'display_name' => '任务记录',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'TaskRecordController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ]
          ]
        ]
      ]
    ];
  }
}
