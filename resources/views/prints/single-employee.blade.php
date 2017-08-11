@extends('layouts.print')

@section('title')
{{$info->first_name}} {{$info->last_name}}
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        نام: {{$info->first_name}}
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        نام خانوادگی: {{$info->last_name}}
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        کد ملی: {{$info->id_number}}
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        جنسیت: {{$gender[$info->gender]}}
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        نام پدر: {{$info->father_name}}
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        محل تولد: {{$info->birth_place}}
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        تاریخ تولد: {{preg_replace('/-/', '/', $info->birth_date)}}
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        محل سکونت: {{$habitate[$info->habitate]}}
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        سال های سکونت: {{$info->habitate_years}} سال
    </div>
    <div class="col-md-6 col-lg-6 col-sm-12 pull-right">
        آدرس دقیق: {{$info->address}}
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        مدرک: {{$degree[$info->degree]}}
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        رشته: {{$field[$info->field]}}
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        گارکاه: {{$unitTitle}}
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        عنوان شغلی: {{$job[$info->job]}}
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        سابقه کار: {{$info->experience}} ماه
    </div>
    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
        وضعیت تاهل: {{$marrige[$info->marrige]}} 
    </div>
    <div class="col-md-6 col-lg-6 col-sm-12 pull-right">
        تعداد افراد تحت تکفل: {{$info->dependents}} نفر
    </div>
</div>
@endsection