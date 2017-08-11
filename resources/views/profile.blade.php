@extends('layouts.app')

@section('title')
پروفایل شما
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
                <h4 class="title">{{$user['first_name'] . ' ' . $user['last_name']}} ({{$name}})</h4>
            </div>
            <div class="card-content">
                <form action="{{url('profile')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام</label>
                                <input type="text" name="first_name" value="{{isset($user)? $user['first_name']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام خانوادگی</label>
                                <input type="text" name="last_name" value="{{isset($user)? $user['last_name']: ''}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">کلمه عبور</label>
                                <input type="password" name="password" value="{{isset($user)? 'THIS_IS_A_NOT_PASSWORD': ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">آدرس ایمیل</label>
                                <input type="email" name="email" value="{{isset($user)? $user['email']: ''}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">شماره تماس ثابت</label>
                                <input type="text" name="phone" value="{{isset($user)? $user['phone']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">تلفن همراه</label>
                                <input type="text" name="cellphone" value="{{isset($user)? $user['cellphone']: ''}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">ذخیره مشخصات</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection