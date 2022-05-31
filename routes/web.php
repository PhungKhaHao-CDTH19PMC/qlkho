<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DepartmentController;
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
            Route::get('/load-ajax-list-department', [DepartmentController::class, 'loadAjaxListRole'])->name('load_ajax_list_department');
        });
    });
});

Route::get('/check-role', [UserController::class, 'checkRole'])->name('checkRole');