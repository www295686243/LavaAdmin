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
        'children' => [
          [
            'name' => '/system/config',
            'display_name' => '参数配置',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\ConfigController::class)
          ],
          [
            'name' => '/system/options/config',
            'display_name' => '选项配置',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\ConfigOptionController::class)
          ],
          [
            'name' => '/system/industry',
            'display_name' => '行业配置',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\IndustryController::class)
          ],
          [
            'name' => '/system/admin-log',
            'display_name' => '后台操作日志',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\AdminLogController::class)
          ],
          [
            'name' => '/system/version',
            'display_name' => '版本控制',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\VersionController::class)
          ]
        ]
      ],
      [
        'name' => '/hr',
        'display_name' => '求职招聘',
        'children' => [
          [
            'name' => '/hr/job',
            'display_name' => '职位管理',
            'children' => [
              [
                'name' => '/hr/job/info-check',
                'display_name' => '信息审核',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\InfoCheckController::class)
              ],
              [
                'name' => '/hr/job/list',
                'display_name' => '信息列表',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\HrJobController::class, [
                  'transfer' => '转让',
                  'push' => '推送',
                  'getInfoViews' => '访问记录'
                ])
              ],
              [
                'name' => '/hr/job/info-provide',
                'display_name' => '信息提供',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\InfoProvideController::class)
              ],
              [
                'name' => '/hr/job/info-complaint',
                'display_name' => '信息投诉',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\InfoComplaintController::class)
              ],
              [
                'name' => '/hr/job/info-delivery',
                'display_name' => '信息投递',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\InfoDeliveryController::class)
              ]
            ]
          ],
          [
            'name' => '/hr/resume',
            'display_name' => '简历管理',
            'children' => [
              [
                'name' => '/hr/resume/info-check',
                'display_name' => '信息审核',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\InfoCheckController::class)
              ],
              [
                'name' => '/hr/resume/list',
                'display_name' => '信息列表',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\HrResumeController::class, [
                  'transfer' => '转让',
                  'push' => '推送',
                  'getInfoViews' => '访问记录'
                ])
              ],
              [
                'name' => '/hr/resume/info-provide',
                'display_name' => '信息提供',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\InfoProvideController::class)
              ],
              [
                'name' => '/hr/resume/info-complaint',
                'display_name' => '信息投诉',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\InfoComplaintController::class)
              ],
              [
                'name' => '/hr/resume/info-delivery',
                'display_name' => '信息投递',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Info\InfoDeliveryController::class)
              ]
            ]
          ]
        ]
      ],
      [
        'name' => '/operation',
        'display_name' => '运营管理',
        'children' => [
          [
            'name' => '/operation/coupon-template',
            'display_name' => '优惠券模板',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Coupon\CouponTemplateController::class)
          ],
          [
            'name' => '/operation/coupon',
            'display_name' => '优惠券列表',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\User\UserCouponController::class)
          ],
          [
            'name' => '/operation/coupon-market',
            'display_name' => '优惠券市场',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Coupon\CouponMarketController::class)
          ],
          [
            'name' => '/operation/coupon-order',
            'display_name' => '优惠券订单',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Coupon\CouponOrderController::class)
          ],
          [
            'name' => '/operation/task',
            'display_name' => '任务管理',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Task\TaskController::class)
          ],
          [
            'name' => '/operation/task-record',
            'display_name' => '任务记录',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Task\TaskRecordController::class)
          ]
        ]
      ],
      [
        'name' => '/user',
        'display_name' => '用户管理',
        'children' => [
          [
            'name' => '/user/admin',
            'display_name' => '企业管理',
            'children' => [
              [
                'name' => '/user/admin/employee',
                'display_name' => '员工列表',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\User\EmployeeController::class)
              ],
              [
                'name' => '/user/admin/position',
                'display_name' => '职位列表',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\User\PositionController::class, [
                  'updatePermissions' => '权限管理',
                  'updateAssignPermissions' => '权限分配'
                ])
              ]
            ]
          ],
          [
            'name' => '/user/member',
            'display_name' => '会员管理',
            'children' => [
              [
                'name' => '/user/member/user',
                'display_name' => '会员列表',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\User\UserController::class, [
                  'UserCouponController@store' => '赠送优惠券',
                  'UserBillController@index' => '账单记录',
                  'UserOrderController@index' => '订单记录'
                ])
              ],
              [
                'name' => '/user/member/role',
                'display_name' => '会员角色',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\User\RoleController::class, [
                  'updatePermissions' => '权限管理'
                ])
              ],
              [
                'name' => '/user/member/personal-auth',
                'display_name' => '个人认证',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\User\UserPersonalAuthController::class)
              ],
              [
                'name' => '/user/member/enterprise-auth',
                'display_name' => '企业认证',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\User\UserEnterpriseAuthController::class)
              ],
              [
                'name' => '/user/member/notify',
                'display_name' => '通知记录',
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Notify\NotifyController::class)
              ]
            ]
          ]
        ]
      ],
      [
        'name' => '/financial',
        'display_name' => '财务管理',
        'children' => [
          [
            'name' => '/financial/cash-apply',
            'display_name' => '提现申请',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\User\UserCashController::class)
          ],
          [
            'name' => '/financial/cash-approve',
            'display_name' => '提现审批',
            'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\User\UserCashController::class)
          ]
        ]
      ],
      [
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
                'children' => $this->getAdminPermissions(\App\Http\Controllers\Admin\Notify\NotifyUserController::class)
              ]
            ]
          ]
        ]
      ],
      [
        'name' => '/user',
        'display_name' => '基本权限',
        'children' => $this->getApiPermissions(\App\Http\Controllers\Api\User\UserController::class, [
          'login' => '登录'
        ])
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
   * @param array $options
   * @return array
   */
  private function getApiPermissions($class, $options = [])
  {
    return $this->getPermissions($class, 'api', $options);
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
          'name' => \Illuminate\Support\Str::contains('@', $method) ? $method : $controllerName.'@'.$method,
          'display_name' => $options[$method],
          'guard_name' => $guard_name
        ];
      })
      ->toArray();
  }
}
