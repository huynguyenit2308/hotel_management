<?php

use App\Http\Controllers\CRUD_ServiceController;
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