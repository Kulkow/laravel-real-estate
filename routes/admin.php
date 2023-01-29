<?php


use App\Http\Controllers\Admin\Topics\TopicsController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Admin\Tags\TagsController;
use App\Http\Controllers\Admin\Pm\EmployesContoller;
use App\Http\Controllers\Admin\Pm\StatisticTasksContoller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
            Route::get('/topics/json', 'json');
        });

        Route::controller(TagsController::class)->group(function (){
            Route::any('/tags/add', 'add')->name('tags.add');
            Route::get('/tags/edit/{id}', 'edit')->name('tags.edit');
            Route::post('/tags/update/{id}', 'update')->name('tags.update');
            Route::get('/tags/{id}', 'view')->name('tags.view');
            Route::get('/tags', 'index')->name('tags');
        });


        Route::controller(EmployesContoller::class)->group(function (){
            Route::any('/pm/employe/add', 'add')->name('employe.add');
            Route::get('/pm/employe/edit/{id}', 'edit')->name('employe.edit');
            Route::post('/pm/employe/update/{id}', 'update')->name('employe.update');
            Route::get('/pm/employe/{id}', 'view')->name('employe.view');
            Route::get('/pm/employes', 'index')->name('employes');
        });

        Route::controller(StatisticTasksContoller::class)->group(function (){
            Route::any('/pm/statistic-tasks/add/{id}', 'add')->name('statistic_task.add');
            Route::get('/pm/statistic-tasks', 'index')->name('statistic_tasks');
            Route::get('/pm/statistic-tasks/graphic/{id}', 'graphic')->name('statistic_tasks.graphic');
        });

        Route::get('/tokens/create', function (Request $request) {
            $token = $request->user()->createToken($request->token_name);
            return ['token' => $token->plainTextToken];
        });
    });




