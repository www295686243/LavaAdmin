<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = [
      [
        'name' => '/system',
        'display_name' => '系统管理',
        'guard_name' => 'admin',
        'children' => [
          [
            'name' => '/system/config',
            'display_name' => '系统配置',
            'guard_name' => 'admin',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\ConfigController::class, [
              '_myself' => '仅自己'
            ])
          ]
        ]
      ],
      [
        'name' => '/user',
        'display_name' => '用户管理',
        'guard_name' => 'admin',
        'children' => [
          [
            'name' => '/user/admin',
            'display_name' => '后台管理',
            'guard_name' => 'admin',
            'children' => [
              [
                'name' => '/user/admin/employee',
                'display_name' => '员工列表',
                'guard_name' => 'admin',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\UserController::class, [
                  'getUserConfig' => '用户配置'
                ])
              ],
              [
                'name' => '/user/admin/position',
                'display_name' => '职位列表',
                'guard_name' => 'admin',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\PositionController::class, [
                  'updatePermissions' => '权限管理'
                ])
              ]
            ]
          ]
        ]
      ]
    ];
    \App\Models\Permission::rebuildTree($data);
  }

  /**
   * @param $class
   * @param array $options
   * @return array
   */
  private function getAdminPermissions($class, $options = [])
  {
    return $this->getPermissions($class, 'admin', $options);
  }

  /**
   * @param $class
   * @param $guard_name
   * @param array $options
   * @return array
   */
  private function getPermissions($class, $guard_name, $options = []) {
    $options = array_merge($options, ['index' => '列表', 'store' => '添加', 'show' => '详情', 'update' => '修改', 'destroy' => '删除']);
    $controllerName = class_basename($class);
    $baseControllerMethods = get_class_methods(new \App\Http\Controllers\Controller());
    $currentControllerMethods = get_class_methods(new $class());
    $controllerMethods = array_diff($currentControllerMethods, $baseControllerMethods);
    if (isset($options['_myself'])) {
      $controllerMethods[] = '_myself';
    }
    return collect($controllerMethods)
      ->filter(function ($method) use ($options) {
        return isset($options[$method]);
      })
      ->values()
      ->map(function ($method) use ($options, $controllerName, $guard_name) {
        return [
          'name' => $controllerName.'@'.$method,
          'display_name' => $options[$method],
          'guard_name' => $guard_name
        ];
      })
      ->toArray();
  }
}
