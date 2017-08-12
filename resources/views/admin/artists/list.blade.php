@extends('layouts.app')

@section('title')
هنرمندان
@endsection


@section('back')
<li>
    <a href="{{url('dashboard')}}">
        <i class="material-icons">keyboard_return</i>
    </a>
</li>
@endsection

@section('content')
<div class="top-buffer row">
    <div class="col s12 m8 offset-m2">
        <div class="card-panel white">
            @if (sizeof($artists) > 0)
                @foreach ($artists as $artist)
                    <div class="row">
                        <div class="col m12 s12">
                            <div class="card horizontal grey lighten-3" style="padding: 7px">
                                <div class="col m2 s8 offset-s2">
                                    <img class="responsive-img circle" style="width: 100%; height: 80%; margin-top: 10%;" src="{{url($artist->profile)}}" />
                                </div>
                                <div class="col m10 s4">
                                    <h5 style="direction: rtl; margin-right: 20px">
                                        {{$artist->first_name}} {{$artist->last_name}}
                                        <i>({{$artist->nickname}})</i>
                                    </h5>
                                    <div class="card-content" >
                                        <div class="row">
                                            @if($artist->status == 1)
                                                <span class="new badge amber lighten-1" data-badge-caption="در انتظار برای تایید"></span>
                                            @elseif($artist->status == 2)
                                                <span class="new badge light-green" data-badge-caption="فعال"></span>
                                            @elseif($artist->status == 3)
                                                <span class="new badge grey lighten-1" data-badge-caption="محروم از حضور"></span>
                                            @elseif($artist->status == 4)
                                                <span class="new badge deep-orange accent-3" data-badge-caption=></span>
                                            @endif
                                            <a href="{{url('artist/show/' . $artist->id)}}" class="waves-effect waves-light btn left">جزئیات</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <span>هیچ شاغلی ثبت نشده است</span>
            @endif
        </div>
    </div>
</div>

@endsection