@extends('layouts.app')

@section('title')
{{$message->title}}
@endsection

@section('content')
<div class="top-buffer row">
    <div class="col s12 m8 offset-m2">
        <div class="card-panel white">
            <div class="row">
                <div class="col m12 s12 input">
                    <h4>{{$message->title}}<h4>
                </div>
            </div>
            <div class="row">
                <div class="col m12 s12 input">
                    {{$message->body}}
                </div>
            </div>
            <div class="row">
                <div class="col m12 s12 input left-align">
                    {{$message->sender_name}}
                </div>
            </div>
            <div class="row">
                <a style="margin: 2" href="{{url('admin/message-new/' . $message->sender)}}"
                    class="waves-effect waves-light btn" target="_blank">
                    پاسخ دادن</a>
                <a style="margin: 2"
                    class="waves-effect waves-light btn"
                    >حذف
                </a>
            </div>
        </div>
    </div>
</div>
@endsection