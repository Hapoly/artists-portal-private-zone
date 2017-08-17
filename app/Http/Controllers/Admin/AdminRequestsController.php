<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;

class AdminRequestsController extends Controller
{
    public function list(Request $request, $page=1)
    {
        $size = 10;

        $event_requests = DB::table('event_requests')
            ->limit($size)
            ->offset(($page-1)*$size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
                $event_requests = $event_requests->orderBy($order, 'asc');
        }

        if($request->has('search')){
            $search = $request->input('search');
            $event_requests = $event_requests->whereRaw("artist_name LIKE '%$search%' OR event_title LIKE '%$search%'");
        }
        $event_requests = $event_requests->get();
        $event_requestsCount = DB::table('event_requests')->count();

        $pageCount = ceil($event_requestsCount / $size);

        return view('admin.event_requests.list', [
            'requests'      => $event_requests,
            'page'          => $page,
            'pageSize'      => $size,
            'pageCount'     => ceil($event_requestsCount / $size),
            'sort'          => $request->has('sort')? ('?sort=' . $request->input('sort')) : '',
            ]);
    }

    public function newGet(Request $request, $eventId, $artistId){
        
        $old = DB::table('event_requests')
                ->where([
                        'event_id' => $eventId,
                        'artist_id' => $artistId,
                    ])->first();

        if($old != Null)
            return back()->with(['msg' => 'request_has_been']);

        $eventTitle = DB::table('events')->where('id', $eventId)->first()->title;
        $artist = DB::table('users')->where('id', $artistId)->first();
        $artistName = $artist->first_name . ' ' . $artist->last_name;

        DB::table('event_requests')
            ->insert([
                'event_id'      => $eventId,
                'event_title'   => $eventTitle,
                'artist_id'     => $artistId,
                'artist_name'   => $artistName,
            ]);
        return back()->with(['msg' => 'request_done']);        
    }

    public function accept(Request $request, $id){
        DB::table('event_requests')->where('id', '=', $id)->update(['status' => 2]);
        return back();
    }

    public function refuse(Request $request, $id){
        DB::table('event_requests')->where('id', '=', $id)->update(['status' => 3]);
        return back();
    }
}