<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAdminPost;

class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(StoreAdminPost $request)
    {
        $fields = $request->only(['name', 'password']);

        if ($this->guard()->attempt($fields, true)) {

            $this->authenticated($request);
            return redirect('admin/index');
        }

        return back()->withInput()->withErrors(['name' => '账号或者密码错误']);
    }

    public function guard($name = 'admin')
    {
        return Auth::guard($name);
    }

    public function authenticated($request)
    {
        $admin = $this->guard()->user();

        // 信任代理
        // $request->setTrustedProxies(['192.168.0.1']);
        $admin->last_ip = $request->getClientIp();
        $admin->save();
    }

    /**
     * 退出登录
     * @param Illuminate\Http\Request
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        return redirect()->route('admin.login');
    }
}
