<?php

use Illuminate\Http\Request;

/* =====================  fields for forms  =============================== */
Route::group(['namespace' => 'APIs'], function () {
    // Controllers Within The "App\Http\Controllers\APIs" Namespace

    /* genders list */
    Route::get('/genders', function (Request $request) {
        return 'genders list';
    });

    Route::get('/genders/{id}', function (Request $request, $id) {
        return "gender {id}";
    });

    /* age bounds list */
    Route::get('/ages', function (Request $request) {
        return 'ages list';
    });

    Route::get('/age/{id}', function (Request $request, $id) {
        return "age $id";
    });

    /* certificate types list */
    Route::get('/certificates', function (Request $request) {
        return 'certificates list for admin';
    });

    Route::get('/certificate/{id}', function (Request $request, $id) {
        return "certificate $id";
    });

    /* cities list */
    Route::get('/cities', 'City@getAll');

    Route::get('/city/{id}', function (Request $request, $id) {
        return "city $id";
    });

    /* degrees list */
    Route::get('/degrees', function (Request $request) {
        return 'degrees list for admin';
    });

    Route::get('/degree/{id}', function (Request $request, $id) {
        return "degree $id";
    });

    /* job fields list */
    Route::get('/jobs', function (Request $request) {
        return 'job fields list for admin';
    });

    Route::get('/job/{id}', function (Request $request, $id) {
        return "job $id";
    });

    /* marrige list */
    Route::get('/marrige', function (Request $request) {
        return 'marrige type list for admin';
    });

    Route::get('/marrige/{id}', function (Request $request, $id) {
        return "marrige {id}";
    });

    /* study fields list */
    Route::get('/fields', function (Request $request) {
        return 'study fields list for admin';
    });

    Route::get('/field/{id}', function (Request $request, $id) {
        return "field $id";
    });

    Route::get('/units', 'Unit@getAll');
    Route::get('/units/{name}', 'Unit@getCreatedBy');

    Route::get('/study_fields', 'StudyFields@getAll');
    Route::get('/job_fields', 'JobFields@getAll');
});