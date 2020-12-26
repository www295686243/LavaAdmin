<?php
use App\Models\AdminMenu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleHasPermissionsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // 运营经理
    $OperationsManager = Role::where('name', 'Operations Manager')->first();
    $OperationsManager->menu_permissions = AdminMenu::whereNotIn('route', ['/system', '/system/admin-log', '/system/version'])->pluck('id');
    $OperationsManager->save();
    $OperationsManager->syncPermissions(Permission::whereNotIn('name', [
      '/system',
      '/system/admin-log',
      'AdminLogController@index',
      '/system/version',
      'VersionController@index',
      'VersionController@show',
      'VersionController@update',
      'PositionController@updateAssignPermissions',
      'RoleController@updateAssignPermissions'
    ])->pluck('name'));
    // 技术经理
    $TechnicalManager = Role::where('name', 'Technical Manager')->first();
    $TechnicalManager->menu_permissions = AdminMenu::whereNotIn('route', ['/system', '/system/admin-log', '/system/version'])->pluck('id');
    $TechnicalManager->save();
    $TechnicalManager->syncPermissions(Permission::whereNotIn('name', [
      '/system',
      '/system/admin-log',
      'AdminLogController@index',
      '/system/version',
      'VersionController@index',
      'VersionController@show',
      'VersionController@update',
      'PositionController@updateAssignPermissions',
      'RoleController@updateAssignPermissions'
    ])->pluck('name'));
    // 信息专员
    $InformationSpecialist = Role::where('name', 'Information Specialist')->first();
    $InformationSpecialist->menu_permissions = AdminMenu::whereIn('route', [
      '/hr/job/info-check',
      '/hr/job/list',
      '/hr/job/info-provide',
      '/hr/job/info-complaint',
      '/hr/job/info-delivery',
      '/hr/resume/info-check',
      '/hr/resume/list',
      '/hr/resume/info-provide',
      '/hr/resume/info-complaint',
      '/hr/resume/info-delivery',
    ])->pluck('id');
    $InformationSpecialist->save();
    $InformationSpecialist->syncPermissions(Permission::whereIn('name', [
      'HrJobInfoCheckController@index',
      'HrJobInfoCheckController@show',
      'HrJobInfoCheckController@update',
      'HrJobController@index',
      'HrJobController@store',
      'HrJobController@show',
      'HrJobController@update',
      'HrJobController@transfer',
      'HrJobController@push',
      'HrJobInfoProvideController@index',
      'HrJobInfoProvideController@store',
      'HrJobInfoProvideController@show',
      'HrJobInfoProvideController@update',
      'HrJobInfoComplaintController@index',
      'HrJobInfoComplaintController@show',
      'HrJobInfoComplaintController@update',
      'HrJobInfoDeliveryController@index',
      'HrResumeInfoCheckController@index',
      'HrResumeInfoCheckController@show',
      'HrResumeInfoCheckController@update',
      'HrResumeController@index',
      'HrResumeController@store',
      'HrResumeController@show',
      'HrResumeController@update',
      'HrResumeController@transfer',
      'HrResumeController@push',
      'HrResumeInfoProvideController@index',
      'HrResumeInfoProvideController@store',
      'HrResumeInfoProvideController@show',
      'HrResumeInfoProvideController@update',
      'HrResumeInfoComplaintController@index',
      'HrResumeInfoComplaintController@show',
      'HrResumeInfoComplaintController@update',
      'HrResumeInfoDeliveryController@index',
    ])->pluck('name'));
    // 客服专员
    $CustomerServiceSpecialist = Role::where('name', 'Customer service Specialist')->first();
    $CustomerServiceSpecialist->menu_permissions = AdminMenu::whereIn('route', [
      '/hr/job/info-check',
      '/hr/job/list',
      '/hr/job/info-provide',
      '/hr/job/info-complaint',
      '/hr/job/info-delivery',
      '/hr/resume/info-check',
      '/hr/resume/list',
      '/hr/resume/info-provide',
      '/hr/resume/info-complaint',
      '/hr/resume/info-delivery',
      '/user/member/user'
    ])->pluck('id');
    $CustomerServiceSpecialist->save();
    $CustomerServiceSpecialist->syncPermissions(Permission::whereIn('name', [
      'HrJobInfoCheckController@index',
      'HrJobInfoCheckController@show',
      'HrJobInfoCheckController@update',
      'HrJobController@index',
      'HrJobController@store',
      'HrJobController@show',
      'HrJobController@update',
      'HrJobController@transfer',
      'HrJobController@push',
      'HrJobInfoProvideController@index',
      'HrJobInfoProvideController@store',
      'HrJobInfoProvideController@show',
      'HrJobInfoProvideController@update',
      'HrJobInfoComplaintController@index',
      'HrJobInfoComplaintController@show',
      'HrJobInfoComplaintController@update',
      'HrJobInfoDeliveryController@index',
      'HrResumeInfoCheckController@index',
      'HrResumeInfoCheckController@show',
      'HrResumeInfoCheckController@update',
      'HrResumeController@index',
      'HrResumeController@store',
      'HrResumeController@show',
      'HrResumeController@update',
      'HrResumeController@transfer',
      'HrResumeController@push',
      'HrResumeInfoProvideController@index',
      'HrResumeInfoProvideController@store',
      'HrResumeInfoProvideController@show',
      'HrResumeInfoProvideController@update',
      'HrResumeInfoComplaintController@index',
      'HrResumeInfoComplaintController@show',
      'HrResumeInfoComplaintController@update',
      'HrResumeInfoDeliveryController@index',
      'UserController@index',
      'UserController@show'
    ])->pluck('name'));
  }
}
