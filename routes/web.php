<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransaksiAdminController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
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

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK (TANPA LOGIN)
|--------------------------------------------------------------------------
*/

Route::get('/', [TransaksiController::class, 'index'])->name('home');
Route::get('/shop', [Controller::class, 'shop'])->name('shop');
Route::get('/contact', [Controller::class, 'contact'])->name('contact');
Route::get('/about', [Controller::class, 'about'])->name('about');

Route::POST('/addTocart', [TransaksiController::class, 'addTocart'])->name('addTocart');

/*
|--------------------------------------------------------------------------
| AUTH PELANGGAN (REGISTER & LOGIN)
|--------------------------------------------------------------------------
*/

Route::POST('/storePelanggan', [UserController::class, 'storePelanggan'])->name('storePelanggan');
Route::POST('/login_pelanggan', [UserController::class, 'loginProses'])->name('loginproses.pelanggan');
Route::POST('/logout_pelanggan', [UserController::class, 'logout'])->name('logout.pelanggan');

/*
|--------------------------------------------------------------------------
| ROUTE PELANGGAN (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/transaksi', [Controller::class, 'transaksi'])->name('transaksi');
    Route::delete('/transaksi', [TransaksiController::class, 'destroy'])->name('transaksi.delete');

    Route::get('/checkout', [Controller::class, 'checkout'])->name('checkout');
    Route::POST('/checkout/proses', [Controller::class, 'prosesCheckout'])->name('checkoutProduct');

    Route::POST('/checkout/prosesPembayaran', [Controller::class, 'prosesPembayaran'])->name('checkoutBayar');

    Route::get('/checkOut', [Controller::class, 'keranjang'])->name('keranjang');
    Route::get('/checkOut/{id}', [MidtransCallbackController::class, 'bayar'])->name('keranjangBayar');

    Route::get('/invoice/{id}', [MidtransCallbackController::class, 'invoice'])->name('invoice');
});

/*
|--------------------------------------------------------------------------
| LOGIN ADMIN (TANPA LOGIN)
|--------------------------------------------------------------------------
*/

Route::get('/admin', [Controller::class, 'login'])
    ->middleware('guest:admin')
    ->name('login');
Route::POST('/admin/loginProses', [Controller::class, 'loginProses'])->name('loginProses');

// DEBUG ROUTE - REMOVE IN PRODUCTION
if (env('APP_DEBUG')) {
    Route::get('/debug/users', function() {
        $users = \App\Models\User::all();
        return view('admin.page.debug-users', ['users' => $users]);
    })->name('debug.users');
}

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (ADMIN ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:admin')->group(function () {

    Route::get('/admin/dashboard', [Controller::class, 'admin'])->name('admin.dashboard');
    Route::post('/admin/logout', [Controller::class, 'logout'])->name('admin.logout');
    Route::get('/admin/product', [ProductController::class, 'index'])->name('product');
    Route::get('/admin/report', [Controller::class, 'report'])->name('report');
    Route::get('/admin/addModal', [ProductController::class, 'addModal'])->name('addModal');
    Route::get('/admin/debug', function() { return view('admin.page.debug'); })->name('debug');
    
    /*
    |--------------------------------------------------------------------------
    | USER MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::GET('/admin/user_management', [UserController::class, 'index'])->name('userManagement');
    Route::GET('/admin/user_management/addModalUser', [UserController::class, 'addModalUser'])->name('addModalUser');
    Route::POST('/admin/user_management/addData', [UserController::class, 'store'])->name('addDataUser');
    Route::get('/admin/user_management/editUser/{id}', [UserController::class, 'show'])->name('showDataUser');
    Route::PUT('/admin/user_management/updateDataUser/{id}', [UserController::class, 'update'])->name('updateDataUSer');
    Route::DELETE('/admin/user_management/deleteUSer/{id}', [UserController::class, 'destroy'])->name('destroyDataUser');
    
    Route::get('/admin/pelanggan', [UserController::class, 'pelanggan'])
    ->name('admin.pelanggan');

    /*
    |--------------------------------------------------------------------------
    | PRODUCT MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::POST('/admin/addData', [ProductController::class, 'store'])->name('addData');
    Route::GET('/admin/editModal/{id}', [ProductController::class, 'show'])->name('editModal');
    Route::PUT('/admin/updateData/{id}', [ProductController::class, 'update'])->name('updateData');
    Route::DELETE('/admin/deleteData/{id}', [ProductController::class, 'destroy'])->name('deleteData');

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI ADMIN
    |--------------------------------------------------------------------------
    */

    Route::GET('/admin/transaksi', [TransaksiAdminController::class, 'index'])->name('transaksi.admin');

    Route::GET('/admin/export-pdf', [TransaksiAdminController::class, 'exportPdf'])->name('export.pdf');
});