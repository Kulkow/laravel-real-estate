<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Topics\TopicsController;
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
        });
    });
