<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Task
{
  /**
   * @param Request $request
   * @param Closure $next
   * @return mixed
   * @throws \Throwable
   */
  public function handle(Request $request, Closure $next)
  {
    $response = $next($request);
    $interface = Str::of($request->route()->getActionName())->after('App\Http\Controllers\\');
    (new \App\Models\Task\Task())->checkFinishTask($interface);
    return $response;
  }
}
