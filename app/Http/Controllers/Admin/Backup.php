<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class Backup extends Controller
{
    public function get(Request $request){
        $group_code = Auth::user()->group_code;
        return view('admin.backup', [
            'group_code'        => $group_code,
        ]);
    }

    public function post(Request $request){
        $group_code = Auth::user()->group_code;

        $employees = DB::table('employees')->get();
        $units = DB::table('units')->get();
        $reports = DB::table('reports')->get();

        $backup = [
            'employees'     => $employees,
            'units'         => $units,
            'reports'       => $reports
        ];

        file_put_contents('backup' . time() . '.json', json_encode($backup));

        $employeesCount = DB::table('employees')->count();
        $unitsCount = DB::table('units')->count();
        $reportsCount = DB::table('reports')->count();

        return view('admin.backup', [
            'employees'         => $employeesCount,
            'units'             => $unitsCount,
            'reports'           => $reportsCount,
            'group_code'        => $group_code,
        ]);
    }
}