@extends('layouts.app')

@section('title')
فرم گزارش
@endsection


@section('back')
<li>
    <a href="{{url('admin/report-new')}}">
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
                <h4 class="title">فرم گزارش گیری جدید</h4>
            </div>
            <div class="card-content">
                <div class="card">
                    <div class="card-content">
                    <form action="{{url('admin/report-new')}}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 pull-right">
                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                    <label class="control-label">عنوان فرم گزارش</label>
                                    <input type="text" value="" name="title" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 pull-right">
                                <div class="col-md-8">
                                    <div class="form-group rtl col-lg-12 col-md-12">
                                        <div class="form-group" style="margin-top: 0px">
                                            <select class="form-control" name="type" style="padding-top: 0px">
                                                <option value="1" >تعداد</option>
                                                <option value="2" >لیست</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                                    <span>نوع فرم گزارش</span>
                                </div>
                            </div>
                        </div>     
                        <table class="table table-hover text-center rtl">
                            <thead>
                                <th class="rtl text-center">عنوان</th>
                                <th class="rtl text-center">ستون</th>
                                <th class="rtl text-center">فیلد</th>
                            </thead>
                            <tbody>
                            @foreach($columns as $key=>$value)
                                <tr>
                                    <td>{{$value}}</td>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="col_{{$key}}">
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="field_{{$key}}">
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 pull-right">
                                <div class="col-md-8">
                                    <div class="form-group rtl col-lg-12 col-md-12">
                                        <div class="form-group" style="margin-top: 0px">
                                            <select class="form-control" name="chart_type" style="padding-top: 0px">
                                                <option value="1" >میله‌ای</option>
                                                <option value="2" >دایره‌ای</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                                    <span>نوع نمودار</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <button type="submit" class="btn btn-primary pull-left">ثبت فرم گزارش</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection