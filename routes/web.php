<?php

Route::get('/', function () {
    return view('welcome', ['tab' => 'login']);
})->name('home');

/* self pages */
Route::get('/dashboard', 'HomeController@dashboard')->middleware('auth');
Route::get('/profile', 'HomeController@profileGet')->middleware('auth');
Route::post('/profile', 'HomeController@profilePost')->middleware('auth');

/* ===================================================================
                         management pages
====================================================================*/

/* ====================  admin panels  =============================*/

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'check-admin']], function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    
    /* users list */
    Route::get('/users', 'AdminUsersController@list');
    /* single user page for editing or viewing */
    Route::get ('/user/{userId}/{watching?}/{page?}/{size?}', 'AdminUsersController@editGet')->where('unitId', '[0-9]+');
    Route::post('/user/{userId}/{watching?}/{page?}/{size?}', 'AdminUsersController@editPost')->where('unitId', '[0-9]+');
    /* new user page */
    Route::get('/user-new', 'AdminUsersController@newGet');
    Route::post('/user-new', 'AdminUsersController@newPost');
    /* remove the user */
    Route::post('/user-remove/{userId}', 'AdminUsersController@remove');

    /* units list */
    Route::get('/units/{page?}/{size?}', 'AdminUnitsController@list');
    /* single unit page for editing or viewing */
    Route::get ('/unit/{unitId}/{page?}/{size?}', 'AdminUnitsController@editGet')->where('unitId', '[0-9]+');
    Route::post('/unit/{unitId}/{page?}/{size?}', 'AdminUnitsController@editPost')->where('unitId', '[0-9]+');
    /* new unit page */
    Route::get('/unit-new', 'AdminUnitsController@newGet');
    Route::post('/unit-new', 'AdminUnitsController@newPost');
    /* remove unit */
    Route::get('/unit-remove/{id}', 'AdminUnitsController@remove');
    /* print routes */
    Route::get('/unit-list-print/', 'AdminUnitsController@listPrint');
    Route::get('/unit-single-print/{id}', 'AdminUnitsController@singlePrint');

    /* employees list */
    Route::get('/employees/{page?}/{size?}', 'AdminEmployeesController@list');
    /* single employees page for editing or viewing */
    Route::get('/employee/{employeeId}/{page?}/{size?}', 'AdminEmployeesController@editGet')->where('employeeId', '[0-9]+');
    Route::post('/employee/{employeeId}/{page?}/{size?}', 'AdminEmployeesController@editPost')->where('employeeId', '[0-9]+');
    /* new employee page */
    Route::get('/employee-new/{unitId?}', 'AdminEmployeesController@newGet');
    Route::post('/employee-new', 'AdminEmployeesController@newPost');
    /* print routes */
    Route::get('/employee-list-print/', 'AdminEmployeesController@listPrint');
    Route::get('/employee-single-print/{id}', 'AdminEmployeesController@singlePrint');
    /* employee remove */
    Route::get('/employee-remove/{employeeId}', 'AdminEmployeesController@remove');

    /* backup routes */
    Route::get ('/backup', 'Backup@get');
    Route::post('/backup', 'Backup@post');

    /* reporets page */
    Route::get ('/report/{id}', 'Reports@use');
    Route::get ('/report-remove/{id}', 'Reports@remove');
    Route::get  ('/report-new', 'Reports@newGet');
    Route::post ('/report-new', 'Reports@newPost');
    Route::get  ('/report-edit/{id}', 'Reports@editGet');
    Route::post ('/report-edut/{id}', 'Reports@editPost');
    Route::get ('/reports/{page?}/{size?}', 'Reports@list');
    /*
    Route::group(['namespace' => 'Report', 'prefix' => 'reports'], function () {
        Route::get('/genders', 'Genders@all');
        Route::get('/genders-list', 'Genders@allList');

        Route::get('/genders-field', 'Genders@studyField');
        Route::get('/genders-field-list', 'Genders@studyFieldList');

        Route::get('/genders-degree', 'Genders@degree');
        Route::get('/genders-degree-list', 'Genders@degreeList');

        Route::get('/genders-habitate', 'Genders@habitate');
        Route::get('/genders-habitate-list', 'Genders@habitateList');
        
        Route::get('/genders-job', 'Genders@job');
        Route::get('/genders-job-list', 'Genders@jobList');
    });
    */
});

/* ====================  regular panels  =============================*/

Route::group(['namespace' => 'RegularMember', 'middleware' => 'auth'], function () {
    // Controllers Within The "App\Http\Controllers\RegularMember" Namespace

    /* units list */
    Route::get('/units/{page?}/{size?}', 'NormalUnitsController@list');
    /* single unit page for editing or viewing */
    Route::get ('/unit/{unitId}/{page?}/{size?}', 'NormalUnitsController@editGet')->where('unitId', '[0-9]+');
    Route::post('/unit/{unitId}/{page?}/{size?}', 'NormalUnitsController@editPost')->where('unitId', '[0-9]+');
    /* new unit page */
    Route::get('/unit-new', 'NormalUnitsController@newGet');
    Route::post('/unit-new', 'NormalUnitsController@newPost');
    /* remove unit */
    Route::get('/unit-remove/{id}', 'NormalUnitsController@remove');
    /* print routes */
    Route::get('/unit-list-print/', 'NormalUnitsController@listPrint');
    Route::get('/unit-single-print/{id}', 'NormalUnitsController@singlePrint');

    /* employees list */
    Route::get('/employees/{page?}/{size?}', 'NormalEmployeesController@list');
    /* single employees page for editing or viewing */
    Route::get('/employee/{employeeId}/{page?}/{size?}', 'NormalEmployeesController@editGet')->where('employeeId', '[0-9]+');
    Route::post('/employee/{employeeId}/{page?}/{size?}', 'NormalEmployeesController@editPost')->where('employeeId', '[0-9]+');
    /* new employee page */
    Route::get('/employee-new/{unitId?}', 'NormalEmployeesController@newGet');
    Route::post('/employee-new', 'NormalEmployeesController@newPost');

    /* print routes */
    Route::get('/employee-list-print', 'NormalEmployeesController@listPrint');
    Route::get('/employee-single-print/{id}', 'NormalEmployeesController@singlePrint');

});

Route::post('/login', 'HomeController@login');
Route::post('/register', 'HomeController@register');
Route::get('/logout', 'HomeController@logout');