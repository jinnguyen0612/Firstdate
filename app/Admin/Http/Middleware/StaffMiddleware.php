<?php

namespace App\Admin\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $partner = Auth::guard('partner')->user();

                if ($partner) {
                    return $next($request);
                }
                // return $next($request);
            }
        }
        $code = $request->route('code');
        if($code) return redirect()->guest(route('partner.checkin.login', ['code' => $code]))
            ->with('error', __('Vui lòng đăng nhập để thực hiện'));
    }
}
