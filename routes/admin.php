<?php


use App\Http\Controllers\Admin\Topics\TopicsController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Admin\Tags\TagsController;
use Illuminate\Support\Facades\Route;

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

        Route::controller(TagsController::class)->group(function (){
            Route::any('/tags/add', 'add')->name('tags.add');
            Route::get('/tags/edit/{id}', 'edit')->name('tags.edit');
            Route::post('/tags/update/{id}', 'update')->name('tags.update');
            Route::get('/tags/{id}', 'view')->name('tags.view');
            Route::get('/tags', 'index')->name('tags');
        });
    });




