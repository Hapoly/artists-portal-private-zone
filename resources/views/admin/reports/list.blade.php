@extends('layouts.app')

@section('title')
آمار ها و گزاراشت - {{$currentPage+1}}
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
                <h4 class="title">آمار ها و گزارشات</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                @if (sizeof($reports) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=title'}}">عنوان کارگاه</a>
                            </th>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=type'}}">نوع کارگاه</a>
                            </th>
                            <th class="rtl text-center">اجرا</th>
                            <th class="rtl text-center">حذف</th>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $report->title }}</td>
                                    <td>{{ $types[$report->type] }}</td>
                                    <td><a href="{{ url( 'admin/report/' . $report->id) }}"><i class="material-icons">assignment_ind</i></a></td>
                                    <td><a href="{{ url( 'admin/report-remove/' . $report->id) }}"><i class="material-icons">assignment_ind</i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <span>هیچ فرم گزارش گیری وجود ندارد</span>
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
                        <li class="page-item"><a class="page-link" href="{{url('admin/reports/' . ($page-1) . '/' . $pageSize. $sort)}}">{{$page}}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="{{url('admin/report-new')}}">
            <button type="button" class="btn btn-primary pull-right">ایجاد فرم گزارش گیری جدید</button>
        </a>
    </div>
</div>
@endsection