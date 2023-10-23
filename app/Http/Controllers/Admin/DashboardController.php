<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Widgets;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private string $menu = 'Dashboard';

    public function __construct() {
        view()->share('menu', $this->menu);
    }

    public function index() {
        $installedDomains = $activeDomains = 0;
        $domains = Domain::where('status', '<>', 'pending')->get();
        foreach ($domains as $domain) {
            if ($domain['installed']) $installedDomains++;
            if ($domain['status'] == 'active') $activeDomains++;
        }
        $totalUsers = User::count();
        $allWidgets = Widgets::getAllWidgets();
        $widgets = [];
        foreach ($allWidgets as $key => $w) {
            $widgets[$w] = 0;
            foreach ($domains as $domain) {
                if (in_array($key, explode(',', $domain['widgets']))) {
                    $widgets[$w]++;
                }
            }
        }
        $totalWidgets = count($widgets);
        return view('admin.dashboard', [
            'installedDomains' => $installedDomains,
            'totalUsers' => $totalUsers,
            'totalWidgets' => $totalWidgets,
            'activeDomains' => $activeDomains,
            'widgets' => $widgets,
        ]);
    }
}
