<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Task
{
  /**
   * @param Request $request
   * @param Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    $response = $next($request);
    $interface = class_basename($request->route()->getActionName());
    (new \App\Models\Task\Task())->checkFinishTask($interface);
    return $response;
  }
}
