<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:17
 */

namespace Database\Seeders\Permissions\Admin\Hr;

use Database\Seeders\Permissions\Base;

class HrJob extends Base {
  protected $data = [
    'name' => '/hr/job',
    'display_name' => '职位管理',
    'children' => [
      [
        'name' => '/hr/job/info-check',
        'display_name' => '信息审核',
        'children' => [
          [
            'name' => 'InfoCheckController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'InfoCheckController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'InfoCheckController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/hr/job/list',
        'display_name' => '信息列表',
        'children' => [
          [
            'name' => 'HrJobController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'HrJobController@store',
            'display_name' => '添加',
          ],
          [
            'name' => 'HrJobController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'HrJobController@update',
            'display_name' => '更新',
          ],
          [
            'name' => 'HrJobController@destroy',
            'display_name' => '删除',
          ],
          [
            'name' => 'HrJobController@transfer',
            'display_name' => '转让',
          ],
          [
            'name' => 'HrJobController@push',
            'display_name' => '推送',
          ],
          [
            'name' => 'HrJobController@getInfoViews',
            'display_name' => '访问记录',
          ]
        ]
      ],
      [
        'name' => '/hr/job/info-provide',
        'display_name' => '信息提供',
        'children' => [
          [
            'name' => 'InfoProvideController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'InfoProvideController@store',
            'display_name' => '添加',
          ],
          [
            'name' => 'InfoProvideController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'InfoProvideController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/hr/job/info-complaint',
        'display_name' => '信息投诉',
        'children' => [
          [
            'name' => 'InfoComplaintController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'InfoComplaintController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'InfoComplaintController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/hr/job/info-delivery',
        'display_name' => '信息投递',
        'children' => [
          [
            'name' => 'InfoDeliveryController@index',
            'display_name' => '列表',
          ]
        ]
      ]
    ]
  ];

  public function __construct()
  {
    $this->data = $this->setPlatform($this->data, 'admin');
    $this->data = $this->setGuardName($this->data, 'HrJob');
  }
}
