<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Admin\Topics\TopicsController;


Route::get('/users', [UsersController::class, 'index'])
    ->middleware(['auth'])
    ->name('users');
Route::controller(TopicsController::class)->group(function (){
    Route::any('/topic/add', 'add')->name('topic.add');
    Route::get('/topic/{id}', 'view')->name('topic.view');
    Route::get('/topics', 'index')->name('topics');
});

