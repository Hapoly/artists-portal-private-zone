@extends('layouts.app')

@section('title')
رویداد ها
@endsection


@section('back')
<li>
    <a href="{{url('dashboard')}}">
        <i class="material-icons">keyboard_return</i>
    </a>
</li>
@endsection

@section('content')
<style>
    th, td {
      text-align: right
    }
</style>
<div class="top-buffer row">
    <div class="col s12 m8 offset-m2">
        <nav>
            <div class="nav-wrapper teal">
                <form method="get" action="{{url('admin/events/' . $sort)}}">
                    <div class="input-field">
                        <input placeholder="جتسجوی عنوان رویداد" style="text-align: center; line-height: 60px; height: 60px;" name="search" type="search" required>
                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </div>
        </nav>
    </div>
    <div class="col s12 m8 offset-m2">
        <div class="card-panel white">
            @if (sizeof($events) > 0)
                <table>
                    <thead>
                    <tr>
                        <th>
                            <a href="{{Request::url() . '?sort=title'}}">عنوان رویداد</a>
                        </th>
                        <th>
                            <a href="{{Request::url() . '?sort=start,end'}}">زمان</a>
                        </th>
                        <th>
                            <a href="{{Request::url() . '?sort=status'}}">وضعیت</a>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{$event->title}}</td>
                                <td>{{$event->start}} {{$event->end}}</td>
                                <td>
                                    @if($event->status == 1)
                                        <span class="new badge right amber lighten-1" data-badge-caption="در انتظار برای تایید"></span>
                                    @elseif($event->status == 2)
                                        <span class="new badge right light-green" data-badge-caption="فعال"></span>
                                    @elseif($event->status == 3)
                                        <span class="new badge right grey lighten-1" data-badge-caption="غیرفعال"></span>
                                    @elseif($event->status == 4)
                                        <span class="new badge right deep-orange accent-3" data-badge-caption="حذف شده"></span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('admin/event/show/' . $event->id)}}" class="waves-effect waves-light btn right" target="_blank">جزئیات</a>
                                    <a href="{{url('admin/event-remove/' . $event->id)}}" class="waves-effect waves-light btn-flat right">حذف</a>
                                    @if($event->status == 1)
                                        <a href="{{url('admin/event-accept/' . $event->id)}}" class="waves-effect waves-light btn-flat right">تائید</a>
                                    @elseif($event->status == 2)
                                        <a href="{{url('admin/event-deactive/' . $event->id)}}" class="waves-effect waves-light btn-flat right">غیرفعال</a>
                                    @elseif($event->status == 3)
                                        <a href="{{url('admin/event-active/' . $event->id)}}" class="waves-effect waves-light btn-flat right">فعال</a>
                                    @elseif($event->status == 4)
                                        <a href="{{url('admin/event-recylce/' . $event->id)}}" class="waves-effect waves-light btn-flat right">بازگردانی</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <ul class="pagination center">
                    <li class="{{$page==$pageCount?'disabled':'waves-effect'}}"><a href="{{url('admin/events/' . ($page+1) . $sort)}}"><i class="material-icons">chevron_right</i></a></li>
                    <li class="active"><a href="#!">{{$page.'/'.$pageCount}}</a></li>
                    <li class="{{$page==1?'disabled':'waves-effect'}}"><a href="{{url('admin/events/' . ($page-1) . $sort)}}"><i class="material-icons">chevron_left</i></a></li>
                </ul>

            @else
            <div class="row center-align">
                <span>هیچ رویداد ثبت نشده است</span>
            </div>
            @endif
            <a href="{{url('admin/event-new/')}}" class="waves-effect waves-light btn right" target="_blank">رویداد جدید</a>
        </div>
    </div>
</div>

@endsection