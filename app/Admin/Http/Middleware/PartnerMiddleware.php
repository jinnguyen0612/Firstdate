<?php

namespace App\Admin\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class PartnerMiddleware extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $admin = Auth::guard('admin')->user();

                if ($admin->hasRole('subAdmin')) {
                    return $next($request);
                }
                // return $next($request);
            }
        }

        return redirect()->guest(route('partner.login'))
            ->with('error', __('Vui lòng đăng nhập để thực hiện'));
    }
}
