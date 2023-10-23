<?php

namespace App\Http\Middleware;

use App\Models\HolidayRequest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Widget
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $widget): Response
    {
        $route = $request->route()->getName();
        if (in_array($route, ['manager-accept-holiday-from-email', 'manager-reject-holiday-from-email'])) {
            $token = $request->route()->parameter('token');
            $holiday_request = HolidayRequest::with(['latestReply', 'manager'])
                ->where('token', $token)
                ->first();
            $r = $holiday_request['latestReply'] ?? $holiday_request;
            if (!$r || $r['status'] != 'pending' || !($manager = $holiday_request['manager'])) {
                abort(404);
            }
            auth()->login($manager);
            $request['holiday_request'] = $holiday_request;
        }
        $user = $request->user();
        $widgets = explode(',', $user['intranet']['widgets'] ?? '');
        if (!in_array($widget, $widgets)) {
            abort(404);
        }
        return $next($request);
    }
}
