<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/users', function (Request $request) {
        return json_encode(
                DB::table('users')
                    ->where('group_code', 2)
                    ->get()
            );
});