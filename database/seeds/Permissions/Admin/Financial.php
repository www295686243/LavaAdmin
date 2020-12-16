<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:11
 */

namespace Database\Seeders\Permissions\Admin;

use Database\Seeders\Permissions\Base;

class Financial extends Base {
  protected $data = [
    'name' => '/financial',
    'display_name' => '财务管理',
    'children' => [
      [
        'name' => '/financial/cash-apply',
        'display_name' => '提现申请',
        'children' => [
          [
            'name' => 'UserCashApplyController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'UserCashApplyController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'UserCashApplyController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/financial/cash-approve',
        'display_name' => '提现审批',
        'children' => [
          [
            'name' => 'UserCashApprovalController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'UserCashApprovalController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'UserCashApprovalController@update',
            'display_name' => '更新',
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
