@extends('layouts.app')

@section('title')
پیام ها
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
                <form method="get" action="{{url('admin/messages/' . $sort)}}">
                    <div class="input-field">
                        <input placeholder="جتسجوی عنوان پیام" style="text-align: center; line-height: 60px; height: 60px;" name="search" type="search" required>
                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </div>
        </nav>
    </div>
    <div class="col s12 m8 offset-m2">
        <div class="card-panel white">
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
                                    <a href="{{url('admin/message/show/' . $message->id)}}" class="waves-effect waves-light btn right" target="_blank">جزئیات</a>
                                    @if($message->status == 2)
                                        <a href="{{url('admin/message-recylce/' . $message->id)}}" class="waves-effect waves-light btn-flat right">بازگردانی</a>
                                    elseif($message->status == 1)
                                        <a href="{{url('admin/message-remove/' . $message->id)}}" class="waves-effect waves-light btn-flat right">حذف</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <ul class="pagination center">
                    <li class="{{$page==$pageCount?'disabled':'waves-effect'}}"><a href="{{url('admin/messages/' . ($page+1) . $sort)}}"><i class="material-icons">chevron_right</i></a></li>
                    <li class="active"><a href="#!">{{$page.'/'.$pageCount}}</a></li>
                    <li class="{{$page==1?'disabled':'waves-effect'}}"><a href="{{url('admin/messages/' . ($page-1) . $sort)}}"><i class="material-icons">chevron_left</i></a></li>
                </ul>

            @else
            <div class="row center-align">
                <span>هیچ پیامی ثبت نشده است</span>
            </div>
            @endif
            <a href="{{url('admin/message-new/')}}" class="waves-effect waves-light btn right" target="_blank">پیام جدید</a>
        </div>
    </div>
</div>

@endsection