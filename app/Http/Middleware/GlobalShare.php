<?php

namespace App\Http\Middleware;

use App\Helpers\Widgets;
use App\Models\Domain;
use App\Models\HolidayRequest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GlobalShare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') && !$request->expectsJson() && $user = $request->user()) {
            if ($request->routeIs('admin.*')) {
                $request['domain_request_number'] = Domain::pending()->count();
            } else {
                $widgets = explode(',', $user['intranet']['widgets'] ?? '');
                if (in_array(Widgets::HOLIDAY_REQUEST, $widgets)) {
                    $holiday_requests = HolidayRequest::with(['latestReply', 'user'])
                        ->where('manager_id', $request->user()->google_id)
                        ->where('status', '<>', 'approved')
                        ->whereNull('parent')
                        ->orderBy('period')
                        ->get();
                    $holiday_requests_number = 0;
                    foreach ($holiday_requests as $holiday_request) {
                        $r = $holiday_request['latestReply'] ?? $holiday_request;
                        if ($r['status'] == 'pending') $holiday_requests_number++;
                    }
                    $request['holiday_requests'] = $holiday_requests;
                    $request['holiday_requests_number'] = $holiday_requests_number;
                    $request['user_members_number'] = $user->members()->count();
                }
            }
        }
        return $next($request);
    }
}
