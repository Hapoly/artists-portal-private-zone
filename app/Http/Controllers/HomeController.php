<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $userGroupId = Auth::user()->group_code;

        $userCount      = DB::table('users')        ->count();
        $unitCount      = DB::table('units')        ->count();
        $employeeCount  = DB::table('employees')    ->count();

        $reports = DB::table('reports')
            ->limit(5)->get();


        return view('dashboard', [
            'reports'       => $reports, 
            'group_code'    => $userGroupId,
            'userCount'     => $userCount,
            'unitCount'     => $unitCount,
            'types'         => [
                1   => 'تعداد',
                2   => 'لیست'
            ],
            'employeeCount' => $employeeCount,

            ]);
    }

    public function profileGet(Request $request){
        $userGroupId = Auth::user()->group_code;
        $userId = Auth::user()->id;
        $user = get_object_vars(DB::table('users')
            ->where('id', '=', $userId)
            ->first());

        return view('profile',
            [
                'group_code'    => $userGroupId,
                'user'          => $user,
                'name'          => Auth::user()->name
            ]);
    }

    public function profilePost(Request $request){
        $userGroupId = Auth::user()->group_code;
        $validator = $this->myProfileValidate($request);
        if($validator->fails()){
            $oldInputs = $request->all();

            return view('profile', [
                'group_code'            => $userGroupId,
                'user'                  => $oldInputs,
                'name'                  => Auth::user()->name
                ])->withErrors($validator);

        }else{
            if ($request->input('password') == 'THIS_IS_A_NOT_PASSWORD'){

                DB::table('users')->where(['name' => Auth::user()->name])->update(
                    [
                        'email'                 => $request->input('email'),
                        'first_name'            => $request->input('first_name'),
                        'last_name'             => $request->input('last_name'),
                        'phone'                 => $request->input('phone'),
                        'cellphone'             => $request->input('cellphone'),
                        'updated_at'            => time()[0]
                    ]
                );   
                
            }else{

                DB::table('users')->where(['name' => Auth::user()->name])->update(
                    [
                        'email'                 => $request->input('email'),
                        'password'              => bcrypt($request->input('password')),
                        'first_name'            => $request->input('first_name'),
                        'last_name'             => $request->input('last_name'),
                        'phone'                 => $request->input('phone'),
                        'cellphone'             => $request->input('cellphone'),
                        'updated_at'            => time()[0]
                    ]
                );   
            }

            return redirect('profile');
        }
    }

    public function login(Request $request){
        if (Auth::attempt(['name' => $request->input('name'), 'password' => $request->input('password')])) {
            return redirect()->intended('dashboard');
        }else{
            return redirect('/')->withErrors(array('auth-failed' => 'نام کاربری یا کلمه عبور اشتباه است'));;
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }
    public function register(Request $request){
        $validator = $this->myRegisterValidate($request);
        if($validator->fails()){
            return view('welcome', [
                'oldInputs'                 => $request->all(),
                'tab'                       => 'register'
                ])->withErrors($validator);

        }else{
            $id = User::create([
                'name'        => $request->input('name'),
                'email'       => $request->input('email'),
                'password'    => bcrypt($request->input('password')),
                'first_name'  => $request->input('first_name'),
                'last_name'   => $request->input('last_name'),
                'phone'       => $request->input('phone'),
                'cellphone'   => $request->input('cellphone'),
                'group_code'  => 0,
            ])->id;
            Auth::attempt(['name' => $request->input('name'), 'password' => $request->input('password')]);
            return redirect('dashboard');
        }
    }
    public function myRegisterValidate($request){
        Validator::extend('checkIf', function ($attribute, $value, $parameters, $validator) {
            return !(in_array($parameters[0], array('on', 'true', 1, '1')));
        });
        $messages = [
            'first_name.*'                  => 'لطفا نام را وارد کنید',
            'last_name.*'                   => 'لطفا نام خانوادگی کاربر را وارد کنید',
            'email.*'                       => 'آدرس ایمیل نامعتبر',
            
            'name.*'                        => 'لطفا نام کاربری را وارد کنید',
            'password.*'                    => 'لطفا کلمه عبور را وارد کنید(حداقل ۴ حرف)',
            
            'phone.*'                       => 'شماره تلفن ثابت نامعتبر است',
            'cellphone.*'                   => 'لطفا شماره تلفن همراه را وارد کنید',
        ];

        $rules = [
            'first_name'                => 'required',
            'last_name'                 => 'required',
            'email'                     => 'required|email',
            
            'name'                      => 'required|min:4',
            'password'                  => 'required|string|min:4',
            'password_conf'             => 'required|confirmed:password',
            'phone'                     => 'required|string',
            'cellphone'                 => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }
    public function myProfileValidate($request){
        Validator::extend('checkIf', function ($attribute, $value, $parameters, $validator) {
            return !(in_array($parameters[0], array('on', 'true', 1, '1')));
        });
        $messages = [
            'first_name.*'                  => 'لطفا نام را وارد کنید',
            'last_name.*'                   => 'لطفا نام خانوادگی کاربر را وارد کنید',
            'email.*'                       => 'آدرس ایمیل نامعتبر',
            
            'password.*'                    => 'لطفا کلمه عبور را وارد کنید(حداقل ۴ حرف)',
            
            'phone.*'                       => 'شماره تلفن ثابت نامعتبر است',
            'cellphone.*'                   => 'لطفا شماره تلفن همراه را وارد کنید',
        ];

        $rules = [
            'first_name'                => 'required',
            'last_name'                 => 'required',
            'email'                     => 'required|email',
            
            'password'                  => 'required|string|min:4',
            
            'phone'                     => 'required|string',
            'cellphone'                 => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }
}