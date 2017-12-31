<?php

Route::get('/', function () {
    return view('welcome', ['tab' => 'login']);
})->name('home');

/* self pages */
Route::get('/dashboard', 'HomeController@dashboard')->middleware('auth');
Route::get('/profile', 'HomeController@profileGet')->middleware('auth');

Route::get('/profile-edit', 'HomeController@profileEditGet')->middleware('auth');
Route::post('/profile-edit', 'HomeController@profileEditPost')->middleware('auth');

Route::get('help', function () {
    return view('help');
});
Route::get('questions', function () {
    return view('questions');
});

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

    /* messages list */
    Route::get('/messages/{page?}', 'AdminMessagesController@list');
    
    Route::get ('/message/show/{messageId}', 'AdminMessagesController@view')->where('messageId', '[0-9]+');
    /* new message page */
    Route::get ('/message-new/{recieverId?}', 'AdminMessagesController@newGet' );
    Route::post('/message-new', 'AdminMessagesController@newPost');
    /* message remove */
    Route::get('/message-remove/{messageId}', 'AdminMessagesController@remove');
    Route::get('/message-recylce/{messageId}', 'AdminMessagesController@recylce');
    Route::get('/message-reply/{messageId}', 'AdminMessagesController@reply');

    /* event requests list */
    Route::get('/requests/{page?}', 'AdminRequestsController@list');
    /* new event page */
    Route::get ('/request-new/{eventId}/{artist_id}', 'AdminRequestsController@newGet');
    /* event remove */
    Route::get('/request-accept/{requestId}', 'AdminRequestsController@accept');
    Route::get('/request-refuse/{requestId}', 'AdminRequestsController@refuse');
});

/* ====================  regular panels  =============================*/

Route::group(['namespace' => 'Regular', 'middleware' => 'auth', 'prefix' => 'user'], function () {
    /* artists list */
    Route::get('/artists/{page?}', 'RegularArtistsController@list');
    /* single artists page for editing or viewing */
    Route::get ('/artist/show/{ArtistId}', 'RegularArtistsController@view')->where('ArtistId', '[0-9]+');
    
    Route::get ('/artist/edit/{ArtistId}', 'RegularArtistsController@editGet')->where('ArtistId', '[0-9]+');
    Route::post('/artist/edit/{ArtistId}', 'RegularArtistsController@editPost')->where('ArtistId', '[0-9]+');
    /* new artist page */
    Route::get ('/artist-new', 'RegularArtistsController@newGet' );
    Route::post('/artist-new', 'RegularArtistsController@newPost');
    /* Artist remove */
    Route::get('/artist-remove/{ArtistId}', 'RegularArtistsController@remove');
    Route::get('/artist-accept/{ArtistId}', 'RegularArtistsController@accept');
    Route::get('/artist-ban/{ArtistId}', 'RegularArtistsController@ban');
    Route::get('/artist-active/{ArtistId}', 'RegularArtistsController@active');
    Route::get('/artist-recylce/{ArtistId}', 'RegularArtistsController@recylce');

    /* events list */
    Route::get('/events/{page?}', 'RegularEventsController@list');
    
    Route::get ('/event/show/{eventId}', 'RegularEventsController@view')->where('eventId', '[0-9]+');
    
    Route::get ('/event/edit/{eventId}', 'RegularEventsController@editGet')->where('eventId', '[0-9]+');
    Route::post('/event/edit/{eventId}', 'RegularEventsController@editPost')->where('eventId', '[0-9]+');
    /* new event page */
    Route::get ('/event-new', 'RegularEventsController@newGet' );
    Route::post('/event-new', 'RegularEventsController@newPost');
    /* event remove */
    Route::get('/event-remove/{eventId}', 'RegularEventsController@remove');
    Route::get('/event-accept/{eventId}', 'RegularEventsController@accept');
    Route::get('/event-deactive/{eventId}', 'RegularEventsController@ban');
    Route::get('/event-active/{eventId}', 'RegularEventsController@active');
    Route::get('/event-recylce/{eventId}', 'RegularEventsController@recylce');

    /* messages list */
    Route::get('/messages/{page?}', 'RegularMessagesController@list');
    
    Route::get ('/message/show/{messageId}', 'RegularMessagesController@view')->where('messageId', '[0-9]+');
    /* new message page */
    Route::get ('/message-new/{recieverId?}', 'RegularMessagesController@newGet' );
    Route::post('/message-new', 'RegularMessagesController@newPost');
    /* message remove */
    Route::get('/message-remove/{messageId}', 'RegularMessagesController@remove');
    Route::get('/message-recylce/{messageId}', 'RegularMessagesController@recylce');
    Route::get('/message-reply/{messageId}', 'RegularMessagesController@reply');

    /* event requests list */
    Route::get('/requests/{page?}', 'RegularRequestsController@list');
    /* new event page */
    Route::get ('/request-new/{eventId}/{artist_id}', 'RegularRequestsController@newGet');
    /* event remove */
    Route::get('/request-accept/{requestId}', 'RegularRequestsController@accept');
    Route::get('/request-refuse/{requestId}', 'RegularRequestsController@refuse');
});

Route::get('files/storage/{filename}', function ($filename)
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