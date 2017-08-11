@extends('layouts.app')

@section('title')
بکباپ
@endsection

@section('back')
<li>
    <a href="{{url('admin/dashboard')}}">
        <i class="material-icons">keyboard_return</i>
    </a>
</li>
@endsection

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger rtl">
        <ul>
        @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header rtl" data-background-color="purple">
                <h4 class="title">فرآیند ساخت بکاپ</h4>
            </div>
            <div class="card-content">
                <form action="{{url('admin/backup')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <table class="table table-hover">
                                <thead>
                                <th class="rtl text-center">عنوان</th>
                                <th class="rtl text-center">تعدا</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>شاغلین</td>
                                        <td>{{$employees}}</td>
                                    </tr>
                                    <tr>
                                        <td>کارگاه ها</td>
                                        <td>{{$units}}</td>
                                    </tr>
                                    <tr>
                                        <td>فرم های گزارش گیری</td>
                                        <td>{{$reports}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">اجرای بکاپ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection