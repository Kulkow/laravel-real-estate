<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Topics\TopicsController;
use App\Http\Controllers\Admin\Pm\SheetsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')
    ->group(function (){
        Route::controller(TopicsController::class)->group(function (){
            Route::get('/topics', 'index');
            Route::get('/topic/{id}', 'view');
            Route::get('/topic/edit/{id}', 'edit');
            Route::post('/topic/update/{id}', 'update');
        });
        Route::controller(SheetsController::class)->group(function (){
            //Route::get('/sheets/users', 'users')->name('api.sheets.tasks');
            Route::get('/sheets/pm', 'pm')->name('sheets.pm');
            Route::get('/sheets/tasks/{id}', 'tasks')->name('api.sheets.tasks');
            Route::post('/sheets/add/{id}', 'add')->name('api.sheets.add');
        });
    });
