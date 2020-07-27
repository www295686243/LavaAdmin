<?php

use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $dispatcher = \App\Models\Config::getEventDispatcher();
    \App\Models\Config::unsetEventDispatcher();

    $systemOptions = config('options.system');
    foreach ($systemOptions as $data) {
      \App\Models\Config::updateOrCreate(
        ['name' => $data['name']],
        $data
      );
    }
    (new \App\Models\Version())->updateOrCreateVersion('system', '系统配置');

    $tableOptions = config('options.table-options');
    foreach ($tableOptions as $table) {
      foreach ($table['fields'] as $field) {
        $tableData = \App\Models\Config::updateOrCreate(
          ['name' => $field['name'], 'guard_name' => 'options.'.$table['name']],
          ['display_name' => $table['display_name'].'-'.$field['display_name']]
        );
        foreach ($field['options'] as $option) {
          $tableData->options()->updateOrCreate(
            ['display_name' => $option]
          );
        }
        $tableData->options()->whereNotIn('display_name', $field['options'])->delete();
        (new \App\Models\Version())->updateOrCreateVersion($tableData->guard_name, $tableData->display_name);
      }
    }

    \App\Models\Config::setEventDispatcher($dispatcher);
  }
}
