@extends('layouts.app')

@section('title')
شاغلین
@endsection

@section('back')
<li>
    <a href="{{url('employees')}}">
        <i class="material-icons">keyboard_return</i>
    </a>
</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card rtl">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">شاغلین</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                @if (sizeof($employees) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=first_name,last_name'}}">نام و نام خانوادگی</a>
                            </th>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=habitate'}}">محل سکونت</a>
                            </th>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=degree,field'}}">مدرک و رشته تحصیلی</a>
                            </th>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=unit_id'}}">کارگاه</a>
                            </th>
                            <th class="rtl text-center">مشاهده اطلاعات شاغل</th>
                            <th class="rtl text-center">حذف</th>
                        </thead>
                            <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{$employee->first_name . ' ' . $employee->last_name}}</td>
                                    <td>{{$employee->habitate}}</td>
                                    <td>{{$employee->field . ' - ' . $employee->degree}}</td>
                                    <td>{{$employee->unit}}</td>
                                    <td><a href="{{ url( 'employee/' . $employee->id) }}"><i class="material-icons">assignment_ind</i></a></td>
                                    <td><a href="{{ url( 'employee-remove/' . $employee->id) }}"><i class="material-icons">delete</i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <span>هیچ شاغلی ثبت نشده است</span>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="text-align: center;">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @foreach ($pagination as $page)
                    @if ($page == '#')
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{url('employees/' . ($page-1) . '/' . $pageSize. $sort)}}">{{$page}}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="{{url('employee-new')}}">
            <button type="button" class="btn btn-primary pull-right">شاغل جدید</button>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card rtl">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">ارائه پرینت از لیست شاغلین</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                <form action="{{url('employee-list-print/')}}" method="get" target="_blank">
                    <input name="pageSize" type="hidden" value="{{$pageSize}}">
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        <div class="col-md-4 col-sm-12">
                            <select class="form-control" name="startPage" style="padding-top: 0px">
                                @for ($i=0; $i<$pageCount; $i++)
                                    <option value="{{$i}}">{{$i+1}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-8 col-sm-12 text-center" style="margin-top: 30px;">
                            <span>از صفحه</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        <div class="col-md-4 col-sm-12">
                            <select class="form-control" name="endPage" style="padding-top: 0px">
                                @for ($i=0; $i<$pageCount; $i++)
                                    <option value="{{$i}}">{{$i+1}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-8 col-sm-12 text-center" style="margin-top: 30px;">
                            <span>تا صفحه</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right nrtl">
                        <div class="checkbox" style="margin-top: 4rem;">
                            نمایش اطلاعات کامل
                            <label>
                                <input type="checkbox" name="complete">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right" style="margin-top: 1rem;">
                        <button type="submit" class="btn btn-primary text-center">ارائه گزارش</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection