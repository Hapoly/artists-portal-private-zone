<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Unit extends Controller{
    public function getAll(Request $request){
        $units = DB::table('units')->select(['title'])->get();
        $result = array();
        foreach($units as $unit)
            array_push($result, $unit->title);
        return json_encode($result);
    }

    public function getCreatedBy($name){
        $units = DB::table('units')
            ->select(['title'])
            ->where('user', '=', $name)
            ->get();
        $result = array();
        foreach($units as $unit)
            array_push($result, $unit->title);
        return json_encode($result);
    }
}