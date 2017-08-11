<?php

namespace App\Http\Controllers\RegularMember;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class NormalUnitsController extends Controller
{
    public function list(Request $request, $page=0, $size=10)
    {
        $group_code = Auth::user()->group_code;
        $units = DB::table('units')
            ->skip($page*$size)
            ->limit($size)
            ->where('user', '=', Auth::user()->name);

        $units = DB::table('units')->skip($page*$size)->limit($size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
            $units = $units->orderBy($order, 'asc');
        }
        $units = $units->get();

        $unitCount = DB::table('units')
            ->where('user', '=', Auth::user()->name)
            ->count();

        $pageCount = ceil($unitCount / $size);

        return view('normal.units.list', [
            'units'         => $units, 
            'pageCount'     => $pageCount,
            'currentPage'   => $page,
            'group_code'    => $group_code,
            'pageSize'      => $size,
            'pagination'    => $this->generatePages($pageCount, $page),
            'pageCount'     => $pageCount,
            'sort'          => $request->has('sort')? ('?sort=' . $request->input('sort')) : '',
            ]);
    }

    public function editPost(Request $request, $id, $page=0, $size=10){
        $group_code = Auth::user()->group_code;
        $validator = $this->myValidate($request);

        $employees = DB::table('employees')
            ->join('degrees', 'employees.degree', '=', 'degrees.id')
            ->join('study_fields', 'employees.field', '=', 'study_fields.id')
            ->join('cities', 'employees.habitate', '=', 'cities.id')
            ->join('units', 'employees.unit_id', '=', 'units.id')
            ->select(DB::raw("employees.id, employees.first_name, employees.last_name, degrees.title'degree', study_fields.title'field', units.title'unit', cities.title'habitate'"))
            ->where('employees.unit_id', '=', $id)
            ->get();
        $employeeCount = DB::table('employees')->where('employees.unit_id', '=', $id)->count();

        $pageCount = ceil($employeeCount / $size);


        if($validator->fails()){
            $oldInputs = $request->all();
            $oldInputs['id'] = $id;
            

            if( isset($oldInputs['has_certificate']))
                $oldInputs['has_certificate'] = 1;
            if( isset($oldInputs['has_licence']))
                $oldInputs['has_licence'] = 1;

            return view('normal.units.edit', [
                'group_code'                => $group_code,
                'oldInputs'                 => $oldInputs,
                'employees'                 => $employees,

                'genders'                   => DB::table('genders')                     ->get(),
                'cities'                    => DB::table('cities')                      ->get(),
                'certificateTypes'          => DB::table('certificate_types')           ->get(),
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'months'                     => config('constants.months')
                ])->withErrors($validator);

        }else{
            $username = Auth::user()->name;
            
            $has_certificate = $request->input('has_certificate');
            $has_licence = $request->input('has_licence');

            DB::table('units')->where(['id' => $id])->update(
                [
                    'user'                  => $username,
                    'title'                 => $request->input('title'),
                    'product'               => $request->input('product'),
                    'manager_title'         => $request->input('manager_title'),
                    'manager_gender'        => $request->input('manager_gender'),
                    'manager_id_number'     => $request->input('manager_id_number'),
                    'address'               => $request->input('address'),
                    'zip_code'              => $request->input('zip_code'),
                    'phone'                 => $request->input('phone'),
                    'cell_phone'            => $request->input('cell_phone'),
                    'has_certificate'       => $has_certificate ? '1': '0',
                    'certificate_id'        => $has_certificate ? $request->input('certificate_id') : '###',
                    'certificate_date'      => $has_certificate ? $request->input('certificate_date_year') . '-' . $request->input('certificate_date_month') . '-' . $request->input('certificate_date_day') : '###',
                    'certificate_type'      => $request->input('certificate_type'),
                    'has_licence'           => $has_licence ? '1' : '0',
                    'licence_id'            => $has_licence ? $request->input('licence_id') : '###',
                    'licence_date'          => $has_licence ? $request->input('licence_date_year') . '-' . $request->input('licence_date_month') . '-' . $request->input('licence_date_day') : '###',
                    'licence_source'        => $has_licence ? $request->input('licence_source') : 0,
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('unit/' . $id);
        }
    }
    public function editGet(Request $request, $id, $page=0, $size=10){
        $group_code = Auth::user()->group_code;
        $unit = get_object_vars(DB::table('units')->where('id', '=', $id)->first());

        if($unit['user'] != Auth::user()->name){
            return response()->view('errors.custom', [
                'group_code'    => $group_code,
                'status'        => 404,
                'message'       => 'کارگاه مورد نظر وجود ندارد. یا شما به این کارگاه دسترسی ندارید'
            ], 404);
        }

        if($unit['certificate_date'] != '###'){
            $certificate_date = explode('-', $unit['certificate_date']);
            $unit['certificate_date_day']   = $certificate_date[2];
            $unit['certificate_date_month'] = $certificate_date[1];
            $unit['certificate_date_year']  = $certificate_date[0];
        }

        if($unit['licence_date'] != '###'){
            $licence_date = explode('-', $unit['licence_date']);
            $unit['licence_date_day']   = $licence_date[2];
            $unit['licence_date_month'] = $licence_date[1];
            $unit['licence_date_year']  = $licence_date[0];
        }

        $employees = DB::table('employees')
            ->join('degrees', 'employees.degree', '=', 'degrees.id')
            ->join('study_fields', 'employees.field', '=', 'study_fields.id')
            ->join('cities', 'employees.habitate', '=', 'cities.id')
            ->join('units', 'employees.unit_id', '=', 'units.id')
            ->select(DB::raw("employees.id, employees.first_name, employees.last_name, degrees.title'degree', study_fields.title'field', units.title'unit', cities.title'habitate'"))
            ->where('employees.unit_id', '=', $id)
            ->limit($size)
            ->offset($size * $page)
            ->get();
        $employeeCount = DB::table('employees')->where('employees.unit_id', '=', $id)->count();
        $pageCount = ceil($employeeCount / $size);

        return view('normal.units.edit', [
            'group_code'                => $group_code,
            'oldInputs'                 => $unit,

            /* employees list */
            'employees'                 => $employees,
            'pageCount'                 => $pageCount,
            'currentPage'               => $page,
            'pageSize'                  => $size,
            'pagination'                => $this->generatePages($pageCount, $page),

            'cities'                    => DB::table('cities')                      ->get(),
            'genders'                   => DB::table('genders')                     ->get(),
            'certificateTypes'          => DB::table('certificate_types')           ->get(),
            'business_license_sources'  => DB::table('business_license_sources')    ->get(),
            'months'                     => config('constants.months')
            ]);
    }

    public function remove(Request $request, $id){
        DB::table('units')->where('id', '=', $id)->delete();   
        return back();
    }

    public function newGet(Request $request){
        $group_code = Auth::user()->group_code;
        return view('normal.units.new', [
            'group_code'                => $group_code,
            'genders'                   => DB::table('genders')                     ->get(),
            'cities'                    => DB::table('cities')                      ->get(),
            'certificateTypes'          => DB::table('certificate_types')           ->get(),
            'business_license_sources'  => DB::table('business_license_sources')    ->get(),
            'months'                    => config('constants.months')
            ]);
    }

    public function newPost(Request $request){
        $group_code = Auth::user()->group_code;
        $validator = $this->myValidate($request);
        if($validator->fails()){

            return view('normal.units.new', [
                'group_code'                => $group_code,
                'genders'                   => DB::table('genders')                     ->get(),
                'certificateTypes'          => DB::table('certificate_types')           ->get(),
                'cities'                    => DB::table('cities')                      ->get(),
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'oldInputs'                 => $request->all(),
                'months'                    => config('constants.months')
                ])->withErrors($validator);

        }else{
            $username = Auth::user()->name;
            
            $has_certificate = $request->input('has_certificate');
            $has_licence = $request->input('has_licence');

            $id = DB::table('units')->insertGetId(
                [
                    'user'                  => $username,
                    'title'                 => $request->input('title'),
                    'product'               => $request->input('product'),
                    'manager_title'         => $request->input('manager_title'),
                    'manager_gender'        => $request->input('manager_gender'),
                    'manager_id_number'     => $request->input('manager_id_number'),
                    'address'               => $request->input('address'),
                    'zip_code'              => $request->input('zip_code'),
                    'phone'                 => $request->input('phone'),
                    'cell_phone'            => $request->input('cell_phone'),
                    'has_certificate'       => $has_certificate ? '1': '0',
                    'certificate_id'        => $has_certificate ? $request->input('certificate_id') : '###',
                    'certificate_date'      => $has_certificate ? $request->input('certificate_date_year') . '-' . $request->input('certificate_date_month') . '-' . $request->input('certificate_date_day') : '###',
                    'certificate_type'      => $request->input('certificate_type'),
                    'has_licence'           => $has_licence ? '1' : '0',
                    'licence_id'            => $has_licence ? $request->input('licence_id') : '###',
                    'licence_date'          => $has_licence ? $request->input('licence_date_year') . '-' . $request->input('licence_date_month') . '-' . $request->input('licence_date_day') : '###',
                    'licence_source'        => $has_licence ? $request->input('licence_source') : 0,
                    'created_at'            => time()[0],
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('unit/' . $id);
        }
    }
    public function myValidate($request){
        Validator::extend('checkIf', function ($attribute, $value, $parameters, $validator) {
            return !(in_array($parameters[0], array('on', 'true', 1, '1')));
        });
        $messages = [
            'title.*'                     => 'خطا در فیلد عنوان کارگاه',
            'product.*'                   => 'خطا در فیلد نوع فعالیت یا محصول',

            'manager_title.*'             => 'خطا در نام مدیریت کارگاه',
            'manager_gender.*'           => 'خطا در جنسیت مدیر کارگاه',
            'manager_id_number.*'         => 'خطا در کد ملی مدیریت کارگاه',

            'address.*'                   => 'خطا در آدرس',
            'zip_code.*'                  => 'خطا در کد پستی',

            'phone.*'                     => 'خطا در شماره تلفن همراه',
            'cell_phone.*'                => 'خطا در شماره تماس ثابت',

            'certificate_id.*'            => 'خطا در شماره مجوز',
            'certificate_type.*'          => 'نوع مجوز نامعتبر است',

            'licence_id.*'                => 'پروانه کسب نامعتبر',
            'licence_source.*'            => 'مربج پروانه کسب نامعتبر است',
        ];

        $rules = [
            'title'                     => 'required|min:5',
            'product'                   => 'required|min:5',

            'manager_title'             => 'required|min:5',
            'manager_gender'           => 'required|in:2,3',
            'manager_id_number'         => 'required|size:10',

            'address'                   => 'required|min:5',
            'zip_code'                  => 'required|size:10',

            'phone'                     => 'required|size:11',
            'cell_phone'                => 'required|size:11',

            'certificate_id'            => 'required_with:has_certificate',

            'certificate_date_day'      => 'required|numeric|min:1|max:30',
            'certificate_date_month'    => 'required|numeric|min:1|max:12',
            'certificate_date_year'     => 'required|numeric|min:1380|max:1400',

            'licence_id'                => 'required_with:has_licence',

            'licence_date_day'          => 'required|numeric|min:1|max:30',
            'licence_date_month'        => 'required|numeric|min:1|max:12',
            'licence_date_year'         => 'required|numeric|min:1380|max:1400',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }
    function generatePages($total, $current){
        if($total > 1){
            $total=intval($total);

            $output=[];
            $current_page= (false == isset($current)) ? 0 : $current;
            $lastPage = -1;
            $lower = $current_page -3;
            $upper = $current_page +3;
            for($page=0;$page<$total;$page++){
                if(($page > $lower && $page < $upper) || $page < 1 || $page > ($total-2)){
                    if($lastPage + 1 != $page)
                        array_push($output, '#');
                    array_push($output, $page+1);
                    $lastPage = $page;
                }
            }
            return $output;
        }else{
            return [];
        }
    }

    function prettify($data){
        $result = [];
        foreach($data as $item){
            $result[$item->id] = $item->title;
        }
        $result[0] = 'مشخص نشده';
        return $result;
    }
    
    public function listPrint(Request $request){
        $startPage  = $request->input('startPage');
        $endPage    = $request->input('endPage');
        $pageSize   = $request->input('pageSize');

        $offset = $startPage * $pageSize;
        $limit = $pageSize * ($endPage - $startPage + 1);
        $units = DB::table('units')
            ->where('user', '=', Auth::user()->name)
            ->offset($offset)
            ->limit($limit)
            ->get();

        for($i=0; $i<sizeof($units); $i++){
            $employees = DB::table('employees')->where('id', '=', $units[$i]->id)->get();
            for($j=0; $j<sizeof($employees); $j++)
                $employees[$j]->unitTitle = DB::table('units')->where('id', '=', $employees[$j]->unit_id)->first()->title;
            $units[$i]->employees = $employees;

        }

        return view('prints/list-unit', [
            'units'             => $units,
            'field'             => $this->prettify(DB::table('study_fields')->get()),
            'degree'            => $this->prettify(DB::table('degrees')->get()),
            'job'               => $this->prettify(DB::table('job_fields')->get()),
            'certificate_types' => $this->prettify(DB::table('certificate_types')           ->get()),
            'licence_sources'   => $this->prettify(DB::table('business_license_sources')    ->get()),
            'marrige'           => $this->prettify(DB::table('merrige_types')->get()),
            'habitate'          => $this->prettify(DB::table('cities')->get()),
            'gender'            => $this->prettify(DB::table('genders')->get()),
            'completeUnits'     => $request->has('completeUnit') ? true : false,
            'showEmployees'     => $request->has('showEmployees')? true : false,
            'completeEmployee'  => $request->has('completeEmployee')? true : false,
            ])->render();
    }

    public function singlePrint(Request $request, $id){
        $unit = DB::table('units')->where('id', '=', $id)->first();
        $employees = DB::table('employees')->where('id', '=', $unit->id)->get();
        for($i=0; $i<sizeof($employees); $i++)
            $employees[$i]->unitTitle = DB::table('units')->where('id', '=', $employees[$i]->unit_id)->first()->title;

        return view('prints/single-unit', [
            'unit'              => $unit,
            'employees'         => $employees,
            'field'             => $this->prettify(DB::table('study_fields')                ->get()),
            'certificate_types' => $this->prettify(DB::table('certificate_types')           ->get()),
            'licence_sources'   => $this->prettify(DB::table('business_license_sources')    ->get()),
            'degree'            => $this->prettify(DB::table('degrees')                     ->get()),
            'job'               => $this->prettify(DB::table('job_fields')                  ->get()),
            'marrige'           => $this->prettify(DB::table('merrige_types')               ->get()),
            'habitate'          => $this->prettify(DB::table('cities')                      ->get()),
            'gender'            => $this->prettify(DB::table('genders')                     ->get()),
            'showEmployees'      => $request->has('showEmployees')? true : false,
            'complete'          => $request->has('complete')? true : false,
            ])->render();
    }
}