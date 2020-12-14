<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:10
 */

namespace Database\Seeders\Permissions\Admin;

class System {
  public function get()
  {
    return [
      'name' => '/system',
      'display_name' => '系统管理',
      'guard_name' => 'admin',
      'children' => [
        [
          'name' => '/system/config',
          'display_name' => '参数配置',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'ConfigController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'ConfigController@store',
              'display_name' => '添加',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'ConfigController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'ConfigController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'ConfigController@destroy',
              'display_name' => '删除',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/system/options/config',
          'display_name' => '选项配置',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'ConfigController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'ConfigController@store',
              'display_name' => '添加',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'ConfigController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'ConfigController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'ConfigController@destroy',
              'display_name' => '删除',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/system/industry',
          'display_name' => '行业配置',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'IndustryController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'IndustryController@store',
              'display_name' => '添加',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'IndustryController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'IndustryController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'IndustryController@destroy',
              'display_name' => '删除',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/system/admin-log',
          'display_name' => '后台操作日志',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'AdminLogController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ]
          ]
        ],
        [
          'name' => '/system/version',
          'display_name' => '版本控制',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => 'IndustryController@index',
              'display_name' => '列表',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'IndustryController@show',
              'display_name' => '详情',
              'guard_name' => 'admin',
            ],
            [
              'name' => 'IndustryController@update',
              'display_name' => '更新',
              'guard_name' => 'admin',
            ]
          ]
        ]
      ]
    ];
  }
}
