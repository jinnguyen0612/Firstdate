<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Chặn trang guest khi đã đăng nhập phù hợp với từng guard.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $redirect = $this->redirectUrlForGuard($guard, $request);

                // null nghĩa là không ép redirect (cho đi tiếp)
                if ($redirect !== null) {
                    return redirect()->to($redirect);
                }
            }
        }

        return $next($request);
    }

    /**
     * Quy tắc chuyển hướng theo guard + ngữ cảnh route hiện tại.
     * Trả về string URL để redirect, hoặc null nếu không redirect.
     */
    protected function redirectUrlForGuard(?string $guard, Request $request): ?string
    {
        switch ($guard) {
            case 'admin': {
                $admin = Auth::guard('admin')->user();
                if (method_exists($admin, 'hasRole') && $admin->hasRole('subAdmin')) {
                    // subAdmin dùng khu partner
                    return route('home.index'); // từ nhóm BookingController
                }
                // admin thường
                return route('admin.dashboard');
            }

            case 'partner': {
                // Staff chỉ cần redirect khỏi trang login staff -> sang trang staff tương ứng code
                // Các trang guest:partner khác (public checkin) cho đi tiếp để tránh loop
                if ($request->routeIs('checkin.login')) {
                    $code = $request->route('code'); // từ /checkin/{code}/staff/login
                    if ($code) {
                        return route('staff', ['code' => $code]); // /checkin/{code}/staff
                    }
                }
                // Không ép redirect trong các trường hợp khác
                return null;
            }

            case 'user': {
                // Không,ep redirect trong các truong hợp khác
                return null;
            }

            default: {
                // Guard mặc định (web) hoặc khác -> đẩy về trang user (nếu bạn có dùng)
                return route('user.auth.indexUser');
            }
        }
    }
}
