<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Services\ResourceService;
use Closure;

class InterfacePermission
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $guard = $request->route()->getPrefix();
    $permission = class_basename($request->route()->getActionName());
    $userData = auth()->user();
    $permissionNames = Permission::getAllPermissionNames($guard);
    if (
      $userData &&
      ($userData->hasRole('root') || $userData->can($permission) || !$permissionNames->contains($permission))
    ) {
      return $next($request);
    }
    return (new ResourceService())->setStatusCode(423)->error('您没有该权限');
  }
}
