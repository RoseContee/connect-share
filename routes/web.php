<?php

use App\Helpers\Widgets;
use App\Http\Controllers\User\AuthController as UserAuth;
use App\Http\Controllers\User\AuthGoogleController as GoogleAuth;
use App\Http\Controllers\User\IntranetSetupController as IntranetSetup;
use App\Http\Controllers\User\HomeController as UserHome;
use App\Http\Controllers\User\PeopleController as UserPeople;
use App\Http\Controllers\User\LinkController as UserUsefulLink;
use App\Http\Controllers\User\DocumentController as UserDocument;
use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DomainController as AdminDomain;
use App\Http\Controllers\Admin\ShortcutController as AdminShortcut;
use App\Http\Controllers\Admin\SettingsController as AdminSettings;
use App\Http\Controllers\Admin\ProfileController as AdminProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\Widgets\HolidayRequestController as WidgetHolidayRequest;
use App\Http\Controllers\User\Widgets\HolidayApprovalController as WidgetHolidayApproval;
use App\Http\Controllers\User\Widgets\WeatherController as WidgetWeather;
use App\Http\Controllers\User\Widgets\AlertsController as WidgetAlerts;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
], function () {
    Route::group([
        'middleware' => ['guest'],
    ], function () {
        Route::get('login', [UserAuth::class, 'login'])
            ->name('login');
        Route::get('auth/google', [GoogleAuth::class, 'login'])
            ->name('auth.google');
        Route::get('auth/google/callback', [GoogleAuth::class, 'callback'])
            ->name('auth.google.callback');
    });

    Route::group([
        'middleware' => ['auth'],
    ], function () {
        Route::group([
            'middleware' => ['intranet.setup:admin'],
            'prefix' => 'intranet/setup',
        ], function () {
            Route::get('/', function () {
                return redirect()->route('intranet.setup.users');
            })->name('intranet.setup');
            Route::get('users', [IntranetSetup::class, 'users'])
                ->name('intranet.setup.users');
            Route::post('users', [IntranetSetup::class, 'installUsers'])
                ->name('intranet.setup.users.install');
            Route::get('complete', [IntranetSetup::class, 'complete'])
                ->name('intranet.setup.complete');
        });

        Route::group([
            'middleware' => ['intranet.setup:all'],
        ], function () {
            Route::get('/', [UserHome::class, 'index'])
                ->name('home');
            Route::get('profile', [UserHome::class, 'profile'])
                ->name('profile');
            Route::get('storage-usage', [UserHome::class, 'storageUsage'])
                ->name('storage-usage');

            Route::get('members', [UserPeople::class, 'members'])
                ->name('members');
            Route::get('organization', [UserPeople::class, 'organization'])
                ->name('organization');
            Route::delete('organization', [UserPeople::class, 'removeOrganization']);

            Route::resources([
                'useful-links' => UserUsefulLink::class,
                'documents' => UserDocument::class,
            ]);
        });

        Route::get('logout', function (Request $request) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        })->name('logout');
    });

    Route::group([
        'prefix' => 'widget',
        'as' => 'widget.',
    ], function () {
        Route::group([
            'middleware' => 'widget:'.Widgets::HOLIDAY_REQUEST,
        ], function () {
            Route::get('manager-accept-holiday/{token}', [WidgetHolidayApproval::class, 'acceptFromEmail'])
                ->name('manager-accept-holiday-from-email');
            Route::get('manager-reject-holiday/{token}', [WidgetHolidayApproval::class, 'rejectFromEmail'])
                ->name('manager-reject-holiday-from-email');

            Route::group([
                'middleware' => ['auth', 'intranet.setup:all'],
            ], function () {
                Route::get('holiday-requests', [WidgetHolidayRequest::class, 'index'])
                    ->name('holiday-requests');
                Route::get('new-holiday-request', [WidgetHolidayRequest::class, 'send'])
                    ->name('new-holiday-request');
                Route::post('new-holiday-request', [WidgetHolidayRequest::class, 'submit']);
                Route::get('holiday-requests/{id}/resend', [WidgetHolidayRequest::class, 'resend'])
                    ->name('resend-holiday-request');
                Route::post('holiday-requests/{id}/resend', [WidgetHolidayRequest::class, 'resubmit']);
                Route::delete('holiday-requests', [WidgetHolidayRequest::class, 'destroy'])
                    ->name('delete-holiday-request');

                Route::get('holiday-approvals', [WidgetHolidayApproval::class, 'index'])
                    ->name('holiday-approvals');
                Route::put('holiday-accept', [WidgetHolidayApproval::class, 'accept'])
                    ->name('holiday-accept');
                Route::get('holiday-reject/{id}/reply', [WidgetHolidayApproval::class, 'rejectForm'])
                    ->name('holiday-reject');
                Route::put('holiday-reject/{id}/reply', [WidgetHolidayApproval::class, 'reject']);
            });
        });

        Route::group([
            'middleware' => ['auth', 'widget:'.Widgets::WEATHER],
        ], function () {
            Route::get('weather/cities', [WidgetWeather::class, 'cities'])
                ->name('weather-cities');
        });

        Route::group([
            'middleware' => ['auth', 'widget:'.Widgets::ALERTS],
        ], function () {
            Route::get('alerts', [WidgetAlerts::class, 'index'])
                ->name('alerts');
            Route::get('alerts/auth/google', [WidgetAlerts::class, 'login'])
                ->name('alerts.auth.google');
            Route::get('alerts/auth/google/callback', [WidgetAlerts::class, 'callback'])
                ->name('alerts.auth.google.callback');
            Route::delete('alerts', [WidgetAlerts::class, 'destroy']);
        });
    });
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
 */
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {
    Route::group([
        'middleware' => ['guest:admin'],
    ], function () {
        Route::get('login', [AdminAuth::class, 'login'])
            ->name('login');
        Route::post('login', [AdminAuth::class, 'postLogin']);
        Route::get('forgot-password', [AdminAuth::class, 'forgot'])
            ->name('password.forgot');
        Route::post('forgot-password', [AdminAuth::class, 'postForgot']);
        Route::get('reset-password/{token}', [AdminAuth::class, 'reset'])
            ->name('password.reset');
        Route::post('reset-password', [AdminAuth::class, 'postReset'])
            ->name('password.update');
    });

    Route::group([
        'middleware' => ['auth:admin'],
    ], function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        })->name('home');
        Route::get('dashboard', [AdminDashboard::class, 'index'])
            ->name('dashboard');

        Route::resources([
            'domains' => AdminDomain::class,
            'shortcuts' => AdminShortcut::class
        ]);
        Route::get('domains/request/{token}', [AdminDomain::class, 'editRequest'])
            ->name('domains.request');

        Route::resource('settings', AdminSettings::class)->only(['index', 'store']);
        Route::post('update-theme', [AdminSettings::class, 'updateTheme'])
            ->name('update-theme');
        Route::post('update-show-shortcuts', [AdminSettings::class, 'updateShowShortcuts'])
            ->name('update-show-shortcuts');

        Route::get('profile', [AdminProfile::class, 'index'])
            ->name('profile');
        Route::post('update-email', [AdminProfile::class, 'updateEmail'])
            ->name('update-email');
        Route::post('update-password', [AdminProfile::class, 'updatePassword'])
            ->name('update-password');

        Route::get('logout', function (Request $request) {
            auth('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login');
        })->name('logout');
    });
});
