@extends('layouts.app')

@section('title')
داشبورد
@endsection

@section('content')
<div class="top-buffer row">
    <div class="row">
        <div class="row">
            <div class="col s12 m12">
                <div class="card-panel white">
                    <h4>دستورالعمل ها</h4>
                    <ul>
                        <a href="{{url('data/1.docx')}}"><li>مدارک مورد نیاز برای صدور مجور</li></a>
                        <a href="{{url('data/2.docx')}}"><li>فرایند برگزاری مجوز</li></a>
                        <a href="{{url('data/3.docx')}}"><li>مجوز اجرای موسیقی در سفره خانه سنتی</li></a>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection