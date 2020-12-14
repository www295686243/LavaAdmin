<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:17
 */

namespace Database\Seeders\Permissions\Admin\Hr;

class HrResume {
  public function get()
  {
    return [
      'name' => '/hr/resume',
      'display_name' => '简历管理',
      'guard_name' => 'admin',
      'children' => [
        [
          'name' => '/hr/resume/info-check',
          'display_name' => '信息审核',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'InfoCheckController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'InfoCheckController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'InfoCheckController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/hr/resume/list',
          'display_name' => '信息列表',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'HrJobController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'HrJobController@store',
              'display_name' => '添加',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'HrJobController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'HrJobController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'HrJobController@destroy',
              'display_name' => '删除',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'HrJobController@transfer',
              'display_name' => '转让',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'HrJobController@push',
              'display_name' => '推送',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'HrJobController@getInfoViews',
              'display_name' => '访问记录',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/hr/resume/info-provide',
          'display_name' => '信息提供',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'InfoProvideController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'InfoProvideController@store',
              'display_name' => '添加',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'InfoProvideController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'InfoProvideController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/hr/resume/info-complaint',
          'display_name' => '信息投诉',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'InfoComplaintController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'InfoComplaintController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'InfoComplaintController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/hr/resume/info-delivery',
          'display_name' => '信息投递',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'InfoDeliveryController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ]
          ]
        ]
      ]
    ];
  }
}
