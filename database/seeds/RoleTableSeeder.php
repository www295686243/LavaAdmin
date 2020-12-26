<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
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
        'name' => 'root',
        'display_name' => 'Root',
        'platform' => 'admin',
        'children' => [
          [
            'name' => 'Operations Manager',
            'display_name' => '运营经理',
            'platform' => 'admin',
            'children' => [
              [
                'name' => 'Customer service Specialist',
                'display_name' => '客服专员',
                'platform' => 'admin'
              ],
              [
                'name' => 'Operation Specialist',
                'display_name' => '运营专员',
                'platform' => 'admin'
              ],
              [
                'name' => 'Information Specialist',
                'display_name' => '信息专员',
                'platform' => 'admin'
              ],
              [
                'name' => 'Finance Specialist',
                'display_name' => '财务专员',
                'platform' => 'admin'
              ]
            ]
          ],
          [
            'name' => 'Technical Manager',
            'display_name' => '技术经理',
            'platform' => 'admin',
            'children' => [
              [
                'name' => 'Technical Assistant',
                'display_name' => '技术助理',
                'platform' => 'admin'
              ]
            ]
          ]
        ]
      ],
      [
        'name' => 'Personal Member',
        'display_name' => '个人会员',
        'platform' => 'api'
      ],
      [
        'name' => 'Enterprise Member',
        'display_name' => '企业会员',
        'platform' => 'api'
      ],
      [
        'name' => 'Personal Auth',
        'display_name' => '个人认证',
        'platform' => 'api'
      ],
      [
        'name' => 'Enterprise Auth',
        'display_name' => '企业认证',
        'platform' => 'api'
      ],
      [
        'name' => 'VIP1 Member',
        'display_name' => 'VIP1',
        'platform' => 'api'
      ],
      [
        'name' => 'VIP2 Member',
        'display_name' => 'VIP2',
        'platform' => 'api'
      ],
      [
        'name' => 'VIP3 Member',
        'display_name' => 'VIP3',
        'platform' => 'api'
      ]
    ];

    \App\Models\Role::rebuildTree($data);
  }
}
