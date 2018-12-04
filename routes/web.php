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
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');

    Route::prefix('navigation')->group(function () {
        Route::get('/', 'NavigationController@index')->name('navigation');
        Route::post('add', 'NavigationController@store')->name('navigation.add');
        Route::get('edit/{menu}', 'NavigationController@edit')->name('navigation.edit');
        Route::post('update/{menu}', 'NavigationController@update')->name('navigation.update');
        Route::get('delete/{menu}', 'NavigationController@destroy')->name('navigation.delete');
        Route::get('restore/{menu}', 'NavigationController@restore')->name('navigation.restore');
    });

    Route::prefix('evaluation')->group(function () {
        Route::get('index', 'EvaluationController@index')->name('evaluations');
        Route::post('add', 'EvaluationController@store')->name('evaluation.add');
        Route::get('list', 'EvaluationController@list')->name('evaluation.list');
        Route::get('dashboard', 'EvaluationController@dashboard')->name('evaluation.dashboard');
    });

    Route::namespace('Lms')->group(function () {
        // Classes Routes
        Route::prefix('classes')->group(function () {
            Route::get('/', 'ClassController@myClasses')->name('my.classes');
            Route::any('add', 'ClassController@add')->name('class.add');
            Route::any('list', 'ClassController@my_classes')->name('class.list');
            Route::get('view/{class}', 'ClassController@view')->name('class.view');
            Route::post('upload/{class}', 'ClassController@upload')->name('class.upload');
            Route::get('attach/{class}/{lesson}', 'ClassController@attach')->name('class.attach.lesson');
            Route::get('detach/{class}/{lesson}', 'ClassController@detach')->name('class.detach.lesson');

            Route::prefix('student')->group(function () {
                Route::get('list/{class}', 'ClassController@studentList')->name('class.student.list');
                Route::post('add/{class}', 'ClassController@addStudent')->name('class.student.add');
            });

            Route::prefix('lessons')->group(function () {
                Route::get('list/{class}', 'ClassController@lessonsList')->name('class.lessons.list');
            });
        });

        // Lessons Routes
        Route::prefix('lessons')->group(function () {
            Route::get('/', 'LessonController@index')->name('lessons');
            Route::get('new', 'LessonController@new')->name('lesson.new');
            Route::get('list', 'LessonController@list')->name('lessons.list');
            Route::post('add', 'LessonController@store')->name('lesson.add');
            Route::get('view/{lesson}', 'LessonController@view')->name('lesson.view');
            Route::any('{lesson}/update', 'LessonController@update')->name('lesson.update');
            Route::get('delete/{lesson}', 'LessonController@destroy')->name('lesson.destroy');
            Route::get('restore/{lesson}', 'LessonController@restore')->name('lesson.restore');
            Route::get('approve/{lesson}', 'LessonController@approve')->name('lesson.approve');
            Route::get('disapprove/{lesson}', 'LessonController@disapprove')->name('lesson.disapprove');

            Route::prefix('chapters')->group(function () {
                Route::any('{lesson}/add', 'ChapterController@store')->name('chapter.add');
                Route::any('{lesson}/{chapter}/update', 'ChapterController@update')->name('chapter.update');
                Route::any('{lesson}/list', 'ChapterController@list')->name('chapters.list');
            });
        });
    });

    // Unifi Routes
    Route::prefix('unifi')->namespace('Unifi')->group(function () {
        Route::get('login', 'UnifiController@show')->name('unifi.login');
        Route::post('login', 'UnifiController@authenticate')->name('unifi.authenticate');
    });

    //Build Files
    Route::prefix('build')->group(function () {
        Route::namespace('Build')->group(function () {
            // Departments
            Route::prefix('departments')->group(function () {
                Route::get('/', 'DepartmentController@index')->name('departments');
                Route::post('add', 'DepartmentController@store')->name('department.add');
                Route::get('get/{department}', 'DepartmentController@get')->name('department.get');
                Route::get('list', 'DepartmentController@list')->name('department.list');
                Route::post('update/{department}', 'DepartmentController@update')->name('department.update');
                Route::get('delete/{department}', 'DepartmentController@destroy')->name('department.destroy');
                Route::get('restore/{department}', 'DepartmentController@restore')->name('department.restore');
            });
            // School Years
            Route::prefix('school_years')->group(function () {
                Route::get('/', 'SchoolYearController@index')->name('school_years');
                Route::post('add', 'SchoolYearController@store')->name('school_year.add');
                Route::get('get/{school_year}', 'SchoolYearController@get')->name('school_year.get');
                Route::get('list', 'SchoolYearController@list')->name('school_year.list');
                Route::post('update/{school_year}', 'SchoolYearController@update')->name('school_year.update');
                Route::get('delete/{school_year}', 'SchoolYearController@destroy')->name('school_year.destroy');
                Route::get('restore/{school_year}', 'SchoolYearController@restore')->name('school_year.restore');
            });
            // Semesters
            Route::prefix('semesters')->group(function () {
                Route::get('/', 'SemesterController@index')->name('semesters');
                Route::post('add', 'SemesterController@store')->name('semester.add');
                Route::get('get/{semester}', 'SemesterController@get')->name('semester.get');
                Route::get('list', 'SemesterController@list')->name('semester.list');
                Route::post('update/{semester}', 'SemesterController@update')->name('semester.update');
                Route::get('delete/{semester}', 'SemesterController@destroy')->name('semester.destroy');
                Route::get('restore/{semester}', 'SemesterController@restore')->name('semester.restore');
            });
        });
        // Evaluation Build Files
        Route::namespace('Evaluation')->group(function () {
            Route::prefix('categories')->group(function () {
                Route::get('/', 'CategoryController@index')->name('categories');
                Route::get('get', 'CategoryController@get')->name('category.get');
                Route::get('get/{category}', 'CategoryController@edit')->name('category.edit');
                Route::post('update/{category}', 'CategoryController@update')->name('category.update');
                Route::get('delete/{category}', 'CategoryController@delete')->name('category.delete');
                Route::get('restore/{category}', 'CategoryController@restore')->name('category.restore');
            });

            Route::prefix('criterias')->group(function () {
                Route::get('/', 'CriteriaController@index')->name('criterias');
            });
        });
    });

    // User Routes
    Route::prefix('users')->group(function () {
        Route::get('dashboard', 'UserController@index')->name('users');
        Route::any('audit', 'UserController@audit')->name('users.audit');
        Route::any('restore', 'UserController@restoreUsers')->name('users.restore');

        // Active Directory
        Route::prefix('active-directory')->group(function () {
            Route::get('/', 'UserController@active')->name('active.directory');
            Route::post('add', 'UserController@store')->name('active.directory.add');
            Route::get('list', 'UserController@list')->name('active.list');
            Route::post('update/permission/{user}', 'EmployeeController@updatePermission')->name('active.update.permission');
        });

        // Roles Routes
        Route::prefix('roles')->group(function () {
            Route::get('add', 'RoleController@index')->name('roles');
            Route::post('add', 'RoleController@store')->name('role.add');
            Route::get('get', 'RoleController@get')->name('role.get');
            Route::get('get/{role}', 'RoleController@edit')->name('role.edit');
            Route::patch('update/{role}', 'RoleController@update')->name('role.update');
            Route::get('delete/{role}', 'RoleController@destroy')->name('role.delete');
            Route::get('permissions', 'RoleController@permissions')->name('role.permissions');
            Route::post('sync', 'RoleController@sync_acl')->name('role.sync');
        });

        // Permission Routes
        Route::prefix('permissions')->group(function () {
            Route::get('add', 'PermissionController@index')->name('permissions');
            Route::post('add', 'PermissionController@store')->name('permission.add');
            Route::get('get', 'PermissionController@get')->name('permission.get');
            Route::get('get/{permission}', 'PermissionController@edit')->name('permission.edit');
            Route::post('update/{permission}', 'PermissionController@update')->name('permission.update');
            Route::get('delete/{permission}', 'PermissionController@destroy')->name('permission.delete');
        });

        // Student Routes
        Route::prefix('students')->group(function () {
            Route::get('/', 'StudentController@index')->name('students');
            Route::post('add', 'StudentController@store')->name('student.add');
            Route::post('upload', 'StudentController@upload')->name('students.upload');
            Route::get('get', 'StudentController@get')->name('student.get');
            Route::get('get/{student}', 'StudentController@edit')->name('student.edit');
            Route::post('update/{student}', 'StudentController@update')->name('student.update');
            Route::get('delete/{student}', 'StudentController@destroy')->name('student.destroy');
        });

        // Employee Routes
        Route::prefix('employees')->group(function () {
            Route::get('/', 'EmployeeController@index')->name('employees');
            Route::post('add', 'EmployeeController@store')->name('employee.add');
            Route::post('upload', 'EmployeeController@upload')->name('employees.upload');
            Route::get('get', 'EmployeeController@get')->name('employee.get');
            Route::get('show/{employee}', 'EmployeeController@show')->name('employee.show');
            Route::get('get/{employee}', 'EmployeeController@edit')->name('employee.edit');
            Route::post('update/{employee}', 'EmployeeController@update')->name('employee.update');
            Route::get('delete/{employee}', 'EmployeeController@delete')->name('employee.delete');
        });
    });

    // Network Routes
    Route::prefix('network')->group(function () {
        Route::view('/', 'network.dashboard')->name('network');

        // Digihub Routes
        Route::prefix('digihub')->group(function () {
            Route::view('/', 'network.digihub.index')->name('digihub');
            route::post('add', 'DigihubController@add')->name('digihub.add');
            Route::get('list', 'DigihubController@list')->name('digihub.list');
            Route::get('get/{digihub}', 'DigihubController@get')->name('digihub.get');
            Route::post('update/{digihub}', 'DigihubController@update')->name('digihub.update');
            Route::get('delete/{digihub}', 'DigihubController@destroy')->name('digihub.destroy');
            Route::prefix('logs')->group(function () {
                Route::any('{digihub}/single', 'DigihubController@log')->name('digihub.log');
                Route::any('all', 'DigihubController@logs')->name('digihub.logs');
            });
        });

        // Wifi Routes
        Route::prefix('wifi')->namespace('Unifi')->group(function () {
            Route::get('/', 'UnifiController@index')->name('wifi');
            Route::get('logs', 'LogController@logs')->name('wifi.logs');
            Route::get('active', 'LogController@active')->name('wifi.active');
            Route::get('usage/{user}', 'LogController@usage')->name('wifi.usage');
        });
    });
});
