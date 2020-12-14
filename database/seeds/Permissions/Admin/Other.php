<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:11
 */

namespace Database\Seeders\Permissions\Admin;

class Other {
  public function get()
  {
    return [
      'name' => '/other',
      'display_name' => '其它管理',
      'guard_name' => 'admin',
      'children' => [
        [
          'name' => '/other/wechat',
          'display_name' => '微信配置',
          'guard_name' => 'admin',
          'children' => [
            [
              'name' => '/other/wechat/notify-template',
              'display_name' => '通知模板',
              'guard_name' => 'admin',
              'children' => [
                [
                  'name' => 'NotifyTemplateController@index',
                  'display_name' => '列表',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'NotifyTemplateController@store',
                  'display_name' => '添加',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'NotifyTemplateController@show',
                  'display_name' => '详情',
                  'guard_name' => 'admin',
                ],
                [
                  'name' => 'NotifyTemplateController@update',
                  'display_name' => '更新',
                  'guard_name' => 'admin',
                ]
              ]
            ]
          ]
        ]
      ]
    ];
  }
}
