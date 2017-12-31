@extends('layouts.app')

@section('title')
{{$admin->first_name . ' ' . $admin->last_name}}
@endsection

@section('content')
<div class="top-buffer row">
    <div class="col s12 m8 offset-m2">
        <div class="card-panel white">
            <div class="col m10 s12">
                <h5 class="input">{{$admin->first_name}} {{$admin->last_name}}</h5>
                <h6>آدرس ایمیل: {{$admin->email}}</h6>
            </div>
            <div class="row">
                <a style="margin: 2" href="{{url('/profile-edit')}}"
                    class="waves-effect waves-light btn" target="_blank">
                    ویرایش</a>
            </div>
        </div>
    </div>
</div>
@endsection