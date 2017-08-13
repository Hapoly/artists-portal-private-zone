<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminArtistsController extends Controller
{
    public function list(Request $request, $page=1)
    {
        $size = 10;

        $artists = DB::table('users')
            ->join('artists', 'artists.id', '=', 'users.id')
            ->select(['users.first_name', 'users.last_name', 'users.email', 'users.status', 'artists.*'])
            ->where('users.group_code', '1')
            ->limit($size)
            ->offset(($page-1)*$size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
                $artists = $artists->orderBy($order, 'asc');
        }
        $artists = $artists->get();
        $artistsCount = DB::table('users')->where('group_code', '1')->count();

        $pageCount = ceil($artistsCount / $size);

        return view('admin.artists.list', [
            'artists'       => $artists,
            'page'          => $page,
            'pageSize'      => $size,
            'pagination'    => $this->generatePages($pageCount, $page),
            'pageCount'     => ceil($artistsCount / $size),
            'sort'          => $request->has('sort')? ('?sort=' . $request->input('sort')) : '',
            ]);
    }

    public function view(Request $request, $id){
        $artist = DB::table('users')
            ->join('artists', 'artists.id', '=', 'users.id')
            ->select(
                [
                    'users.first_name',
                    'users.last_name',
                    'users.status',
                    'users.email',
                    'artists.*',
                ])
            ->where('users.group_code', '=', '1')
            ->where('users.id', '=', $id)
            ->first();

        $educations = DB::table('educations')->where('artist_id', $id)->get();
        $art_fields = DB::table('art_fields')->where('artist_id', $id)->get();

        $artist->religion = $this->get_religion_code($artist->religion);
        $artist->habitate_place = $this->get_habitate_place_code($artist->habitate_place);

        return view('admin.artists.view', [
            'artist'        => $artist,
            'educations'    => $educations,
            'art_fields'    => $art_fields,
        ]);
    }
    public function editPost(Request $request, $id){
        $group_code = Auth::user()->group_code;
        $validator = $this->myValidate($request);
        if($validator->fails()){
            $oldInputs = $request->all();
            $oldInputs['id'] = $id;

            return view('admin.employees.edit', [
                'genders'                   => DB::table('genders')                     ->get(),
                'certificateTypes'          => DB::table('certificate_types')           ->get(),
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'habitates'                 => DB::table('cities')                      ->get(),
                'degrees'                   => DB::table('degrees')                     ->get(),
                'study_fields'              => DB::table('study_fields')                ->get(),
                'job_fields'                => DB::table('job_fields')                  ->get(),
                'marriges'                  => DB::table('merrige_types')               ->get(),
                'months'                    => config('constants.months')
                ])->withErrors($validator);

        }else{
            $username = Auth::user()->name;
            
            $unitId = DB::table('units')->where('title', '=', $request->input('unit_title'))->first()->id;
            $fieldId = DB::table('study_fields')->where('title', '=', $request->input('field_title'))->first()->id;

            DB::table('employees')->where(['id' => $id])->update(
                [
                    'user'                  => $username,
                    'unit_id'               => $unitId,
                    'first_name'            => $request->input('first_name'),
                    'last_name'             => $request->input('last_name'),
                    'father_name'           => $request->input('father_name'),
                    'id_number'             => $request->input('id_number'),
                    'gender'                => $request->input('gender'),
                    'birth_date'            => $request->input('birth_date_year') . '-' . $request->input('birth_date_month') . '-' . $request->input('birth_date_day'),
                    'birth_place'           => $request->input('birth_place'),
                    'habitate'              => $request->input('habitate'),
                    'habitate_years'        => $request->input('habitate_years'),
                    'degree'                => $request->input('degree'),
                    'field'                 => $fieldId,
                    'job'                   => $request->input('job'),
                    'marrige'               => $request->input('marrige'),
                    'dependents'            => $request->input('dependents'),
                    'experience'            => $request->input('experience'),
                    'address'               => $request->input('address'),
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('admin/employee/' . $id);
        }
    }
    public function editGet(Request $request, $id){
        $artist = DB::table('users')
            ->join('artists', 'artists.id', '=', 'users.id')
            ->select(
                [
                    'users.first_name',
                    'users.last_name',
                    'users.status',
                    'users.email',
                    'artists.*',
                ])
            ->where('users.group_code', '=', '1')
            ->where('users.id', '=', $id)
            ->first();

        $educations = DB::table('educations')->where('artist_id', $id)->get();
        $art_fields = DB::table('art_fields')->where('artist_id', $id)->get();

        $artist->religion = $this->get_religion_code($artist->religion);
        $artist->habitate_place = $this->get_habitate_place_code($artist->habitate_place);

        return view('admin.artists.edit', [
            'name'          => $artist->first_name . ' ' . $artist->last_name,
            'oldInputs'     => json_decode(json_encode($artist), True),
            'educations'    => $educations,
            'art_fields'    => $art_fields,
        ]);

    }

    public function remove(Request $request, $id){
        DB::table('employees')->where('id', '=', $id)->delete();   
        return back();
    }

    public function newGet(Request $request, $unitId=0){
        $group_code = Auth::user()->group_code;
        $unitTitle = '';
        if($unitId != 0)
            $unitTitle = DB::table('units')->where('id', '=', $unitId)->first()->title;
        

        return view('admin.employees.new', [
            'unit_title'                => $unitTitle,
            'group_code'                => $group_code,
            'genders'                   => DB::table('genders')                     ->get(),
            'certificateTypes'          => DB::table('certificate_types')           ->get(),
            'business_license_sources'  => DB::table('business_license_sources')    ->get(),
            'habitates'                 => DB::table('cities')                      ->get(),
            'degrees'                   => DB::table('degrees')                     ->get(),
            'study_fields'              => DB::table('study_fields')                ->get(),
            'job_fields'                => DB::table('job_fields')                  ->get(),
            'marriges'                  => DB::table('merrige_types')               ->get(),
            'months'                    => config('constants.months')
            ]);
    }

    public function newPost(Request $request){
        $validator = $this->myValidate($request);
        $group_code = Auth::user()->group_code;
        if($validator->fails()){

            return view('admin.employees.new', [
                'group_code'                => $group_code,
                'genders'                   => DB::table('genders')                     ->get(),
                'certificateTypes'          => DB::table('certificate_types')           ->get(),
                'habitates'                 => DB::table('cities')                      ->get(),
                'degrees'                   => DB::table('degrees')                     ->get(),
                'study_fields'              => DB::table('study_fields')                ->get(),
                'job_fields'                => DB::table('job_fields')                  ->get(),
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'marriges'                  => DB::table('merrige_types')               ->get(),
                'oldInputs'                 => $request->all(),
                'months'                    => config('constants.months')
                ])->withErrors($validator);

        }else{
            $username = Auth::user()->name;
            $unitId = DB::table('units')->where('title', '=', $request->input('unit_title'))->first()->id;
            $fieldId = DB::table('study_fields')->where('title', '=', $request->input('field_title'))->first()->id;

            $id = DB::table('employees')->insertGetId(
                [
                    'user'                  => $username,
                    'unit_id'               => $unitId,
                    'first_name'            => $request->input('first_name'),
                    'last_name'             => $request->input('last_name'),
                    'father_name'           => $request->input('father_name'),
                    'id_number'             => $request->input('id_number'),
                    'gender'                => $request->input('gender'),
                    'birth_date'            => $request->input('birth_date_year') . '-' . $request->input('birth_date_month') . '-' . $request->input('birth_date_day'),
                    'birth_place'           => $request->input('birth_place'),
                    'habitate'              => $request->input('habitate'),
                    'habitate_years'        => $request->input('habitate_years'),
                    'degree'                => $request->input('degree'),
                    'field'                 => $fieldId,
                    'job'                   => $request->input('job'),
                    'marrige'               => $request->input('marrige'),
                    'dependents'            => $request->input('dependents'),
                    'experience'            => $request->input('experience'),
                    'address'               => $request->input('address'),
                    'created_at'            => time()[0],
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('admin/employee/' . $id);
        }
    }
    public function myValidate($request){
        Validator::extend('checkIf', function ($attribute, $value, $parameters, $validator) {
            return !(in_array($parameters[0], array('on', 'true', 1, '1')));
        });
        $messages = [
            'first_name.*'                => 'لطفا نام خود را وارد کنید',
            'last_name.*'                 => 'لطفا نام خانوادگی خود را وارد کنید',
            
            'gender.*'                    => 'جنسیت وارد نشده است',
            'id_number.*'                 => 'کد ملی شاغل وارد نشده است',
            'father_name.*'               => 'نام ‍پدر وارد نشده است',
            
            'birth_date_day.*'            => 'روز تولد انتخاب نشده است',
            'birth_date_month.*'          => 'ماه تولد انتخاب نشده است',
            'birth_date_year.*'           => 'سال تولد انتخاب نشده است',

            'birth_place.*'               => 'محل تولد انتخاب نشده است',

            'habitate.*'                  => 'محل سکونت را انتخاب کنید',
            'habitate_years.*'            => 'مدت سال های سکونت را انتخاب کنید',

            'degree.*'                    => 'مدرک تحصیلی انتخاب نشده است',
            'field_title.*'               => 'رشته تحصیلی انتخاب نشده است',
            'job.*'                       => 'عنوان شغلی نامعتبر است',

            'marrige.*'                   => 'خطا در وضعیت تاهل',
            'dependents.*'                => 'تعداد افراد تحت تکفل نامعتبر است',

            'unit_title'                  => 'عنوان کرگاه را وارد کنید',
            'experience.*'                => 'تعداد ماه های سابقه کاری را وارد کنید',
            'address.*'                   => 'آدرس را وارد کنید',
        ];

        $rules = [
            'first_name'                => 'required',
            'last_name'                 => 'required',
            
            'gender'                    => 'required|numeric|int:2,3',
            'id_number'                 => 'required|size:10',
            'father_name'               => 'required',
            
            'birth_date_day'            => 'required|numeric|min:1|max:30',
            'birth_date_month'          => 'required|numeric|min:1|max:12',
            'birth_date_year'           => 'required|numeric',

            'birth_place'               => 'required',

            'habitate'                  => 'required|numeric',
            'habitate_years'            => 'required|numeric',

            'degree'                    => 'required|numeric',
            'field_title'               => 'required',
            'job'                       => 'required|numeric',

            'marrige'                   => 'required|numeric',
            'dependents'                => 'required|numeric',

            'experience'                => 'required|numeric',
            'unit_title'                => 'required',
            'address'                   => 'required',
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
        $employees = DB::table('employees')
            ->offset($offset)
            ->limit($limit)
            ->get();

        for($i=0; $i<sizeof($employees); $i++){
            $employees[$i]->unitTitle = DB::table('units')->where('id', '=', $employees[$i]->unit_id)->first()->title;
        }

        return view('prints/list-employee', [
            'employees'         => $employees,
            'field'             => $this->prettify(DB::table('study_fields')->get()),
            'degree'            => $this->prettify(DB::table('degrees')->get()),
            'job'               => $this->prettify(DB::table('job_fields')->get()),
            'marrige'           => $this->prettify(DB::table('merrige_types')->get()),
            'habitate'          => $this->prettify(DB::table('cities')->get()),
            'gender'            => $this->prettify(DB::table('genders')->get()),
            'complete'          => $request->has('complete')? true : false,
            ])->render();
    }

    public function singlePrint($id){
        $employee = DB::table('employees')->where('id', '=', $id)->first();
        $unitTitle = DB::table('units')->where('id', '=', $employee->unit_id)->first()->title;
        return view('prints/single-employee', [
            'info'              => $employee,
            'field'             => $this->prettify(DB::table('study_fields')->get()),
            'degree'            => $this->prettify(DB::table('degrees')->get()),
            'job'               => $this->prettify(DB::table('job_fields')->get()),
            'marrige'           => $this->prettify(DB::table('merrige_types')->get()),
            'habitate'          => $this->prettify(DB::table('cities')->get()),
            'gender'            => $this->prettify(DB::table('genders')->get()),
            'unitTitle'         => $unitTitle,
            ])->render();
    }

    public function get_religion_code($title){
        $data = [
            1 => "اسلام شیعه",
            2 => "اسلام سنی",
            3 => "مسیحیت",
            4 => "کلیمی",
            5 => "زرتشتی",
            6 => "رضا",
        ];
        return $data[$title];
    }

    public function get_habitate_place_code($title){
        $data = [
            1 => "رشت",
            2 => "آستانه",
            3 => "انزلی",
            4 => "صومعه سرا",
            5 => "رودسر",
            6 => "لاهیجان",
            7 => "جیرده",
        ];
        return $data[$title];
    }
}