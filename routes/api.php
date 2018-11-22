<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::prefix('options')->group(function () {
        Route::get('employees', 'EmployeeController@options')->name('employee.options');
        Route::get('users', 'UserController@options')->name('user.options');
    });

    Route::prefix('digihub')->group(function () {
        Route::get('guidelines', 'DigihubController@guidelines')->name('digihub.guidelines');
    });

    Route::namespace('Lms')->group(function () {
        Route::prefix('classes')->group(function () {
            Route::get('options', 'ClassController@options')->name('class.options');
        });
    });
});
