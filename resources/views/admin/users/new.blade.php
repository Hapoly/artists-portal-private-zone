@extends('layouts.app')

@section('title')
کاربر جدید
@endsection

@section('back')
<li>
    <a href="{{url('admin/users')}}">
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
                <h4 class="title">شاغل جدید</h4>
            </div>
            <div class="card-content">
                <form action="{{url('admin/user-new')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام</label>
                                <input type="text" name="first_name" value="{{isset($oldInputs)? $oldInputs['first_name']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام خانوادگی</label>
                                <input type="text" name="last_name" value="{{isset($oldInputs)? $oldInputs['last_name']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-8 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">آدرس ایمیل</label>
                                <input type="email" name="email" value="{{isset($oldInputs)? $oldInputs['email']: ''}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام کاربری</label>
                                <input type="text" name="name" value="{{isset($oldInputs)? $oldInputs['name']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">کلمه عبور</label>
                                <input type="password" name="password" value="{{isset($oldInputs)? '121212': ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 pull-right">
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control" name="group_code" style="padding-top: 0px">
                                    <option value="0" {{isset($oldInputs)? ($oldInputs['group_code'] == 0? 'selected' : ''): ''}}>عادی</option>
                                    <option value="1" {{isset($oldInputs)? ($oldInputs['group_code'] == 1? 'selected' : ''): ''}}>کارشناس</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6 text-center" style="margin-top: 30px;">
                                <span>نوع کاربری</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">شماره تماس ثابت</label>
                                <input type="text" name="phone" value="{{isset($oldInputs)? $oldInputs['phone']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">تلفن همراه</label>
                                <input type="text" name="cellphone" value="{{isset($oldInputs)? $oldInputs['cellphone']: ''}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">ثبت کاربر</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection