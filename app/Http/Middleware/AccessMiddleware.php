<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $routeName = $request->route()->getName();
        $permission = Permission::where('route_name', $routeName)->first();

        // dd($user, $routeName, $permission, $user->can($permission->name));
        if ($permission && $user->can($permission->name)) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
