<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->routeIs('api.*')) {
                return response()->json([
                    'status' => 401,
                    'message' => __('Xác thực không thành công.')
                ], 401);
            }
            return route('login');
        }
    }
}
