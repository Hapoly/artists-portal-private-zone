@extends('layouts.app')

@section('title')
{{$event->title}}
@endsection

@section('content')
<div class="top-buffer row">
    <div class="col s12 m8 offset-m2">
        <div class="card-panel white">
            <div class="row">
                <div class="col m12 s12 input">
                    <h4>{{$event->title}}<h4>
                </div>
            </div>
            <div class="row">
                <div class="col m12 s12 input">
                    {{$event->description}}
                </div>
            </div>
            <div class="row">
                <div class="col m6 s12 input">
                    برگزاری در{{$event->place}}
                </div>
                <div class="col m6 s12 input">
                    شماره تماس{{$event->phone}}
                </div>
            </div>
            <div class="row">
                <div class="col m12 s12 input">
                    @foreach($fields as $art_field)
                        <div class="chip">
                            {{$art_field->art_field_title}}
                        </div>
                    @endforeach
                </div>
            </div>
            @if(sizeof($images) > 0)
            <div class="row">
                <div class="slider">
                    <ul class="slides">
                    @foreach($images as $image)
                        <li>
                            <img src="{{url($image->name)}}">
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <div class="row">
                <a style="margin: 2" href="{{url('admin/event/edit/' . $event->id)}}"
                    class="waves-effect waves-light btn" target="_blank">
                    ویرایش</a>
                <a style="margin: 2"
                    class="waves-effect waves-light btn"
                    >حذف
                </a>
                @if($event->status == 1)
                    <a href="{{url('admin/event-accept/' . $event->id)}}" class="waves-effect waves-light btn-flat">تائید</a>
                @elseif($event->status == 2)
                    <a href="{{url('admin/event-deactive/' . $event->id)}}" class="waves-effect waves-light btn-flat">غیرفعال</a>
                @elseif($event->status == 3)
                    <a href="{{url('admin/event-active/' . $event->id)}}" class="waves-effect waves-light btn-flat">فعال</a>
                @elseif($event->status == 4)
                    <a href="{{url('admin/event-recylce/' . $event->id)}}" class="waves-effect waves-light btn-flat">بازگردانی</a>
                @endif
                @if($event->status == 1)
                    <span class="left new badge amber lighten-1" data-badge-caption="در انتظار برای تایید"></span>
                @elseif($event->status == 2)
                    <span class="left new badge light-green" data-badge-caption="فعال"></span>
                @elseif($event->status == 3)
                    <span class="left new badge grey lighten-1" data-badge-caption="محروم از حضور"></span>
                @elseif($event->status == 4)
                    <span class="left new badge deep-orange accent-3" data-badge-caption="حذف شده"></span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection