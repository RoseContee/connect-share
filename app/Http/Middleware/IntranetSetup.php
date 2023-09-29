<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IntranetSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = auth()->user();
        if ($user['is_admin']) {
            $intranet = $user['intranet'];
            if ($role === 'admin') {
                $route = $request->route()->getName();
                if (empty($intranet['installed'])) {
                    if (stripos($route, 'intranet.setup.users') === false) {
                        return redirect()->route('intranet.setup.users');
                    }
                } else if ($intranet['installed'] == 1) {
                    if (stripos($route, 'intranet.setup.complete') === false) {
                        return redirect()->route('intranet.setup.complete');
                    }
                } else {
                    return redirect()->route(RouteServiceProvider::HOME);
                }
            } else if (($intranet['installed'] ?? 0) < 2) {
                return redirect()->route('intranet.setup');
            }
        } else if ($role === 'admin') {
            return redirect()->route(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
