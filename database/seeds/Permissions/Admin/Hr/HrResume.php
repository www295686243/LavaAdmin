<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:17
 */

namespace Database\Seeders\Permissions\Admin\Hr;

use Database\Seeders\Permissions\Base;

class HrResume extends Base {
  protected $data = [
    'name' => '/hr/resume',
    'display_name' => '简历管理',
    'children' => [
      [
        'name' => '/hr/resume/info-check',
        'display_name' => '信息审核',
        'children' => [
          [
            'name' => 'HrResumeInfoCheckController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'HrResumeInfoCheckController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'HrResumeInfoCheckController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/hr/resume/list',
        'display_name' => '信息列表',
        'children' => [
          [
            'name' => 'HrResumeController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'HrResumeController@store',
            'display_name' => '添加',
          ],
          [
            'name' => 'HrResumeController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'HrResumeController@update',
            'display_name' => '更新',
          ],
          [
            'name' => 'HrResumeController@destroy',
            'display_name' => '删除',
          ],
          [
            'name' => 'HrResumeController@transfer',
            'display_name' => '转让',
          ],
          [
            'name' => 'HrResumeController@push',
            'display_name' => '推送',
          ],
          [
            'name' => 'HrResumeController@getInfoViews',
            'display_name' => '访问记录',
          ]
        ]
      ],
      [
        'name' => '/hr/resume/info-provide',
        'display_name' => '信息提供',
        'children' => [
          [
            'name' => 'HrResumeInfoProvideController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'HrResumeInfoProvideController@store',
            'display_name' => '添加',
          ],
          [
            'name' => 'HrResumeInfoProvideController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'HrResumeInfoProvideController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/hr/resume/info-complaint',
        'display_name' => '信息投诉',
        'children' => [
          [
            'name' => 'HrResumeInfoComplaintController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'HrResumeInfoComplaintController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'HrResumeInfoComplaintController@update',
            'display_name' => '更新',
          ]
        ]
      ],
      [
        'name' => '/hr/resume/info-delivery',
        'display_name' => '信息投递',
        'children' => [
          [
            'name' => 'HrResumeInfoDeliveryController@index',
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
