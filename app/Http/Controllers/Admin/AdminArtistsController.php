<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;

class AdminArtistsController extends Controller
{
    public function list(Request $request, $page=1)
    {
        $size = 10;

        $artists = DB::table('users')
            ->join('artists', 'artists.id', '=', 'users.id')
            ->join('art_fields', 'art_fields.artist_id', '=', 'artists.id')
            ->select(['users.first_name', 'users.last_name', 'users.email', 'users.status', 'artists.*', 'art_fields.art_field_title'])
            ->where('users.group_code', '1')
            ->limit($size)
            ->offset(($page-1)*$size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
                $artists = $artists->orderBy($order, 'asc');
        }

        if($request->has('search')){
            $search_string = $request->input('search');
            $search_parts = explode(' ', $search_string);
            for($i=0; $i<sizeof($search_parts); $i++)
              $search_parts[$i] = "users.first_name LIKE '%".$search_parts[$i]."%' OR users.last_name LIKE '%".$search_parts[$i]."%'";
            $artists = $artists->whereRaw(implode(' OR ', $search_parts));
        }

        if($request->has('first_name')){
            $search = $request->input('first_name');
            $artists = $artists->whereRaw("users.first_name LIKE '%$search%'");   
        }

        if($request->has('last_name')){
            $search = $request->input('last_name');
            $artists = $artists->whereRaw("users.last_name LIKE '%$search%'");   
        }
        
        if($request->input('religion') != 0){
            $search = $request->input('religion');
            $artists = $artists->whereRaw("artists.religion = $search");
        }

        if($request->input('habitate_place') != 0){
            $search = $request->input('habitate_place');
            $artists = $artists->whereRaw("artists.habitate_place = $search");
        }

        if($request->input('gender') != 0){
            $search = $request->input('gender');
            $artists = $artists->whereRaw("artists.gender = $search");
        }
        
        if($request->input('art-fields') != '[]' && $request->input('art-fields') != NULL){
          $art_fields = json_decode($request->input('art-fields'));
          $where_caluses = [];
          foreach($art_fields as $art_field)
            array_push($where_caluses, 'art_fields.art_field_id = ' . $art_field->id);
          $where_query = implode(' OR ', $where_caluses);
          $artists = $artists->whereRaw($where_query);
        }
        
        $artists = $artists->get();
        $result = array();
        foreach ($artists as $data) {
          $id = $data->id;
          if (isset($result[$id])) {
             $result[$id] = $data;
          } else {
             $result[$id] = $data;
          }
        }
        $artists = $result;
        $artistsCount = DB::table('users')->where('group_code', '1')->count();

        $pageCount = ceil($artistsCount / $size);

        if($request->has('print'))
        return view('admin.artists.list_print', [
          'artists'         => $artists,
          'page'            => $page,
          'pageSize'        => $size,
          'pageCount'       => ceil($artistsCount / $size),
          'sort'            => $request->has('sort')? ('?sort=' . $request->input('sort'))            : '',
          'search'          => $request->has('search')          ? $request->input('search')           : '',
          'last_name'       => $request->has('last_name')       ? $request->input('last_name')        : '',
          'first_name'      => $request->has('first_name')      ? $request->input('first_name')       : '',
          'religion'        => $request->has('religion')        ? $request->input('religion')         : '',
          'habitate_place'  => $request->has('habitate_place')  ? $request->input('habitate_place')   : '',
          'gender'          => $request->has('gender')          ? $request->input('gender')           : '',
          'art_fields'      => $request->has('art-fields')      ? $request->input('art-fields')       : '[]',
          ]);
        else
          return view('admin.artists.list', [
              'artists'         => $artists,
              'page'            => $page,
              'pageSize'        => $size,
              'pageCount'       => ceil($artistsCount / $size),
              'sort'            => $request->has('sort')? ('?sort=' . $request->input('sort'))            : '',
              'search'          => $request->has('search')          ? $request->input('search')           : '',
              'last_name'       => $request->has('last_name')       ? $request->input('last_name')        : '',
              'first_name'      => $request->has('first_name')      ? $request->input('first_name')       : '',
              'religion'        => $request->has('religion')        ? $request->input('religion')         : '',
              'habitate_place'  => $request->has('habitate_place')  ? $request->input('habitate_place')   : '',
              'gender'          => $request->has('gender')          ? $request->input('gender')           : '',
              'art_fields'      => $request->has('art-fields')      ? $request->input('art-fields')       : '[]',
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
        $validator = $this->myArtistEditValidate($request);
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

        if($validator->fails()){
            return view('admin.artists.edit', [
                'name'          => $artist->first_name . ' ' . $artist->last_name,
                'oldInputs'     => $request->all(),
                'artist'        => $artist,
                'id'            => $artist->id,
                'educations'    => $educations,
                'art_fields'    => $art_fields,
                'error_type'    => 'fail'
            ])->withErrors($validator);
            
        }else{
            DB::table('users')->where(['id' => $id])
                ->update([
                        'first_name'        => $request->input('first_name'),
                        'last_name'         => $request->input('last_name'),
                    ]);

            DB::table('artists')->where(['id' => $id])
                ->update([
                    'father_name'       => $request->input('father_name'),
                    'nickname'          => $request->input('nickname'),
                    'religion'          => $this->get_religion_title($request->input('religion')),
                    'habitate_years'    => $request->input('habitate_years'),
                    'habitate_place'    => $this->get_habitate_place_title($request->input('habitate_place')),
                    'phone'             => $request->input('phone'),
                    'cellphone'         => $request->input('cellphone'),
                    'address'           => $request->input('address'),
                    'birth_day'         => $request->input('birth_day'),
                    'birth_month'       => $request->input('birth_month'),
                    'birth_year'        => $request->input('birth_year'),
                    'birth_place'       => $request->input('birth_place'),
            ]);
            $oldInputs = $request->all();

            if($request->hasFile('profile_pic')){
                $path = $request->file('profile_pic')->store('storage');
                DB::table('artists')->where(['id' => $id])->update(['profile' => $path]);
                $oldInputs['profile_pic'] = $path;
            }
            if($request->hasFile('id_card_pic')){
                $path = $request->file('id_card_pic')->store('storage');
                DB::table('artists')->where(['id' => $id])->update(['id_card' => $path]);
                $oldInputs['id_card_pic'] = $path;
            }

            $art_fields = json_decode($request->input('art-fields'));
            $educations = json_decode($request->input('educations'));

            DB::table('art_fields')->where(['artist_id' => $id])->delete();
            foreach ($art_fields as $art_field) {
                DB::table('art_fields')->insert([
                    'artist_id'         => $id,
                    'art_field_id'      => $art_field->id,
                    'art_field_title'   => $art_field->title,
                ]);
            }

            DB::table('educations')->where(['artist_id' => $id])->delete();
            foreach ($educations as $education) {
                DB::table('educations')->insert([
                    'artist_id'         => $id,
                    'education_id'      => $education->id,
                    'education_title'   => $education->title,
                ]);
            }

            $educations = DB::table('educations')->where('artist_id', $id)->get();
            $art_fields = DB::table('art_fields')->where('artist_id', $id)->get();

            return view('admin.artists.edit', [
                'name'          => $artist->first_name . ' ' . $artist->last_name,
                'oldInputs'     => $oldInputs,
                'artist'        => $artist,
                'educations'    => $educations,
                'id'            => $artist->id,
                'art_fields'    => $art_fields,
                'error_type'    => 'done',
                ]);
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
            'artist'        => $artist,
            'educations'    => $educations,
            'id'            => $artist->id,
            'art_fields'    => $art_fields,
        ]);

    }

    public function remove(Request $request, $id){
        DB::table('users')->where('id', '=', $id)->update(['status' => 4]);
        return back();
    }

    public function accept(Request $request, $id){
        DB::table('users')->where('id', '=', $id)->update(['status' => 2]);
        return back();
    }

    public function ban(Request $request, $id){
        DB::table('users')->where('id', '=', $id)->update(['status' => 3]);
        return back();
    }

    public function active(Request $request, $id){
        DB::table('users')->where('id', '=', $id)->update(['status' => 2]);
        return back();
    }

    public function recylce(Request $request, $id){
        DB::table('users')->where('id', '=', $id)->update(['status' => 2]);
        return back();
    }

    public function newGet(Request $request){
        return view('admin.artists.new',[
            'art_fields' => [],
            'educations' => [],
            ]);
    }

    public function newPost(Request $request){
        $validator = $this->myNewArtistValidate($request);
        if($validator->fails()){
            $oldInputs = $request->all();
            $oldInputs['educations'] = json_decode($oldInputs['educations']);
            $oldInputs['art-fields'] = json_decode($oldInputs['art-fields']);
            //die(json_encode($oldInputs));

            return view('admin.artists.new', [
                'oldInputs'                 => $oldInputs,
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
                'religion'          => $this->get_religion_title($request->input('religion')),
                'habitate_years'    => $request->input('habitate_years'),
                'habitate_place'    => $this->get_habitate_place_title($request->input('habitate_place')),
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

            return redirect()->intended('admin/artist/show/' . $id);
        }
    }
    public function myArtistEditValidate($request){
        $messages = [
            'first_name.*'                  => 'لطفا نام را وارد کنید',
            'last_name.*'                   => 'لطفا نام خانوادگی کاربر را وارد کنید',
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
        ];

        $rules = [
            'first_name'                  => 'required',
            'last_name'                   => 'required',
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
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }

    public function myNewArtistValidate($request){
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
            'email'                       => 'required|email|unique',
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


    public function get_religion_code($code){
        $data = [
            1 => "اسلام شیعه",
            2 => "اسلام سنی",
            3 => "مسیحیت",
            4 => "کلیمی",
            5 => "زرتشتی",
            6 => "رضا",
        ];
        return $data[$code];
    }

    public function get_habitate_place_code($code){
        $data = [
            1 => "رشت",
            2 => "آستانه",
            3 => "انزلی",
            4 => "صومعه سرا",
            5 => "رودسر",
            6 => "لاهیجان",
            7 => "جیرده",
        ];
        return $data[$code];
    }

    public function get_religion_title($title){
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

    public function get_habitate_place_title($title){
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
}