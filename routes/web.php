<?php

use App\Http\Controllers\CRUD_ServiceController;
use App\Http\Controllers\AccountRegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CRUD_CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingServiceController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\AttendanceController;


use App\Models\BookingService;
use App\Models\Service;

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
    $rooms = App\Models\Room::with('status')->get();
    $services = Service::all();
    return view('home', compact('rooms', 'services'));
})->name('home');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Danh sách dịch vụ
Route::get('list-service', [CRUD_ServiceController::class, 'listService'])->name('service.list');
// Thêm dịch vụ
Route::get('add-service', [CRUD_ServiceController::class, 'addService'])->name('service.add');
Route::post('add-service', [CRUD_ServiceController::class, 'postAddService'])->name('service.store');
// Chi tiết dịch vụ
Route::get('detail-service', [CRUD_ServiceController::class, 'detailService'])->name('service.detail');
// Xóa dịch vụ
Route::get('delete-service', [CRUD_ServiceController::class, 'deleteService'])->name('service.delete');
// Sửa dịch vụ
Route::get('update-service', [CRUD_ServiceController::class, 'updateService'])->name('service.edit');
Route::post('update-service', [CRUD_ServiceController::class, 'updatePostService'])->name('service.update');
// Tìm kiếm dịch vụ
Route::get('search-service', [CRUD_ServiceController::class, 'searchService'])->name('service.search');
Route::get('auto-complete-service', [CRUD_ServiceController::class, 'autoCompleteService']);
// Quản lý giá dịch vụ
Route::get('price-service', [CRUD_ServiceController::class, 'editPriceService'])->name('service.price');
Route::post('price-service', [CRUD_ServiceController::class, 'updatePriceService'])->name('service.price.update');
// Thống kê dịch vụ
Route::get('statistic-service', [CRUD_ServiceController::class, 'statisticService'])->name('service.statistic');
// Sử dụng dịch vụ
Route::get('booking-service', [BookingServiceController::class, 'bookingService'])->name('booking.service');
Route::post('booking-service', [BookingServiceController::class, 'postBookingService'])->name('post.booking.service');
// Danh sách hóa đơn
Route::get('invoice-list', [BookingServiceController::class, 'listInvoice'])->name('invoice.list');
// Chi tiết hóa đơn
Route::get('detail-invoice', [BookingServiceController::class, 'detailInvoice'])->name('invoice.detail');
// Danh sách hóa đơn của người dùng
Route::get('invoice-list-user', [BookingServiceController::class, 'listInvoiceUser'])->name('invoice.list.user');
// Hủy hóa đơn
Route::get('invoice-cancel-user', [BookingServiceController::class, 'cancelInvoiceUser'])->name('invoice.cancel.user');

//Mở form đăng ký tài khoản
Route::get('/register', [AccountRegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [AccountRegisterController::class, 'register'])->name('register');
//Mở form đăng nhập
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// // User management routes
// Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
// Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
// Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
// Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
// Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
// Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
// Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

// Employee CRUD Routes
Route::get('/employees', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [App\Http\Controllers\EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees', [App\Http\Controllers\EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{employee}', [App\Http\Controllers\EmployeeController::class, 'show'])->name('employees.show');
Route::get('/employees/{employee}/edit', [App\Http\Controllers\EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}', [App\Http\Controllers\EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employees.destroy');

// Phân quyền tài khoản Routes - Chỉ cho phép Super Admin và Admin truy cập
Route::middleware('auth')->group(function () {
    Route::get('/permissions', [App\Http\Controllers\AccountPermissionController::class, 'index'])
        ->name('permissions.index')
        ->middleware('admin.role');
    Route::get('/permissions/{account}/edit', [App\Http\Controllers\AccountPermissionController::class, 'edit'])
        ->name('permissions.edit')
        ->middleware('admin.role');
    Route::put('/permissions/{account}', [App\Http\Controllers\AccountPermissionController::class, 'update'])
        ->name('permissions.update')
        ->middleware('admin.role');
});

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

// Đặt phòng
Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings/storeOnline', [BookingController::class, 'storeOnline'])->name('bookings.storeOnline');
Route::get('/bookings/create_direct', [BookingController::class, 'createDirect'])->name('bookings.createDirect');
Route::post('/bookings/storeDirect', [BookingController::class, 'storeDirect'])->name('bookings.storeDirect');
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');


//Đổi mật khẩu
Route::get('/change-password', [PasswordController::class, 'showChangePasswordForm'])
    ->middleware('auth')
    ->name('password.change');
Route::post('/change-password', [PasswordController::class, 'updatePassword'])->name('password.update')->middleware('auth');
//Hiển thị thông tin khách hàng
Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');


//Đánh giá khách hàng
Route::middleware('auth')->group(function () { // Chỉ có khách hàng đã đăng nhập mới được đánh giá
    Route::get('/ratings/create', [RatingController::class, 'create'])->name('ratings.create');//Hiển thị form đánh giá
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store'); // Xử lí việc đánh giá
});

//Danh sách khách hàng đã đánh giá
Route::get('/listRatings', [RatingController::class, 'list'])->name('ratings.list');

//Hiển thị đánh giá của khách hàng trên trang
Route::get('/showRating', [RatingController::class, 'showRatings'])->name('ratings.customerRatings');

//Hiển thị lịch sử đã đặt phòng
Route::get('/customer/history', [CustomerBookingController::class, 'history'])->name('customer.booking.history');

// Quản lý chấm công - Chỉ cho phép Super Admin và Admin truy cập
Route::middleware(['auth', 'admin.role'])->group(function () {
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/attendances/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
    Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
    Route::delete('/attendances/{attendance}', [AttendanceController::class, 'destroy'])->name('attendances.destroy');
    Route::get('/salary-report', [AttendanceController::class, 'salaryReport'])->name('attendances.salary_report');
    Route::get('/employees/{id}/attendances', [AttendanceController::class, 'employeeDetail'])->name('attendances.employeeDetail');
});
