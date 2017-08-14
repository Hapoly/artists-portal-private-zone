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
    
    /* artists list */
    Route::get('/artists/{page?}', 'AdminArtistsController@list');
    /* single artists page for editing or viewing */
    Route::get ('/artist/show/{ArtistId}', 'AdminArtistsController@view')->where('ArtistId', '[0-9]+');
    
    Route::get ('/artist/edit/{ArtistId}', 'AdminArtistsController@editGet')->where('ArtistId', '[0-9]+');
    Route::post('/artist/edit/{ArtistId}', 'AdminArtistsController@editPost')->where('ArtistId', '[0-9]+');
    /* new artist page */
    Route::get ('/artist-new', 'AdminArtistsController@newGet' );
    Route::post('/artist-new', 'AdminArtistsController@newPost');
    /* Artist remove */
    Route::get('/artist-remove/{ArtistId}', 'AdminArtistsController@remove');
    Route::get('/artist-accept/{ArtistId}', 'AdminArtistsController@accept');
    Route::get('/artist-ban/{ArtistId}', 'AdminArtistsController@ban');
    Route::get('/artist-active/{ArtistId}', 'AdminArtistsController@active');
    Route::get('/artist-recylce/{ArtistId}', 'AdminArtistsController@recylce');

    /* events list */
    Route::get('/events/{page?}', 'AdminEventsController@list');
    /* single artists page for editing or viewing */
    Route::get ('/event/show/{eventId}', 'AdminEventsController@view')->where('eventId', '[0-9]+');
    
    Route::get ('/event/edit/{eventId}', 'AdminEventsController@editGet')->where('eventId', '[0-9]+');
    Route::post('/event/edit/{eventId}', 'AdminEventsController@editPost')->where('eventId', '[0-9]+');
    /* new event page */
    Route::get ('/event-new', 'AdminEventsController@newGet' );
    Route::post('/event-new', 'AdminEventsController@newPost');
    /* event remove */
    Route::get('/event-remove/{eventId}', 'AdminEventsController@remove');
    Route::get('/event-accept/{eventId}', 'AdminEventsController@accept');
    Route::get('/event-deactive/{eventId}', 'AdminEventsController@ban');
    Route::get('/event-active/{eventId}', 'AdminEventsController@active');
    Route::get('/event-recylce/{eventId}', 'AdminEventsController@recylce');

    
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