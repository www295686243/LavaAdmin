<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/12/14
 * Time: 20:11
 */

namespace Database\Seeders\Permissions\Admin;

use Database\Seeders\Permissions\Base;

class Other extends Base {
  protected $data = [
    'name' => '/other',
    'display_name' => '其它管理',
    'children' => [
      [
        'name' => '/other/wechat',
        'display_name' => '微信配置',
        'children' => [
          [
            'name' => '/other/wechat/notify-template',
            'display_name' => '通知模板',
            'children' => [
              [
                'name' => 'NotifyTemplateController@index',
                'display_name' => '列表',
              ],
              [
                'name' => 'NotifyTemplateController@store',
                'display_name' => '添加',
              ],
              [
                'name' => 'NotifyTemplateController@show',
                'display_name' => '详情',
              ],
              [
                'name' => 'NotifyTemplateController@update',
                'display_name' => '更新',
              ]
            ]
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
