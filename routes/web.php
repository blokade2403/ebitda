<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Ebitda\ExpenseController;
use App\Http\Controllers\Ebitda\FinancialTargetController;
use App\Http\Controllers\Ebitda\MedicalServiceController;
use App\Http\Controllers\Ebitda\PatientTargetController;
use App\Http\Controllers\Ebitda\PatientVisitController;
use App\Http\Controllers\Ebitda\ReportController;
use App\Http\Controllers\Ebitda\RevenueController;
use App\Http\Controllers\Ebitda\TargetExpenseAdminController;
use App\Http\Controllers\Ebitda\TargetExpenseController;
use App\Http\Controllers\Ebitda\TargetRevenueAdminController;
use App\Http\Controllers\MasterBackend\Ebitda\ExpenseCategoryController;
use App\Http\Controllers\MasterBackend\Ebitda\RevenueCategoryController;
use App\Http\Controllers\MasterBackend\SettingUser\FaseController;
use App\Http\Controllers\MasterBackend\SettingUser\PositionController;
use App\Http\Controllers\MasterBackend\SettingUser\RoleController;
use App\Http\Controllers\MasterBackend\SettingUser\RoleUserController;
use App\Http\Controllers\MasterBackend\SettingUser\UnitController;
use App\Http\Controllers\MasterBackend\UserProfil\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('layouts-login.main');
// });

Route::controller(AuthController::class)->group(function () {
    Route::get('/', function () {
        return redirect()->route('login.form');
    });
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('setting-user')->group(function () {
        Route::resource('fases', FaseController::class);
        Route::resource('units', UnitController::class);
        Route::resource('users', UserController::class);
        Route::resource('positions', PositionController::class);
        // Route::resource('roles', RoleController::class);
        Route::resource('roles', RoleController::class);
        Route::get('role-user', [RoleUserController::class, 'index'])->name('role_user.index');
        Route::post('role-user/assign', [RoleUserController::class, 'assign'])->name(
            'role_user.assign',
        );
        Route::delete('role-user/{user}/{role}', [RoleUserController::class, 'remove'])->name(
            'role_user.remove',
        );
    });

    Route::prefix('ebitda')->group(function () {
        Route::resource('financial-targets', FinancialTargetController::class);
        Route::get('/revenues', [RevenueController::class, 'index'])->name('revenues.index');
        Route::post('/revenues', [RevenueController::class, 'store'])->name('revenues.store');
        Route::delete('/revenues/{id}', [RevenueController::class, 'destroy'])->name('revenues.destroy');

        Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
        Route::post(
            '/expense-category/import',
            [ExpenseCategoryController::class, 'importExpenseCategory']
        )->name('expense-category.import');

        Route::get('/target-expenses', [TargetExpenseController::class, 'index'])->name('target_expenses.index');
        Route::post('/target-expenses', [TargetExpenseController::class, 'store'])->name('target_expenses.store');
        Route::delete('/target-expenses/{id}', [TargetExpenseController::class, 'destroy'])->name('target_expenses.destroy');

        Route::get('/report/revenue-unit', [ReportController::class, 'revenuePerUnit']);
        Route::get('/report/expense-category', [ReportController::class, 'expensePerCategory']);
        Route::get('/report/finance-hierarchy', [ReportController::class, 'financeHierarchy'])->name('financeHierarchy');
        Route::get('/report/finance-unit', [ReportController::class, 'financePerUnit'])->name('financePerUnit');
        Route::get('/finance-report/download', [ReportController::class, 'downloadFinanceReport'])
            ->name('finance.report.download');
        Route::get('/exportExcel/download', [ReportController::class, 'exportExcel'])
            ->name('exportExcel.download');
    });

    Route::prefix('visits')->group(function () {
        Route::get('/', [PatientVisitController::class, 'index'])->name('visits.index');
        Route::post('/store', [PatientVisitController::class, 'store'])->name('visits.store');
    });

    Route::prefix('targets')->group(function () {
        Route::get('/', [PatientTargetController::class, 'index'])->name('targets.index');
        Route::post('/store', [PatientTargetController::class, 'store'])->name('targets.store');
    });

    Route::prefix('finance')->group(function () {
        Route::get('/daily/{tanggal}', [PatientVisitController::class, 'dailyFinance'])
            ->name('finance.daily');
    });

    Route::prefix('expense-categories')->group(function () {
        Route::get('/', [ExpenseCategoryController::class, 'index'])->name('expense_categories.index');
        Route::post('/store', [ExpenseCategoryController::class, 'store'])->name('expense_categories.store');
        Route::put('/update/{id}', [ExpenseCategoryController::class, 'update'])->name('expense_categories.update');
        Route::delete('/delete/{id}', [ExpenseCategoryController::class, 'destroy'])->name('expense_categories.destroy');
    });

    Route::prefix('revenue-categories')->group(function () {
        Route::get('/', [RevenueCategoryController::class, 'index'])->name('revenue_categories.index');
        Route::post('/store', [RevenueCategoryController::class, 'store'])->name('revenue_categories.store');
        Route::put('/update/{id}', [RevenueCategoryController::class, 'update'])->name('revenue_categories.update');
        Route::delete('/delete/{id}', [RevenueCategoryController::class, 'destroy'])->name('revenue_categories.destroy');
    });

    Route::prefix('medical-services')->group(function () {
        Route::get('/', [MedicalServiceController::class, 'index'])->name('medical_services.index');
        Route::post('/store', [MedicalServiceController::class, 'store'])->name('medical_services.store');
        Route::put('/update/{id}', [MedicalServiceController::class, 'update'])->name('medical_services.update');
        Route::delete('/delete/{id}', [MedicalServiceController::class, 'destroy'])->name('medical_services.destroy');
        Route::post('/medical-services/import', [MedicalServiceController::class, 'importMedicalService'])
            ->name('medical-services.import');
    });
});
