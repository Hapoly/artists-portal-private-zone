<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;

class AdminEventsController extends Controller
{
    /* events status
        1 -> pending for accept
        2 -> active
        3 -> deactive
        4 -> removed
    */
    public function list(Request $request, $page=1)
    {
        $size = 10;

        $events = DB::table('events')
            ->limit($size)
            ->offset(($page-1)*$size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
                $events = $events->orderBy($order, 'asc');
        }

        if($request->has('search')){
            $search = $request->input('search');
            $events = $events->whereRaw("events.title '%$search%'");
        }
        $events = $events->get();
        $eventsCount = DB::table('events')->count();

        $pageCount = ceil($eventsCount / $size);

        return view('admin.events.list', [
            'events'       => $events,
            'page'          => $page,
            'pageSize'      => $size,
            'pageCount'     => ceil($eventsCount / $size),
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
        return view('admin.events.new',[
                'art_fields' => [],
            ]);
    }

    public function newPost(Request $request){
        $validator = $this->myNewEventValidate($request);
        if($validator->fails()){
            $oldInputs = $request->all();
            $oldInputs['art-fields'] = json_decode($oldInputs['art-fields']);

            return view('admin.events.new', [
                'oldInputs'                 => $oldInputs,
                'error_type'                => 'fail',
                ])->withErrors($validator);

        }else{
            $id = DB::table('events')->insertGetId([
                    'title'         => $request->input('title'),
                    'description'   => $request->input('description'),
                    'start'         => $request->input('start_day') . '-' .
                                       $request->input('start_month') . '-' .
                                       $request->input('start_year'),
                    'end'           => $request->input('end_day') . '-' .
                                       $request->input('end_month') . '-' .
                                       $request->input('end_year'),
                    'status'        => 2

                ]);
            
            $art_fields = json_decode($request->input('art-fields'));
            foreach ($art_fields as $art_field) {
                DB::table('art_fields')->insert([
                    'artist_id'         => $id,
                    'art_field_id'      => $art_field->id,
                    'art_field_title'   => $art_field->title,
                ]);
            }

            if($request->hasFile('images')){
                $images = [];
                foreach($request->file('images') as $image){
                    $path = $image->store('storage');
                    DB::table('event_images')->insert([
                        'event_id' => $id,
                        'name' => $path
                    ]);
                    array_push($images, $path);
                }
                $oldInputs['images'] = $images;
            }

            return redirect()->intended('admin/event/show/' . $id);
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

    public function myNewEventValidate($request){
        $messages = [
            'title.*'                     => 'لطفا عنوان را انتخاب کنید',
            'description.*'               => 'لطفا توضیحات را وارد کنید',
            'art-fields.*'                => 'لطفا حداقل یک حوزه هنری برای رویداد انتخاب کنید',

            'start_day.*'                 => 'لطفا روز شروع را انتخاب کنید',
            'start_month.*'               => 'لطفا ماه شروع رویداد را انتخاب کنید',
            'start_year.*'                => 'لطفا سال شروع رویداد را انتخاب کنید',
            
            'end_day.*'                   => 'لطفا روز پایان رویداد را انتخاب کنید',
            'end_month.*'                 => 'لطفا ماه پایان رویداد را انتخاب کنید',
            'end_year.*'                  => 'لطفا سال پایان رویداد را انتخاب کنید',
            
            'images.*'                    => 'لطفا برای رویداد حداقل یک تصویر ضمیمه قرار دهید',
        ];
        $rules = [
            'title'                       => 'required',
            'description'                 => 'required',
            'art-fields'                  => 'required|not_in:[]',

            'start_day'                   => 'required|numeric',
            'start_month'                 => 'required|numeric',
            'start_year'                  => 'required|numeric',
            
            'end_day'                     => 'required|numeric',
            'end_month'                   => 'required|numeric',
            'end_year'                    => 'required|numeric',
            
            'images'                      => 'required',            

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