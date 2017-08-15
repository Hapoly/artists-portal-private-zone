<?php

namespace App\Http\Controllers\Regular;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;

class RegularArtistsController extends Controller
{
    public function list(Request $request, $page=1)
    {
        $size = 10;

        $artists = DB::table('users')
            ->join('artists', 'artists.id', '=', 'users.id')
            ->select(['users.first_name', 'users.last_name', 'users.email', 'users.status', 'artists.*'])
            ->where(['users.group_code' => 1, 'users.status' => 2])
            ->limit($size)
            ->offset(($page-1)*$size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
                $artists = $artists->orderBy($order, 'asc');
        }

        if($request->has('search')){
            $search = $request->input('search');
            $artists = $artists->whereRaw("users.first_name LIKE '%$search%' OR users.last_name LIKE '%$search%'");
        }
        $artists = $artists->get();

        $artistsCount = DB::table('users')->where('group_code', '1')->count();

        $pageCount = ceil($artistsCount / $size);

        return view('regular.artists.list', [
            'artists'       => $artists,
            'page'          => $page,
            'pageSize'      => $size,
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
            ->where(['users.group_code' => 1, 'users.status' => 2])
            ->where('users.id', '=', $id)
            ->first();

        $educations = DB::table('educations')->where('artist_id', $id)->get();
        $art_fields = DB::table('art_fields')->where('artist_id', $id)->get();

        $artist->religion = $this->get_religion_code($artist->religion);
        $artist->habitate_place = $this->get_habitate_place_code($artist->habitate_place);

        return view('regular.artists.view', [
            'artist'        => $artist,
            'educations'    => $educations,
            'art_fields'    => $art_fields,
        ]);
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