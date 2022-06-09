<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AnnualLeaveController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ContractExtensionController;
use App\Http\Controllers\PaySalarieController;
use App\Http\Controllers\TimesheetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [HomeController::class, 'login'])->name('login');
    Route::post('/dang-nhap', [HomeController::class, 'doLogin'])->name('do_login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/dang-xuat', [HomeController::class, 'logout'])->name('logout');

    Route::prefix('nguoi-dung')->group(function () {
        Route::name('user.')->group(function () {
            Route::group(['middleware' => ['role_or_permission:Super Admin|Thêm mới người dùng']], function () { 
                Route::get('/them-moi', [UserController::class, 'create'])->name('create');
                Route::post('/them-moi', [UserController::class, 'store'])->name('store');
            }); 

            Route::group(['middleware' => ['role_or_permission:Super Admin|Cập nhật người dùng']], function () { 
                Route::get('/cap-nhat/{id}', [UserController::class, 'edit'])->name('edit');
                Route::post('/cap-nhat', [UserController::class, 'update'])->name('update');
            }); 
            Route::group(['middleware' => ['role_or_permission:Super Admin|Xoá người dùng']], function () { 
                Route::post('/xoa', [UserController::class, 'destroy'])->name('destroy');

            }); 
            Route::get('/', [UserController::class, 'index'])->name('list');
            Route::get('/load-ajax-list-user', [UserController::class, 'loadAjaxListUser'])->name('load_ajax_list_user');
            Route::get('/load-filter-user', [UserController::class, 'loadFilterUser'])->name('load_filter_user');
        });
    });

    Route::prefix('phan-quyen')->group(function () {
        Route::name('role.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('list');
            Route::get('/them-moi', [RoleController::class, 'create'])->name('create');
            Route::post('/them-moi', [RoleController::class, 'store'])->name('store');
            Route::post('/xoa', [RoleController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [RoleController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [RoleController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-role', [RoleController::class, 'loadAjaxListRole'])->name('load_ajax_list_role');
        });
    });

    Route::prefix('tai-khoan')->group(function () {
        Route::name('account.')->group(function () {
            Route::get('/cap-nhat/{id}', [AccountController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat/{id}', [AccountController::class, 'update'])->name('update');
            Route::get('/cap-nhat/mat-khau/{id}', [AccountController::class, 'edit_pass'])->name('edit_pass');
            Route::post('/cap-nhat/mat-khau/{id}', [AccountController::class, 'update_pass'])->name('update_pass');
        });
    });

    Route::prefix('phong-ban')->group(function () {
        Route::name('department.')->group(function () {
            Route::get('/', [DepartmentController::class, 'index'])->name('list');
            Route::get('/them-moi', [DepartmentController::class, 'create'])->name('create');
            Route::post('/them-moi', [DepartmentController::class, 'store'])->name('store');
            Route::post('/xoa', [DepartmentController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [DepartmentController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [DepartmentController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-department', [DepartmentController::class, 'loadAjaxListDepartment'])->name('load_ajax_list_department');
        });
    });

    Route::prefix('nghi-phep')->group(function () {
        Route::name('annual_leave.')->group(function () {
            Route::get('/', [AnnualLeaveController::class, 'index'])->name('list');
            Route::get('/them-moi', [AnnualLeaveController::class, 'create'])->name('create');
            Route::post('/them-moi', [AnnualLeaveController::class, 'store'])->name('store');
            Route::post('/xoa', [AnnualLeaveController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [AnnualLeaveController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [AnnualLeaveController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-annual-leave', [AnnualLeaveController::class, 'loadAjaxListAnnualLeave'])->name('load_ajax_list_annual_leave');
        });
    });
    Route::prefix('hop-dong')->group(function () {
        Route::name('contracts.')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('list');
            Route::get('/them-moi', [ContactController::class, 'create'])->name('create');
            Route::post('/them-moi', [ContactController::class, 'store'])->name('store');
            Route::post('/xoa', [ContactController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [ContactController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [ContactController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-contract', [ContactController::class, 'loadAjaxListContract'])->name('load_ajax_list_contracts');
            Route::get('/gia-han/{id}', [ContractExtensionController::class, 'index'])->name('renewal');
            Route::get('/load-ajax-list-renewal', [ContractExtensionController::class, 'loadAjaxListRenewal'])->name('load_ajax_list_renewal');
            Route::get('//gia-han/them-moi/{contract_id}', [ContractExtensionController::class, 'create'])->name('renewal_create');
            Route::post('/gia-han/them-moi', [ContractExtensionController::class, 'store'])->name('renewal_store');
            Route::get('/gia-han/cap-nhat/{id}', [ContractExtensionController::class, 'edit'])->name('renewal_edit');
            Route::post('/gia-han/cap-nhat', [ContractExtensionController::class, 'update'])->name('renewal_update');
            Route::post('/gia-han/xoa', [ContractExtensionController::class, 'destroy'])->name('renewal_destroy');
        });
    });

    Route::prefix('luong')->group(function () {
        Route::name('salary.')->group(function () {
            Route::get('/', [SalaryController::class, 'index'])->name('list');
            Route::get('/them-moi', [SalaryController::class, 'create'])->name('create');
            Route::post('/them-moi', [SalaryController::class, 'store'])->name('store');
            Route::post('/xoa', [SalaryController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [SalaryController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [SalaryController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-annual-leave', [SalaryController::class, 'loadAjaxListSalary'])->name('load_ajax_list_salary');
            Route::post('/show', [SalaryController::class, 'show'])->name('show');

        });
    });
    Route::prefix('bang-luong')->group(function () {
        Route::name('pay_salaries.')->group(function () {
            Route::get('/', [PaySalarieController::class, 'index'])->name('list');
            Route::get('/them-moi', [PaySalarieController::class, 'create'])->name('create');
            Route::post('/them-moi', [PaySalarieController::class, 'store'])->name('store');
            Route::post('/xoa', [PaySalarieController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [PaySalarieController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [PaySalarieController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-annual-leave', [PaySalarieController::class, 'loadAjaxListPaySalaries'])->name('load_ajax_list_pay_salaries');

        });
    });

    Route::prefix('cham-cong')->group(function () {
        Route::name('Timesheet.')->group(function () {
            Route::get('/', [TimesheetController::class, 'index'])->name('list');
            Route::get('/them-moi', [TimesheetController::class, 'create'])->name('create');
            Route::post('/them-moi', [TimesheetController::class, 'store'])->name('store');
            Route::post('/xoa', [TimesheetController::class, 'destroy'])->name('destroy');
            Route::get('/cap-nhat/{id}', [TimesheetController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [TimesheetController::class, 'update'])->name('update');
            Route::get('/load-ajax-list-annual-leave', [TimesheetController::class, 'loadAjaxListTimesheet'])->name('load_ajax_list_Timesheet');

        });
    });
});

Route::get('/check-role', [UserController::class, 'checkRole'])->name('checkRole');