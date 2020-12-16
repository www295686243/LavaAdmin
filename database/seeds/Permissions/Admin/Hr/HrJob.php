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
            'name' => 'HrJobInfoCheckController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'HrJobInfoCheckController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'HrJobInfoCheckController@update',
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
            'name' => 'HrJobInfoProvideController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'HrJobInfoProvideController@store',
            'display_name' => '添加',
          ],
          [
            'name' => 'HrJobInfoProvideController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'HrJobInfoProvideController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/hr/job/info-complaint',
        'display_name' => '信息投诉',
        'children' => [
          [
            'name' => 'HrJobInfoComplaintController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'HrJobInfoComplaintController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'HrJobInfoComplaintController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/hr/job/info-delivery',
        'display_name' => '信息投递',
        'children' => [
          [
            'name' => 'HrJobInfoDeliveryController@index',
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
