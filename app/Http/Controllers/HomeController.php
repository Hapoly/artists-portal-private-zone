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
        $profileName = Auth::user()->first_name . ' ' . Auth::user()->last_name;


        $myEvents = DB::table('events')
            ->limit(5)
            ->join('event_fields', 'event_fields.event_id', '=', 'events.id')
            ->join('art_fields', 'art_fields.art_field_id', '=', 'event_fields.art_field_id')
            ->where('art_fields.artist_id', '=', Auth::user()->id)
            ->groupBy('events.id')
            ->select(['events.*'])
            ->get();

        $allEvents = DB::table('events')
            ->limit(5)
            ->get();

        $messages = DB::table('messages')
            ->limit(5)
            ->where('reciever' ,Auth::user()->id)
            ->get();

        return view('dashboard', [
            'group_code'    => $userGroupId,
            'profile_name'  => $profileName,
            'myEvents'      => $myEvents,
            'allEvents'     => $allEvents,
            'messages'         => $messages,
        ]);
    }

    public function profileGet(Request $request){
        $userGroupId = Auth::user()->group_code;
        $userId = Auth::user()->id;
        $user = get_object_vars(DB::table('users')
            ->where('id', '=', $userId)
            ->first());

        return view('profile',[
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
        if (Auth::attempt([
                'email'     => $request->input('email'), 
                'password'  => $request->input('password'),
                'status'    => 2
            ])) {
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
                'tab'                       => 'register',
                'error_type'                => 'fail',
                ])->withErrors($validator);

        }else{

            $id = User::create([
                'first_name'        => $request->input('first_name'),
                'last_name'         => $request->input('last_name'),
                'email'             => $request->input('email'),
                'password'          => bcrypt($request->input('password')),
                'group_code'        => 1
            ])->id;
            DB::table('artists')->insert([
                'id'                => $id,
                'father_name'       => $request->input('father_name'),
                'nickname'          => $request->input('nickname'),
                'religion'          => $this->get_religion_code($request->input('religion')),
                'habitate_years'    => $request->input('habitate_years'),
                'habitate_place'    => $this->get_habitate_place_code($request->input('habitate_place')),
                'phone'             => $request->input('phone'),
                'cellphone'         => $request->input('cellphone'),
                'address'           => $request->input('address'),
                'birth_day'         => $request->input('birth_day'),
                'birth_month'       => $request->input('birth_month'),
                'birth_year'        => $request->input('birth_year'),
                'birth_place'       => $request->input('birth_place'),
                'profile'           => $request->file('profile_pic')->store('storage'),
                'id_card'           => $request->file('id_card_pic')->store('storage'),
            ]);

            $art_fields = json_decode($request->input('art-fields'));
            $educations = json_decode($request->input('educations'));
            foreach ($art_fields as $art_field) {
                DB::table('art_fields')->insert([
                    'artist_id'         => $id,
                    'art_field_id'      => $art_field->id,
                    'art_field_title'   => $art_field->title,
                ]);
            }

            foreach ($educations as $education) {
                DB::table('educations')->insert([
                    'artist_id'         => $id,
                    'education_id'      => $education->id,
                    'education_title'   => $education->title,
                ]);
            }

            Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]);
            return view('welcome', [
                'oldInputs'                 => $request->all(),
                'tab'                       => 'register',
                'error_type'                => 'done',
                ]);
        }
    }
    public function myRegisterValidate($request){
        $messages = [
            'first_name.*'                  => 'لطفا نام را وارد کنید',
            'last_name.*'                   => 'لطفا نام خانوادگی کاربر را وارد کنید',
            'email.*'                       => 'آدرس ایمیل نامعتبر',
            'father_name.*'                 => 'لطفا نام پدر خود را وارد کنید',
            'nickname.*'                    => 'نام هنری خود را وارد کنید',

            'religion.*'                    => 'مذهب نامعتبر است',
            'habitate_years.*'              => 'سال های سکونت نامعتبر است',
            'habitate_place.*'              => 'محل سکونت نامعتبر است',
            'phone.*'                       => 'شماره تماس همراه نامعتبر است',
            'cellphone.*'                   => 'شماره تلفن ثابت نامعتبر است',

            'address.*'                     => 'آدرس نامعتبر است',
            'birth_day.*'                   => 'روز تولد نامعتبر است',
            'birth_month.*'                 => 'ماه تولد نامعتبر است',
            'birth_year.*'                  => 'سال تولد نامعتبر است',
            'birth_place.*'                 => 'محل تولد را وارد کنید',
            'profile_pic.*'                 => 'عکس پرسنلی خود را انتخاب کنید',
            'id_card_pic.*'                 => 'اسکن کارت ملی خود را آپلود کنید',

            'password.*'                    => 'لطفا کلمه عبور را وارد کنید(حداقل ۴ حرف)',
            'password_conf.*'               => 'کلمات عبور یکسان نیستند',
        ];

        $rules = [
            'first_name'                  => 'required',
            'last_name'                   => 'required',
            'email'                       => 'required|email',
            'father_name'                 => 'required',
            'nickname'                    => 'required',

            'religion'                    => 'required',
            'habitate_years'              => 'required',
            'habitate_place'              => 'required',
            'phone'                       => 'required',
            'cellphone'                   => 'required',

            'address'                     => 'required',
            'birth_day'                   => 'required|numeric',
            'birth_month'                 => 'required|numeric',
            'birth_year'                  => 'required|numeric',
            'birth_place'                 => 'required',
            'password'                    => 'required|string|min:4',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }
    public function get_religion_code($title){
        $data = [
            "اسلام شیعه"    => 1,
            "اسلام سنی"     => 2,
            "مسیحیت"        => 3,
            "کلیمی"         => 4,
            "زرتشتی"        => 5,
            "رضا"           => 6,
        ];
        return $data[$title];
    }

    public function get_habitate_place_code($title){
        $data = [
            "رشت"       => 1,
            "آستانه"    => 2,
            "انزلی"     => 3,
            "صومعه سرا" => 4,
            "رودسر"     => 5,
            "لاهیجان"   => 6,
            "جیرده"     => 7,
        ];
        return $data[$title];
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