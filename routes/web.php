<?php

use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Voyager\UserController;
use App\Http\Controllers\Voyager\ProductController;
use App\Http\Controllers\Voyager\DownloadController;
use App\Http\Controllers\Voyager\VoyagerAuthController;
use App\Http\Controllers\Voyager\WithdrawalRequestController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::name('admin.')->group(function() {
        Route::get('/login', [VoyagerAuthController::class, 'showLoginForm'])->name('voyager.login');
        Route::post('/login', [VoyagerAuthController::class, 'login'])->name('voyager.login.post');
    
        Route::middleware('admin-check')->group(function() {
            Route::name('users.')->prefix('users')->group(function() {
                Route::get('/', [UserController::class, 'getAllUsers'])->name('index');
                Route::post('/search', [UserController::class, 'searchUser'])->name('search');
                Route::get('/{id}/edit', [UserController::class, 'editUser'])->name('edit');
                Route::post('/{id}/destroy', [UserController::class, 'destroyUser'])->name('destroy');
                Route::put('/{id}/update', [UserController::class, 'updateUser'])->name('update');
                Route::get('/{id}', [UserController::class, 'showUser'])->name('show');
            });

            Route::name('withdrawals.')->prefix('withdrawals')->group(function() {
                Route::get('/', [WithdrawalRequestController::class, 'index'])->name('index');
                Route::post('/search', [WithdrawalRequestController::class, 'search'])->name('search');
                Route::post('/approve/{id}', [WithdrawalRequestController::class, 'approve'])->name('approve');
                Route::post('/reject/{id}', [WithdrawalRequestController::class, 'reject'])->name('reject');
            });

            Route::name('product-logs.')->prefix('product-logs')->group(function() {
                Route::get('/', [ProductController::class, 'getOffers'])->name('index');
                Route::get('/{id}/edit', [ProductController::class, 'editOffer'])->name('edit');
                Route::post('/{id}/update', [ProductController::class, 'updateOffer'])->name('update');
                Route::post('/{id}/destroy', [ProductController::class, 'destroyOffer'])->name('destroy');
                Route::post('/search', [ProductController::class, 'searchOffer'])->name('search');
            });
            
            Route::name('banks.')->prefix('banks')->group(function() {
                Route::get('/', [ProductController::class, 'getBanks'])->name('index');
                Route::get('/{id}/edit', [ProductController::class, 'editBank'])->name('edit');
                Route::post('/{id}/update', [ProductController::class, 'updateBank'])->name('update');
                Route::post('/{id}/destroy', [ProductController::class, 'destroyBank'])->name('destroy');
                Route::post('/search', [ProductController::class, 'searchBank'])->name('search');
            });

            Route::name('download.')->prefix('download')->group(function() {
                Route::get('/', [DownloadController::class, 'download'])->name('main');
            });
        });
    });

});