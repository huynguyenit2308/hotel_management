<?php

use App\Http\Controllers\CRUD_ServiceController;
use App\Http\Controllers\AccountRegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CRUD_CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

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
// Quản lý giá dịch vụ
Route::get('priceService', [CRUD_ServiceController::class, 'editPriceService'])->name('service.price');
Route::post('priceService', [CRUD_ServiceController::class, 'updatePriceService'])->name('service.price.update');
// Thống kê dịch vụ
Route::get('statisticService', [CRUD_ServiceController::class, 'statisticService'])->name('service.statistic');

//Mở form đăng ký tài khoản
Route::get('/register', [AccountRegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [AccountRegisterController::class, 'register'])->name('register');
//Mở form đăng nhập
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

// User management routes
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');


//Hiển thị danh sách khách hàng
Route::get('/listCustomer', [CRUD_CustomerController::class, 'list'])->name('customers.list');
//Hiển thị chi tiết khách hàng
Route::get('/customers/{id}', [CRUD_CustomerController::class, 'detail'])->name('customers.detail');

//Hiển thị form chỉnh sửa
Route::get('/customers/{id}/edit', [CRUD_CustomerController::class, 'edit'])->name('customers.edit');
//Cập nhật thông tin khách hàng
Route::post('/customers/{id}/update', [CRUD_CustomerController::class, 'update'])->name('customers.update');
//Xóa khách hàng
Route::get('/customers/{id}/delete', [CRUD_CustomerController::class, 'delete'])->name('customers.delete');
//phongf
Route::resource('rooms', RoomController::class);
