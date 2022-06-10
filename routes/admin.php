<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Admin\Topics\TopicsController;

Route::prefix('admin')
    ->middleware('auth')
    ->group(function (){
        Route::get('/users', [UsersController::class, 'index'])->name('users');

        Route::controller(TopicsController::class)->group(function (){
            Route::any('/topic/add', 'add')->name('topic.add');
            Route::get('/topic/edit/{id}', 'edit')->name('topic.edit');
            Route::post('/topic/update/{id}', 'update')->name('topic.update');
            Route::get('/topic/{id}', 'view')->name('topic.view');
            Route::get('/topics', 'index')->name('topics');
        });
    });




