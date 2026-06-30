<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Modules\Institution\InstitutionController;
use App\Http\Controllers\Admin\Modules\Organisation\OrganisationController;
use App\Http\Controllers\Admin\Settings\DashboardTemplateController;
use App\Http\Controllers\Admin\Settings\LoginTemplateController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These routes are loaded with the "admin" URI prefix and the "admin."
| route-name prefix (see bootstrap/app.php). Use bare names here — the
| prefix is applied automatically, so name('login') => "admin.login".
|
*/

// Guest routes (not authenticated as admin).
Route::middleware('guest:admin')->group(function () {
    Route::get('/', [AdminAuthController::class, 'showLogin'])->name('home');
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.attempt');
});

// Authenticated admin routes.
Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Modules → Organisation CRUD.
    // Route::resource('/organisations', OrganisationController::class);
    //Route::get('/organisations', [OrganisationController::class, 'index'])->name('organisations.index');
    Route::resource('/organisations', OrganisationController::class);
    Route::resource('/institutions', InstitutionController::class);

    // Settings → Template CRUD (used by the organisation onboarding dropdowns).
    Route::resource('/login-templates', LoginTemplateController::class)->except('show');
    Route::resource('/dashboard-templates', DashboardTemplateController::class)->except('show');

    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::get('password', function() {
    dd(Hash::make("12345678"));
});