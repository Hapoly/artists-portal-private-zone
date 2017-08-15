@extends('layouts.app')

@section('title')
{{$artist->first_name . ' ' . $artist->last_name}}
@endsection

@section('content')
<div class="top-buffer row">
    <div class="col s12 m8 offset-m2">
        <div class="card-panel white">
            <div class="col m10 s12">
                <h5 class="input">{{$artist->first_name}} {{$artist->last_name}}</h5>
                <h6 class="input"><i>{{$artist->nickname}}</i></h6>
                <h6>آدرس ایمیل: {{$artist->email}}</h6>
                <h6>
                    شماره تماس ثابت: {{$artist->phone}}
                </h6>
                <h6>
                    شماره تماس همراه: {{$artist->cellphone}}
                </h6>
            </div>
            <div class="col m2 s8 offset-s2">
                <img class="responsive-img circle" src="{{url($artist->profile)}}" />
            </div>
            <div class="row">
                <div class="col m8 s12 input">
                    آدرس:
                    {{$artist->address}}
                </div>
                <div class="col m3 s12 input">
                    محل سکونت: 
                    <div class="chip">
                        {{$artist->habitate_place}}
                    </div>
                </div>
                <div class="col m3 s12 input">
                    مدت اقامت: {{$artist->habitate_years}} سال
                </div>
            </div>
            <div class="row">
                <div class="col m6 s12">
                    @foreach($art_fields as $art_field)
                        <div class="chip">
                            {{$art_field->art_field_title}}
                        </div>
                    @endforeach
                </div>
                <div class="col m6 s12">
                    @foreach($educations as $education)
                        <div class="chip">
                            {{$education->education_title}}
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col m6 s12 input">
                    مذهب: 
                    <div class="chip">
                        {{$artist->religion}}
                    </div>
                </div>
                <div class="col m6 s12 input">
                    تولد: {{$artist->birth_year}}/{{$artist->birth_month}}/{{$artist->birth_day}} در {{$artist->birth_place}}
                </div>
            </div>
            <div class="row">
                <span class="left new badge light-green" data-badge-caption="فعال"></span>
            </div>
        </div>
    </div>
</div>
@endsection