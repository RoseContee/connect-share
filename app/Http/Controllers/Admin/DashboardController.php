<?php

namespace App\Http\Controllers\Admin;

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
        $installedDomains = Domain::installed()->count();
        $totalUsers = User::count();
        return view('admin.dashboard', [
            'installedDomains' => $installedDomains,
            'totalUsers' => $totalUsers,
        ]);
    }
}
