<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboards\DashboardController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Admin\Topics\TopicsController;

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

Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::prefix('admin')->group(function () {
    Route::get('users', [UsersController::class, 'index'])
        ->middleware(['auth'])
        ->name('users');
    Route::controller(TopicsController::class)->group(function (){
        Route::any('/topic/add', 'add')->name('topic.add');
        Route::get('/topic/{id}', 'view')->name('topic.view');
        Route::get('/topics', 'index')->name('topics');
    });
});




require __DIR__.'/auth.php';
