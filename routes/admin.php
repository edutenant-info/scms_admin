<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Masters\Academic\AcademicYearController;
use App\Http\Controllers\Admin\Masters\Academic\CombinationController;
use App\Http\Controllers\Admin\Masters\Academic\ElectiveController;
use App\Http\Controllers\Admin\Masters\Academic\SectionController;
use App\Http\Controllers\Admin\Masters\Academic\SemesterController;
use App\Http\Controllers\Admin\Masters\Academic\StandardController;
use App\Http\Controllers\Admin\Masters\Academic\StreamController;
use App\Http\Controllers\Admin\Masters\Academic\SubjectController;
use App\Http\Controllers\Admin\Masters\Demographic\BloodGroupController;
use App\Http\Controllers\Admin\Masters\Demographic\CasteController;
use App\Http\Controllers\Admin\Masters\Demographic\LanguageController;
use App\Http\Controllers\Admin\Masters\Demographic\NationalityController;
use App\Http\Controllers\Admin\Masters\Demographic\ReligionController;
use App\Http\Controllers\Admin\Masters\Fees\FeeTypeController;
use App\Http\Controllers\Admin\Masters\Fees\GeneralCategoryController;
use App\Http\Controllers\Admin\Masters\Fees\MasterCategoryController;
use App\Http\Controllers\Admin\Masters\Mappings\InstitutionAcademicYearController;
use App\Http\Controllers\Admin\Masters\Mappings\InstitutionFeeTypeController;
use App\Http\Controllers\Admin\Modules\Institution\InstitutionController;
use App\Http\Controllers\Admin\Modules\Organisation\OrganisationController;
use App\Http\Controllers\Admin\Settings\BoardController;
use App\Http\Controllers\Admin\Settings\DashboardTemplateController;
use App\Http\Controllers\Admin\Settings\InstitutionTypeController;
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

    // Settings → Institution lookups (used by the institution onboarding dropdowns).
    Route::resource('/institution-types', InstitutionTypeController::class)->except('show');
    Route::resource('/boards', BoardController::class)->except('show');

    // Master's → Academic lookups (CRUD, mirrors the Boards pattern).
    Route::resource('/subjects', SubjectController::class)->except('show');
    Route::resource('/electives', ElectiveController::class)->except('show');
    Route::resource('/streams', StreamController::class)->except('show');
    Route::resource('/combinations', CombinationController::class)->except('show');
    Route::resource('/standards', StandardController::class)->except('show');
    Route::resource('/semesters', SemesterController::class)->except('show');
    Route::resource('/sections', SectionController::class)->except('show');
    Route::resource('/academic-years', AcademicYearController::class)->except('show');

    // Master's → Demographic lookups (CRUD, mirrors the Boards pattern).
    Route::resource('/castes', CasteController::class)->except('show');
    Route::resource('/religions', ReligionController::class)->except('show');
    Route::resource('/blood-groups', BloodGroupController::class)->except('show');
    Route::resource('/nationalities', NationalityController::class)->except('show');
    Route::resource('/languages', LanguageController::class)->except('show');

    // Master's → Fees lookups (CRUD, mirrors the Boards pattern).
    Route::resource('/fee-types', FeeTypeController::class)->except('show');
    Route::resource('/master-categories', MasterCategoryController::class)->except('show');
    Route::resource('/general-categories', GeneralCategoryController::class)->except('show');

    // Master's → Mappings (institution-scoped lookup assignments).
    Route::resource('/institution-academic-years', InstitutionAcademicYearController::class)->except('show');
    Route::resource('/institution-fee-types', InstitutionFeeTypeController::class)->except('show');

    // UI reference → reusable form components showcase.
    Route::view('/form-elements', 'admin.reference.form-elements')->name('form-elements');
    Route::view('/data-tables', 'admin.reference.data-tables')->name('data-tables');

    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::get('password', function() {
    dd(Hash::make("12345678"));
});