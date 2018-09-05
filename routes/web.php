<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::prefix('navigation')->group(function () {
        Route::get('index', 'NavigationController@index')->name('navigation');
        Route::post('add', 'NavigationController@store')->name('navigation.add');
        Route::get('edit/{menu}', 'NavigationController@edit')->name('navigation.edit');
        Route::post('update/{menu}', 'NavigationController@update')->name('navigation.update');
    });

    Route::prefix('evaluation')->group(function () {
        Route::get('index', 'EvaluationController@index')->name('evaluations');
        Route::post('add', 'EvaluationController@store')->name('evaluation.add');
        Route::get('list', 'EvaluationController@list')->name('evaluation.list');

        Route::get('dashboard', 'EvaluationController@dashboard')->name('evaluation.dashboard');
    });

    // Unifi Routes
    Route::prefix('unifi')->namespace('Unifi')->group(function () {
        Route::get('login', 'UnifiController@show')->name('unifi.login');
        Route::post('login', 'UnifiController@authenticate')->name('unifi.authenticate');
    });

    //Build Files
    Route::prefix('build')->group(function () {
        Route::namespace('Evaluation')->group(function () {
            Route::prefix('categories')->group(function () {
                Route::get('index', 'CategoryController@index')->name('categories');
            });

            Route::prefix('criterias')->group(function () {
                Route::get('index', 'CriteriaController@index')->name('criterias');
            });
        });
    });

    // User Routes
    Route::prefix('users')->group(function () {
        Route::view('index', 'users.index')->name('users');
        Route::post('add', 'UserController@store')->name('user.add');
        Route::get('get', 'UserController@get')->name('user.get');
        Route::get('get/{user}', 'UserController@edit')->name('user.edit');
        Route::patch('update/{user}', 'UserController@update')->name('user.update');
        Route::delete('delete/{user}', 'UserController@delete')->name('user.delete');

        // Roles Routes
        Route::prefix('roles')->group(function () {
            Route::get('add', 'RoleController@index')->name('roles');
            Route::post('add', 'RoleController@store')->name('role.add');
            Route::get('get', 'RoleController@get')->name('role.get');
            Route::get('get/{role}', 'RoleController@edit')->name('role.edit');
            Route::patch('update/{role}', 'RoleController@update')->name('role.update');
            Route::get('delete/{role}', 'RoleController@destroy')->name('role.delete');
        });

        // Permission Routes
        Route::prefix('permissions')->group(function () {
            Route::get('add', 'PermissionController@index')->name('permissions');
            Route::post('add', 'PermissionController@store')->name('permission.add');
            Route::get('get', 'PermissionController@get')->name('permission.get');
            Route::get('get/{permission}', 'PermissionController@edit')->name('permission.edit');
            Route::patch('update/{permission}', 'PermissionController@update')->name('permission.update');
            Route::delete('delete/{permission}', 'PermissionController@destroy')->name('permission.delete');
        });

        // Student Routes
        Route::prefix('students')->group(function () {
            Route::get('index', 'StudentController@index')->name('students');
            Route::post('add', 'StudentController@store')->name('student.add');
            Route::post('upload', 'StudentController@upload')->name('students.upload');
            Route::get('get', 'StudentController@get')->name('student.get');
            Route::get('get/{student}', 'StudentController@edit')->name('student.edit');
            Route::delete('delete/{student}', 'StudentController@delete')->name('student.delete');
        });

        // Employee Routes
        Route::prefix('employees')->group(function () {
            Route::get('index', 'EmployeeController@index')->name('employees');
            Route::post('add', 'EmployeeController@store')->name('employee.add');
            Route::get('get', 'EmployeeController@get')->name('employee.get');
            Route::get('get/{employee}', 'EmployeeController@edit')->name('employee.edit');
            Route::patch('update/{employee}', 'EmployeeController@update')->name('employee.update');
            Route::delete('delete/{employee}', 'EmployeeController@delete')->name('employee.delete');
        });
    });

    // Digihub Routes
    Route::prefix('digihub')->group(function () {
        Route::view('index', 'digihub.index')->name('digihub');
        Route::get('stations', 'DigihubController@stations')->name('digihub.stations');
    });
});
