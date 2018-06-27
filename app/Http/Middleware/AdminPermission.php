<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\ApiController;
use Closure;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 先获取当前路由名字
        $route = Route::currentRouteName();
        // 判断权限表中这条路由是否需要验证
        if ($permission = Permission::where('route', $route)->first()) {
            // 当前用户不拥有这个权限的名字 注：超级管理员拥有全部权限
            if (! auth('admin')->user()->can($permission->name) && Auth::id() > 1 ) {

                // 如果是 ajax 请求
                if ($request->ajax()) {
                    return (new ApiController())
                        ->setCode(403)
                        ->setData('权限不足，需要：' . $permission->name)
                        ->toJson();
                }


                return response()->view('hint.error', [
                    'status' => "权限不足，需要：{$permission->name}权限",
                    'url' => url('admin/admins')
                ]);
            }
        }

        return $next($request);
    }
}
