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
                        @if(isset($employees))
                        <div class="col-md-12 col-sm-12">
                            <table class="table table-hover" style="text-align: right">
                                <thead>
                                    <th class="rtl text-center" style="text-align: right">تعداد</th>
                                    <th class="rtl text-center" style="text-align: right">عنوان</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: right">{{$employees}}</td>
                                        <td style="text-align: right">شاغلین</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">{{$units}}</td>
                                        <td style="text-align: right">کارگاه ها</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">{{$reports}}</td>
                                        <td style="text-align: right">فرم های گزارش گیری</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
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