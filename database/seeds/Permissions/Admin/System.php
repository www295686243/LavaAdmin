<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:10
 */

namespace Database\Seeders\Permissions\Admin;

use Database\Seeders\Permissions\Base;

class System extends Base {
  protected $data = [
    'name' => '/system',
    'display_name' => '系统管理',
    'children' => [
      [
        'name' => '/system/config',
        'display_name' => '参数配置',
        'children' => [
          [
            'name' => 'ConfigController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'ConfigController@store',
            'display_name' => '添加',
          ],
          [
            'name' => 'ConfigController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'ConfigController@update',
            'display_name' => '更新',
          ],
          [
            'name' => 'ConfigController@destroy',
            'display_name' => '删除',
          ]
        ]
      ],
      [
        'name' => '/system/options/config',
        'display_name' => '选项配置',
        'children' => [
          [
            'name' => 'ConfigController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'ConfigController@store',
            'display_name' => '添加',
          ],
          [
            'name' => 'ConfigController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'ConfigController@update',
            'display_name' => '更新',
          ],
          [
            'name' => 'ConfigController@destroy',
            'display_name' => '删除',
          ]
        ]
      ],
      [
        'name' => '/system/industry',
        'display_name' => '行业配置',
        'children' => [
          [
            'name' => 'IndustryController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'IndustryController@store',
            'display_name' => '添加',
          ],
          [
            'name' => 'IndustryController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'IndustryController@update',
            'display_name' => '更新',
          ],
          [
            'name' => 'IndustryController@destroy',
            'display_name' => '删除',
          ]
        ]
      ],
      [
        'name' => '/system/admin-log',
        'display_name' => '后台操作日志',
        'children' => [
          [
            'name' => 'AdminLogController@index',
            'display_name' => '列表',
          ]
        ]
      ],
      [
        'name' => '/system/version',
        'display_name' => '版本控制',
        'children' => [
          [
            'name' => 'VersionController@index',
            'display_name' => '列表',
          ],
          [
            'name' => 'VersionController@show',
            'display_name' => '详情',
          ],
          [
            'name' => 'VersionController@update',
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
