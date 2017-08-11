@extends('layouts.app')

@section('title')
آمار ها
@endsection

@section('back')
<li>
    <a href="{{url('dashboard')}}">
        <i class="material-icons">keyboard_return</i>
    </a>
</li>
@endsection

@section('content')
<div class="card rtl">
    <div class="card-header" data-background-color="purple">
        <h4 class="title">گزارشات براساس جنسیت</h4>
    </div>
    <div class="card-content">
        <ul dir="rtl">
            <li><a href="{{url('admin/reports/genders')}}">تعداد شاغلین به تفکیک جنسیت</a></li>
            <li><a href="{{url('admin/reports/genders-list')}}">لیست شاغلین به تفکیک جنسیت</a></li>
            <li><a href="{{url('admin/reports/genders-degree')}}">تعداد شاغلین به تفکیک جنسیت و مدرک تحصیلی</a></li>
            <li><a href="{{url('admin/reports/genders-degree-list')}}">لیست شاغلین به تفکیک جنسیت و مدرک تحصیلی</a></li>
            <li><a href="{{url('admin/reports/genders-field')}}">تعداد شاغلین به تفکیک جنسیت و رشته تحصیلی</a></li>
            <li><a href="{{url('admin/reports/genders-field-list')}}">لیست شاغلین به تفکیک جنسیت و رشته تحصیلی</a></li>
            <li><a href="{{url('admin/reports/genders-habitate')}}">تعداد شاغلین به جنسیت و تفکیک محل سکونت</a></li>
            <li><a href="{{url('admin/reports/genders-habitate-list')}}">لیست شاغلین به جنسیت و تفکیک محل سکونت</a></li>
            <li><a href="{{url('admin/reports/genders-job')}}">تعداد شاغلین به تفکیک جنسیت و عنوان شغلی</a></li>
            <li><a href="{{url('admin/reports/genders-job-list')}}">لیست شاغلین به تفکیک جنسیت و عنوان شغلی</a></li>
            <li><a href="{{url('admin/reports/genders-marrige')}}">تعداد شاغلین به تفکیک جنسیت و وضعیت تاهل</a></li>
            <li><a href="{{url('admin/reports/genders-marrige-list')}}">لیست شاغلین به تفکیک جنسیت و وضعیت تاهل</a></li>
            <li><a href="{{url('admin/reports/genders-degree-field')}}">تعداد شاغلین به تفکیک جنسیت، رشته و مدرک تحصیلی</a></li>
            <li><a href="{{url('admin/reports/genders-degree-field-list')}}">لیست شاغلین به تفکیک جنسیت، رشته و مدرک تحصیلی</a></li>
        </ul>
    </div>
</div>

@endsection