<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:10
 */

namespace Database\Seeders\Permissions\Admin;

use Database\Seeders\Permissions\Base;

class Operation extends Base {
  protected $data = [
    'name' => '/operation',
    'display_name' => '运营管理',
    'children' => [
      [
        'name' => '/operation/coupon-template',
        'display_name' => '优惠券模板',
        'children' => [
          [
            'name' => 'CouponTemplateController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'CouponTemplateController@store',
            'display_name' => '添加',
          ],
          [
            'name' => 'CouponTemplateController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'CouponTemplateController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/operation/coupon',
        'display_name' => '优惠券列表',
        'children' => [
          [
            'name' => 'UserCouponController@index',
            'display_name' => '列表',
          ]
        ]
      ],
      [
        'name' => '/operation/coupon-market',
        'display_name' => '优惠券市场',
        'children' => [
          [
            'name' => 'CouponMarketController@index',
            'display_name' => '列表',
          ]
        ]
      ],
      [
        'name' => '/operation/coupon-order',
        'display_name' => '优惠券订单',
        'children' => [
          [
            'name' => 'UserOrderController@index',
            'display_name' => '列表',
          ]
        ]
      ],
      [
        'name' => '/operation/task',
        'display_name' => '任务管理',
        'children' => [
          [
            'name' => 'TaskController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'TaskController@store',
            'display_name' => '添加',
          ],
          [
            'name' => 'TaskController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'TaskController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/operation/task-record',
        'display_name' => '任务记录',
        'children' => [
          [
            'name' => 'TaskRecordController@index',
            'display_name' => '列表',
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
