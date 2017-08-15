@extends('layouts.app')

@section('title')
داشبورد
@endsection

@section('content')
<style>
    th, td {
      text-align: right
    }
</style>
<div class="top-buffer row">
    <div class="row">
        <div class="row">
            <div class="col s12 m12">
                <div class="card-panel white">
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs tabs-fixed-width">
                                <li class="tab col s3"><a class="active black-text" href="#all-events">تمام رویداد های اخیر</a></li>
                                <li class="tab col s3"><a href="#my-events" class="black-text">رویداد های مربوط به من</a></li>
                            </ul>
                        </div>
                        <div id="all-events" class="col s12 top-buffer">
                            @if (sizeof($allEvents) > 0)
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
                                    @foreach ($allEvents as $event)
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
                                                <a href="{{url('user/event/show/' . $event->id)}}" class="waves-effect waves-light btn right" target="_blank">جزئیات</a>
                                                @if($event->owner == Auth::user()->id)
                                                    <a href="{{url('user/event-remove/' . $event->id)}}" class="waves-effect waves-light btn-flat right">حذف</a>
                                                    @if($event->status == 1)
                                                    @elseif($event->status == 2)
                                                        <a href="{{url('user/event-deactive/' . $event->id)}}" class="waves-effect waves-light btn-flat right">غیرفعال</a>
                                                    @elseif($event->status == 3)
                                                        <a href="{{url('user/event-active/' . $event->id)}}" class="waves-effect waves-light btn-flat right">فعال</a>
                                                    @elseif($event->status == 4)
                                                        <a href="{{url('user/event-recylce/' . $event->id)}}" class="waves-effect waves-light btn-flat right">بازگردانی</a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                        <div class="row center-align">
                            <span>هیچ رویداد ثبت نشده است</span>
                        </div>
                        @endif
                        </div>
                        <div id="my-events" class="col s12 top-buffer">
                          @if (sizeof($myEvents) > 0)
                            <table>
                                <thead>
                                <tr>
                                    <th>عنوان رویداد</th>
                                    <th>زمان</th>
                                    <th>وضعیت</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myEvents as $event)
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
                                                <a href="{{url('user/event/show/' . $event->id)}}" class="waves-effect waves-light btn right" target="_blank">جزئیات</a>
                                                @if($event->owner == Auth::user()->id)
                                                    <a href="{{url('user/event-remove/' . $event->id)}}" class="waves-effect waves-light btn-flat right">حذف</a>
                                                    @if($event->status == 1)
                                                    @elseif($event->status == 2)
                                                        <a href="{{url('user/event-deactive/' . $event->id)}}" class="waves-effect waves-light btn-flat right">غیرفعال</a>
                                                    @elseif($event->status == 3)
                                                        <a href="{{url('user/event-active/' . $event->id)}}" class="waves-effect waves-light btn-flat right">فعال</a>
                                                    @elseif($event->status == 4)
                                                        <a href="{{url('user/event-recylce/' . $event->id)}}" class="waves-effect waves-light btn-flat right">بازگردانی</a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                        <div class="row center-align">
                            <span>هیچ رویداد ثبت نشده است</span>
                        </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12">
                <div class="card-panel white">
                    <div class="row">
                    @if (sizeof($messages) > 0)
                        <table>
                            <thead>
                            <tr>
                                <th>
                                    <a href="{{Request::url() . '?sort=title'}}">عنوان</a>
                                </th>
                                <th>
                                    <a href="{{Request::url() . '?sort=start,end'}}">فرستنده</a>
                                </th>
                                <th>
                                    <a href="{{Request::url() . '?sort=status'}}">گیرنده</a>
                                </th>
                                <th>
                                    <a href="{{Request::url() . '?sort=status'}}">وضعیت</a>
                                </th>
                                <th>
                                    <a href="{{Request::url() . '?sort=status'}}">تاریخ</a>
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($messages as $message)
                                    <tr>
                                        <td>{{$message->title}}</td>
                                        <td>{{$message->sender_name}}</td>
                                        <td>{{$message->reciever_name}}</td>
                                        <td>
                                            @if($message->status == 1)
                                                <span class="new badge right light-green" data-badge-caption="فعال"></span>
                                            @elseif($message->status == 2)
                                                <span class="new badge right deep-orange accent-3" data-badge-caption="حذف شده"></span>   
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('user/message/show/' . $message->id)}}" class="waves-effect waves-light btn right" target="_blank">جزئیات</a>
                                            @if($message->status == 2)
                                                <a href="{{url('user/message-recylce/' . $message->id)}}" class="waves-effect waves-light btn-flat right">بازگردانی</a>
                                            @elseif($message->status == 1)
                                                <a href="{{url('user/message-remove/' . $message->id)}}" class="waves-effect waves-light btn-flat right">حذف</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @else
                    <div class="row center-align">
                        <span>هیچ پیامی ثبت نشده است</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection