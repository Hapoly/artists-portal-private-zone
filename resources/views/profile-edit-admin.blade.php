@extends('layouts.app')
@section('content')
<div class="top-buffer row">
    @if (isset($error_type))
        @if (count($errors) > 0 && $error_type == 'fail')
        <div class="row">
            <div class="col s12 m6 offset-m3 top-buffer">
                <div class="card-panel  red darken-1 white-text">
                    <ul>
                        @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
        @if($error_type == 'done')
        <div class="row">
            <div class="col s12 m6 offset-m3 top-buffer">
                <div class="card-panel green darken-3 white-text">
                    <p>ویرایش با موفقیت انجام شد</p>
                </div>
            </div>
        </div>
        @endif
    @endif
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <div class="card-panel white">
                <div class="row">
                    <form action="{{url('/profile-edit')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col s12">
                            <div class="row"> 
                                <div class="input-field col m6 s12 right">
                                    <input  id="reg_firstname" name="first_name" type="text" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['first_name']:$admin->first_name}}"/>
                                    <label for="reg_firstname">* نام</label>
                                </div>
                                <div class="input-field col m6 s12 right">
                                    <input id="reg_lastname" name="last_name" type="text" class="validate"
                                    value="{{isset($oldInputs)?$oldInputs['last_name']:$admin->last_name}}"/>
                                    <label for="reg_lastname">* نام خانوادگی</label>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="input-field col m6 s12 right">
                                    <input id="reg_password" name="password" type="password" class="validate"
                                    value=""/>
                                    <label for="reg_password">* کلمه عبور</label>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn waves-effect waves-light" type="submit" >ثبت
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection