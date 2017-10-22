@extends('layouts.print')

@section('title')
هنرمندان
@endsection
@section('content')
  @if (sizeof($artists) > 0)
    @foreach($artists as $artist)
      <div class="panel panel-default rtl">
        <div class="panel-heading">{{$artist->first_name}} {{$artist->last_name}}</div>
        <div class="panel-body">
          <div class="row">
              <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                  نام: {{$artist->first_name}}
              </div>
              <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                  نام خانوادگی: {{$artist->last_name}}
              </div>
              <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                  نام مستعار: {{$artist->nickname}}
              </div>
              <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                  جنسیت: {{$artist->gender == 2? 'مذکر':'مونث'}}
              </div>
          </div>
          <div class="row">
              <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                  شماره تماس ثابت: {{$artist->phone}}
              </div>
              <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                  شماره همراه: {{$artist->cellphone}}
              </div>
              <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                  آدرس: {{$artist->address}}
              </div>
          </div>
        </div>
      </div>
    @endforeach
  @else
  @endif
@endsection