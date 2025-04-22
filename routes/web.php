<?php

use App\Http\Controllers\CRUD_ServiceController;
use App\Http\Controllers\AccountRegisterController;
use App\Http\Controllers\LoginController;
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

Route::get('/', function () {
    return view('home');
})->name('home');
// Danh sách dịch vụ
Route::get('listService', [CRUD_ServiceController::class, 'listService'])->name('service.list');
// Thêm dịch vụ
Route::get('addService', [CRUD_ServiceController::class, 'addService'])->name('service.add');
Route::post('addService', [CRUD_ServiceController::class, 'postAddService'])->name('service.store');
// Chi tiết dịch vụ
Route::get('detailService', [CRUD_ServiceController::class, 'detailService'])->name('service.detail');
// Xóa dịch vụ
Route::get('deleteService', [CRUD_ServiceController::class, 'deleteService'])->name('service.delete');
// Sửa dịch vụ
Route::get('updateService', [CRUD_ServiceController::class, 'updateService'])->name('service.edit');
Route::post('updateService', [CRUD_ServiceController::class, 'updatePostService'])->name('service.update');
// Tìm kiếm dịch vụ
Route::get('searchService', [CRUD_ServiceController::class, 'searchService'])->name('service.search');
// Thống kê dịch vụ
Route::get('statisticService', [CRUD_ServiceController::class, 'statisticService'])->name('service.statistic');

//Mở form đăng ký tài khoản
Route::get('/register', [AccountRegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [AccountRegisterController::class, 'register'])->name('register');
//Mở form đăng nhập
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
