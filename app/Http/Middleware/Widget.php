<?php

namespace App\Http\Middleware;

use App\Models\Widgets\HolidayRequest as WidgetHolidayRequest;
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
        if (
            in_array($request->route()->getName(), [
                'widget.holiday-approvals.accept-from-email', 'widget.holiday-approvals.reject-from-email'
            ])
        ) {
            $token = $request->route()->parameter('token');
            $holiday_request = WidgetHolidayRequest::with(['latestReply', 'manager'])
                ->where('token', $token)
                ->first();
            $r = $holiday_request['latestReply'] ?? $holiday_request;
            if (!$r || $r['status'] != 'pending' || !($manager = $holiday_request['manager'])) {
                abort(404);
            }
            auth()->login($manager);
            $request['holiday_request'] = $holiday_request;
        }
        if (!$request->user()->hasWidget($widget)) {
            abort(404);
        }
        return $next($request);
    }
}
