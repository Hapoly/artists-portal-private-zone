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

    /* artists list */
    Route::get('/artists/{page?}', 'AdminArtistsController@list');
    /* single artists page for editing or viewing */
    Route::get('/artist/show/{ArtistId}', 'AdminArtistsController@view')->where('ArtistId', '[0-9]+');
    Route::get('/artist/edit/{ArtistId}', 'AdminArtistsController@editGet')->where('ArtistId', '[0-9]+');
    Route::post('/artist/edit/{ArtistId}', 'AdminArtistsController@editPost')->where('ArtistId', '[0-9]+');
    /* new artist page */
    Route::get('/artist-new/{unitId?}', 'AdminArtistsController@newGet');
    Route::post('/artist-new', 'AdminArtistsController@newPost');
    /* print routes */
    Route::get('/artist-list-print/', 'AdminArtistsController@listPrint');
    Route::get('/artist-single-print/{id}', 'AdminArtistsController@singlePrint');
    /* Artist remove */
    Route::get('/Artist-remove/{ArtistId}', 'AdminArtistsController@remove');

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

    /* Artists list */
    Route::get('/Artists/{page?}/{size?}', 'NormalArtistsController@list');
    /* single Artists page for editing or viewing */
    Route::get('/Artist/{ArtistId}/{page?}/{size?}', 'NormalArtistsController@editGet')->where('ArtistId', '[0-9]+');
    Route::post('/Artist/{ArtistId}/{page?}/{size?}', 'NormalArtistsController@editPost')->where('ArtistId', '[0-9]+');
    /* new Artist page */
    Route::get('/Artist-new/{unitId?}', 'NormalArtistsController@newGet');
    Route::post('/Artist-new', 'NormalArtistsController@newPost');

    /* print routes */
    Route::get('/Artist-list-print', 'NormalArtistsController@listPrint');
    Route::get('/Artist-single-print/{id}', 'NormalArtistsController@singlePrint');

});

Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('app') . '/storage/' . $filename;

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::post('/login', 'HomeController@login');
Route::post('/register', 'HomeController@register');
Route::get('/logout', 'HomeController@logout');