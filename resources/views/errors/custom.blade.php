@extends('layouts.app')

@section('title')
خطای {{$status}}
@endsection

@section('content')
<div class="panel panel-default rtl">
  <div class="panel-body"><h3>خطای {{$status}}</h3></div>
  <div class="panel-footer"><h4>{{$message}}</h4></div>
</div>
@endsection