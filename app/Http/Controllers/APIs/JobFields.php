<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobFields extends Controller{
    public function getAll(Request $request){
        $units = DB::table('job_fields')->select(['title'])->get();
        $result = array();
        foreach($units as $unit)
            array_push($result, $unit->title);
        return json_encode($result);
    }
}