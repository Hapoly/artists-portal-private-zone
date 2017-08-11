<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminusersController extends Controller
{
    public function list(Request $request, $page=0, $size=10)
    {
        $group_code = Auth::user()->group_code;
        $users = DB::table('users')->skip($page*$size)->limit($size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
            $users = $users->orderBy($order, 'asc');
        }
        $users = $users->get();
        
        $usersCount = DB::table('users')->count();

        $pageCount = ceil($usersCount / $size);

        return view('admin.users.list', [
            'users'     => $users, 
            'pageCount'     => $pageCount,
            'currentPage'   => $page,
            'group_code'    => $group_code,
            'pageSize'      => $size,
            'pagination'    => $this->generatePages($pageCount, $page),
            'sort'          => $request->has('sort')? ('?sort=' . $request->input('sort')) : '',
            ]);
    }

    public function editPost(Request $request, $id){
        $group_code = Auth::user()->group_code;
        $validator = $this->myValidate($request);
        if($validator->fails()){
            $oldInputs = $request->all();
            $oldInputs['id'] = $id;

            return view('admin.users.edit', [
                'group_code'                => $group_code,
                'oldInputs'                 => $oldInputs,
                ])->withErrors($validator);

        }else{
            $username = Auth::user()->name;;
            
            $has_certificate = $request->input('has_certificate');
            $has_licence = $request->input('has_licence');

            DB::table('users')->where(['id' => $id])->update(
                [
                    'name'                  => $request->input('name'),
                    'email'                 => $request->input('email'),
                    'password'              => bcrypt($request->input('password')),
                    'first_name'            => $request->input('first_name'),
                    'last_name'             => $request->input('last_name'),
                    'phone'                 => $request->input('phone'),
                    'cellphone'             => $request->input('cellphone'),
                    'group_code'            => $request->input('group_code'),
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('admin/user/' . $id);
        }
    }
    public function editGet(Request $request, $id, $watching='units', $page=0, $size=10){
        $group_code = Auth::user()->group_code;
        $users = get_object_vars(DB::table('users')->where('id', '=', $id)->first());

        $username = DB::table('users')
                    ->where('id', '=', $id)
                    ->first()->name;

        $units = null;
        $employees = null;

        if($watching == 'units'){

        }else if($watching == 'employees'){

            $employees = DB::table('employees')
                ->join('degrees', 'employees.degree', '=', 'degrees.id')
                ->join('study_fields', 'employees.field', '=', 'study_fields.id')
                ->join('cities', 'employees.habitate', '=', 'cities.id')
                ->join('units', 'employees.unit_id', '=', 'units.id')
                ->select(DB::raw("employees.id, employees.first_name, employees.last_name, degrees.title'degree', study_fields.title'field', units.title'unit', cities.title'habitate'"))
                ->limit($size)
                ->offset($page * $size)
                ->where('user', '=', $username)
                ->get();

            $employeeCount = DB::table('employees')->where('user', '=', $username)->count();

            $ePageCount = ceil($employeeCount / $size);
        }
        return view('admin.users.edit', [
            'group_code'                => $group_code,
            'oldInputs'                 => $users,
            ]);
    }

    public function remove(Request $request, $id){
        DB::table('users')->where('id', '=', $id)->delete();   
        return back();
    }

    public function newGet(Request $request){
        $group_code = Auth::user()->group_code;
        return view('admin.users.new', [
            'group_code'                => $group_code
            ]);
    }

    public function newPost(Request $request){
        $validator = $this->myValidate($request);
        $group_code = Auth::user()->group_code;
        var_dump($request->all());
        if($validator->fails()){

            return view('admin.users.new', [
                'group_code'                => $group_code,
                'oldInputs'                 => $request->all(),
                ])->withErrors($validator);

        }else{
            $username = Auth::user()->name;;

            $id = User::create([
                'name'        => $request->input('name'),
                'email'       => $request->input('email'),
                'password'    => bcrypt($request->input('password')),
                'first_name'  => $request->input('first_name'),
                'last_name'   => $request->input('last_name'),
                'phone'       => $request->input('phone'),
                'cellphone'   => $request->input('cellphone'),
                'group_code'  => $request->input('group_code'),
            ])->id;
            return redirect('admin/user/' . $id);
        }
    }
    public function myValidate($request){
        Validator::extend('checkIf', function ($attribute, $value, $parameters, $validator) {
            return !(in_array($parameters[0], array('on', 'true', 1, '1')));
        });
        $messages = [
            'first_name.*'                  => 'لطفا نام را وارد کنید',
            'last_name.*'                   => 'لطفا نام خانوادگی کاربر را وارد کنید',
            'email.*'                       => 'آدرس ایمیل نامعتبر',
            
            'name.*'                        => 'لطفا نام کاربری را وارد کنید',
            'password.*'                    => 'لطفا کلمه عبور را وارد کنید(حداقل ۴ حرف)',
            'group_code.*'                  => 'گروه کاربری نامعتبر است',
            
            'phone.*'                       => 'شماره تلفن ثابت نامعتبر است',
            'cellphone.*'                   => 'لطفا شماره تلفن همراه را وارد کنید',
        ];

        $rules = [
            'first_name'                => 'required',
            'last_name'                 => 'required',
            'email'                     => 'required|email',
            
            'name'                      => 'required|min:4',
            'password'                  => 'required|string|min:4',
            'group_code'                => 'required|in:0,1',
            
            'phone'                     => 'required|string',
            'cellphone'                 => 'required|string',
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
}