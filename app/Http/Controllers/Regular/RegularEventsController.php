<?php

namespace App\Http\Controllers\Regular;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;

class RegularEventsController extends Controller
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

        if($request->has('mine')){
            $events = $events
                        ->join('event_fields', 'event_fields.event_id', '=', 'events.id')
                        ->join('art_fields', 'art_fields.art_field_id', '=', 'event_fields.art_field_id')
                        ->where('art_fields.artist_id', '=', Auth::user()->id)
                        ->groupBy('events.id')
                        ->select(['events.*']);
        }

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
                $events = $events->orderBy($order, 'asc');
        }

        if($request->has('search')){
            $search = $request->input('search');
            $events = $events->whereRaw("events.title LIKE '%$search%'");
        }
        $events = $events->get();
        $eventsCount = DB::table('events')->count();

        $pageCount = ceil($eventsCount / $size);

        return view('regular.events.list', [
            'events'       => $events,
            'page'          => $page,
            'pageSize'      => $size,
            'pageCount'     => ceil($eventsCount / $size),
            'sort'          => $request->has('sort')? ('?sort=' . $request->input('sort')) : '',
            ]);
    }

    public function view(Request $request, $id){
        $event = DB::table('events')
            ->where('events.id', '=', $id)
            ->first();

        $images = DB::table('event_images')->where('event_id', $id)->get();
        $fields = DB::table('event_fields')->where('event_id', $id)->get();

        $event->place = $this->get_habitate_place_code($event->place);
        return view('regular.events.view', [
            'event'        => $event,
            'images'    => $images,
            'fields'    => $fields,
        ]);
    }

    public function editPost(Request $request, $id){
        $validator = $this->myEventEditValidate($request);
        $event = DB::table('events')
            ->where('events.id', '=', $id)
            ->first();

        $images = DB::table('event_images')->where('event_id', $id)->get();
        $fields = DB::table('event_fields')->where('event_id', $id)->get();

        $oldInputs = $request->all();

        $oldInputs['art-fields'] = json_decode($oldInputs['art-fields']);
        if($validator->fails()){
            return view('regular.events.edit', [
                'title'         => $event->title,
                'oldInputs'     => $oldInputs,
                'event'         => $event,
                'images'        => $images,
                'art_fields'    => $fields,
                'id'            => $event->id,
                'error_type'    => 'fail'
            ])->withErrors($validator);
            
        }else{
            DB::table('events')->where(['id' => $id])
                ->update([
                        'title'         => $request->input('title'),
                        'description'   => $request->input('description'),
                        'start'         => $request->input('start_day') . '-' .
                                           $request->input('start_month') . '-' .
                                           $request->input('start_year'),
                        'end'           => $request->input('end_day') . '-' .
                                           $request->input('end_month') . '-' .
                                           $request->input('end_year'),
                        'place'         => $this->get_habitate_place_title($request->input('place')),
                        'phone'         => $request->input('phone'),
                    ]);

            $art_fields = json_decode($request->input('art-fields'));
            DB::table('event_fields')->where(['event_id' => $id])->delete();
            foreach ($art_fields as $art_field) {
                DB::table('event_fields')->insert([
                    'event_id'          => $id,
                    'art_field_id'      => $art_field->id,
                    'art_field_title'   => $art_field->title,
                ]);
            }

            if($request->hasFile('images')){
                DB::table('event_images')->where(['event_id' => $id])->delete();
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

            return view('regular.events.edit', [
                'title'         => $event->title,
                'error_type'    => 'done',
                'oldInputs'     => $oldInputs,
                'event'         => $event,
                'images'        => $images,
                'art_fields'    => $fields,
                'id'            => $event->id,
                ]);
        }
    }

    public function editGet(Request $request, $id){
        $event = DB::table('events')
            ->where('events.id', '=', $id)
            ->first();

        $images = DB::table('event_images')->where('event_id', $id)->get();
        $fields = DB::table('event_fields')->where('event_id', $id)->get();

        $start = explode('-', $event->start);
        $end = explode('-', $event->end);

        $oldInputs = json_decode(json_encode($event), True);

        $oldInputs['start_day'] = $start[0];
        $oldInputs['start_month'] = $start[1];
        $oldInputs['start_year'] = $start[2];

        $oldInputs['end_day'] = $end[0];
        $oldInputs['end_month'] = $end[1];
        $oldInputs['end_year'] = $end[2];

        $oldInputs['place'] = $this->get_habitate_place_code($oldInputs['place']);

        return view('regular.events.edit', [
            'title'         => $event->title,
            'oldInputs'     => $oldInputs,
            'event'         => $event,
            'images'        => $images,
            'art_fields'    => $fields,
            'id'            => $event->id,
        ]);

    }

    public function remove(Request $request, $id){
        DB::table('events')->where('id', '=', $id)->update(['status' => 4]);
        return back();
    }

    public function ban(Request $request, $id){
        DB::table('events')->where('id', '=', $id)->update(['status' => 3]);
        return back();
    }

    public function active(Request $request, $id){
        DB::table('events')->where('id', '=', $id)->update(['status' => 2]);
        return back();
    }

    public function recylce(Request $request, $id){
        DB::table('events')->where('id', '=', $id)->update(['status' => 2]);
        return back();
    }

    public function newGet(Request $request){
        return view('regular.events.new',[
                'art_fields' => [],
            ]);
    }

    public function newPost(Request $request){
        $validator = $this->myNewEventValidate($request);
        if($validator->fails()){
            $oldInputs = $request->all();
            $oldInputs['art-fields'] = json_decode($oldInputs['art-fields']);

            return view('regular.events.new', [
                'oldInputs'                 => $oldInputs,
                'error_type'                => 'fail',
                ])->withErrors($validator);

        }else{
            $id = DB::table('events')->insertGetId([
                    'owner'         => Auth::user()->id,
                    'title'         => $request->input('title'),
                    'description'   => $request->input('description'),
                    'start'         => $request->input('start_day') . '-' .
                                       $request->input('start_month') . '-' .
                                       $request->input('start_year'),
                    'end'           => $request->input('end_day') . '-' .
                                       $request->input('end_month') . '-' .
                                       $request->input('end_year'),
                    'status'        => 1,
                    'place'         => $this->get_habitate_place_title($request->input('place')),
                    'phone'         => $request->input('phone'),
                ]);
            
            $art_fields = json_decode($request->input('art-fields'));
            foreach ($art_fields as $art_field) {
                DB::table('event_fields')->insert([
                    'event_id'          => $id,
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

            return redirect()->intended('user/event/show/' . $id);
        }
    }

    public function myEventEditValidate($request){
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