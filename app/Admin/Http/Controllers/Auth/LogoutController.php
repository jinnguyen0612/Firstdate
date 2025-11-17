<?php

namespace App\Admin\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use App\Enums\Role\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    //
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if (Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->hasRole(Role::SubAdmin->value)) {
                Auth::guard('admin')->logout();
                return to_route('partner.login')->with('success', __('Bạn đã đăng xuất thành công.'));
            }
            Auth::guard('admin')->logout();
            return to_route('admin.login.index')->with('success', __('Bạn đã đăng xuất thành công.'));
        }
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return to_route('user.index')->with('success', __('Bạn đã đăng xuất thành công.'));
        }
        if (Auth::guard('partner')->check()) {
            Auth::guard('partner')->logout();
            return to_route('partner.login')->with('success', __('Bạn đã đăng xuất thành công.'));
        }
    }
}
