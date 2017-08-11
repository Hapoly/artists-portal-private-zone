@extends('layouts.app')

@section('title')
کارگاه ها - {{$currentPage+1}}
@endsection

@section('back')
<li>
    <a href="{{url('dashboard')}}">
        <i class="material-icons">keyboard_return</i>
    </a>
</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card rtl">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">کارگاه ها</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                @if (sizeof($units) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=title'}}">عنوان کارگاه</a>
                            </th>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=manager_title'}}">مدیریت</a>
                            </th>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=phone'}}">شماره تماس</a>
                            </th>
                            <th class="rtl text-center">مشاهده کارگاه</th>
                            <th class="rtl text-center">حذف</th>
                        </thead>
                            <tbody>
                            @foreach ($units as $unit)
                                <tr>
                                    <td>{{ $unit->title }}</td>
                                    <td>{{ $unit->manager_title }}</td>
                                    <td>{{ $unit->phone }}</td>
                                    <td><a href="{{ url( 'unit/' . $unit->id) }}"><i class="material-icons">assignment_ind</i></a></td>
                                    <td><a href="{{ url( 'unit-remove/' . $unit->id) }}"><i class="material-icons">delete</i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <span>هیچ کارگاهی ثبت نشده است</span>
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
                        <li class="page-item"><a class="page-link" href="{{url('units/' . ($page-1) . '/' . $pageSize. $sort)}}">{{$page}}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="{{url('unit-new')}}">
            <button type="button" class="btn btn-primary pull-right">کارگاه جدید</button>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card rtl">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">ارائه پرینت از لیست کارگاه ها</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                <form action="{{url('unit-list-print/')}}" method="get" target="_blank">
                    <input name="pageSize" type="hidden" value="{{$pageSize}}">
                    <div class="row">
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
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-sm-6 pull-right nrtl">
                            <div class="checkbox" style="margin-top: 4rem;">
                                نمایش اطلاعات کامل کارگاه
                                <label>
                                    <input type="checkbox" name="completeUnit">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 pull-right nrtl">
                            <div class="checkbox" style="margin-top: 4rem;">
                                نمایش لیست شاغلین هر کارگاه
                                <label>
                                    <input type="checkbox" name="showEmployees">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 pull-right nrtl">
                            <div class="checkbox" style="margin-top: 4rem;">
                                نمایش اطلاعات کامل هر شاغل
                                <label>
                                    <input type="checkbox" name="completeEmployee">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-sm-6 pull-right" style="margin-top: 1rem;">
                            <button type="submit" class="btn btn-primary text-center">ارائه گزارش</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection