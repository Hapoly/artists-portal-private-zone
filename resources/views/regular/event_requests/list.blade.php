@extends('layouts.app')

@section('title')
درخواست ها
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
                <form method="get" action="{{url('user/requests/' . $sort)}}">
                    <div class="input-field">
                        <input placeholder="جتسجوی عنوان هنرمند یا رویداد" style="text-align: center; line-height: 60px; height: 60px;" name="search" type="search" required>
                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </div>
        </nav>
    </div>
    <div class="col s12 m8 offset-m2">
        <div class="card-panel white">
            @if (sizeof($requests) > 0)
                <table>
                    <thead>
                    <tr>
                        <th>
                            <a href="{{Request::url() . '?sort=request_title'}}">عنوان رویداد</a>
                        </th>
                        <th>
                            <a href="{{Request::url() . '?sort=artist_name'}}">نام هنرمند</a>
                        </th>
                        <th>
                            <a href="{{Request::url() . '?sort=status'}}">وضعیت</a>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                            <tr>
                                <td>{{$request->event_title}}</td>
                                <td>{{$request->artist_name}}</td>
                                <td>
                                    @if($request->status == 1)
                                        <span class="new badge right amber lighten-1" data-badge-caption="در انتظار برای تایید"></span>
                                    @elseif($request->status == 2)
                                        <span class="new badge right light-green" data-badge-caption="تایید شده"></span>
                                    @elseif($request->status == 3)
                                        <span class="new badge right deep-orange accent-3" data-badge-caption="رد شده"></span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('user/request/show/' . $request->id)}}" class="waves-effect waves-light btn right" target="_blank">جزئیات</a>
                                    @if($request->status == 1)
                                        <a href="{{url('user/request-accept/' . $request->id)}}" class="waves-effect waves-light btn-flat right">تائید</a>
                                        <a href="{{url('user/request-refuse/' . $request->id)}}" class="waves-effect waves-light btn-flat right">رد</a>
                                    @elseif($request->status == 2)
                                        <a href="{{url('user/request-refuse/' . $request->id)}}" class="waves-effect waves-light btn-flat right">رد</a>
                                    @elseif($request->status == 3)
                                        <a href="{{url('user/request-accept/' . $request->id)}}" class="waves-effect waves-light btn-flat right">تائید</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <ul class="pagination center">
                    <li class="{{$page==$pageCount?'disabled':'waves-effect'}}"><a href="{{url('user/requests/' . ($page+1) . $sort)}}"><i class="material-icons">chevron_right</i></a></li>
                    <li class="active"><a href="#!">{{$page.'/'.$pageCount}}</a></li>
                    <li class="{{$page==1?'disabled':'waves-effect'}}"><a href="{{url('user/requests/' . ($page-1) . $sort)}}"><i class="material-icons">chevron_left</i></a></li>
                </ul>

            @else
            <div class="row center-align">
                <span>هیچ درخواستی برای رویداد ها ثبت نشده است</span>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection