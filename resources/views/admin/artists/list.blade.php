@extends('layouts.app')

@section('title')
هنرمندان
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
        <div class="card-panel white">
            @if (sizeof($artists) > 0)
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="center-align input-field col s12 m6">
                                <select>
                                    <option value="" disabled selected>همه</option>
                                    <option value="1">تایید نشده</option>
                                    <option value="2">فعال</option>
                                    <option value="3">محروم از حضور</option>
                                    <option value="3">حذف شده</option>
                                </select>
                                <label>وضعیت</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input id="name" type="text" class="validate">
                                <label for="name">جستجو براساس نام</label>
                            </div>
                        </div>
                    </form>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>
                            <a href="{{Request::url() . '?sort=first_name,last_name'}}">نام و نام خانوادگی</a>
                        </th>
                        <th>
                            <a href="{{Request::url() . '?sort=nickname'}}">نام هنری</a>
                        </th>
                        <th>
                            <a href="{{Request::url() . '?sort=status'}}">وضعیت</a>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($artists as $artist)
                            <tr>
                                <td>{{$artist->first_name}} {{$artist->last_name}}</td>
                                <td>{{$artist->nickname}}</td>
                                <td>
                                    @if($artist->status == 1)
                                        <span class="new badge right amber lighten-1" data-badge-caption="در انتظار برای تایید"></span>
                                    @elseif($artist->status == 2)
                                        <span class="new badge right light-green" data-badge-caption="فعال"></span>
                                    @elseif($artist->status == 3)
                                        <span class="new badge right grey lighten-1" data-badge-caption="محروم از حضور"></span>
                                    @elseif($artist->status == 4)
                                        <span class="new badge right deep-orange accent-3" data-badge-caption="حذف شده"></span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('admin/artist/show/' . $artist->id)}}" class="waves-effect waves-light btn right" target="_blank">جزئیات</a>
                                    <a href="{{url('admin/artist/remove/' . $artist->id)}}" class="waves-effect waves-light btn right">حذف</a>
                                    @if($artist->status == 1)
                                        <a href="{{url('artist/accept/' . $artist->id)}}" class="waves-effect waves-light btn right">تائید</a>
                                    @elseif($artist->status == 2)
                                        <a href="{{url('artist/remove/' . $artist->id)}}" class="waves-effect waves-light btn right">محروم</a>
                                    @elseif($artist->status == 3)
                                        <a href="{{url('artist/remove/' . $artist->id)}}" class="waves-effect waves-light btn right">فعال</a>
                                    @elseif($artist->status == 4)
                                        <a href="{{url('artist/remove/' . $artist->id)}}" class="waves-effect waves-light btn right">بازگردانی</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <ul class="pagination center">
                    <li class="{{$page==$pageCount?'disabled':'waves-effect'}}"><a href="{{url('admin/artists/' . ($page+1) . $sort)}}"><i class="material-icons">chevron_right</i></a></li>
                    <li class="active"><a href="#!">{{$page.'/'.$pageCount}}</a></li>
                    <li class="{{$page==1?'disabled':'waves-effect'}}"><a href="{{url('admin/artists/' . ($page-1) . $sort)}}"><i class="material-icons">chevron_left</i></a></li>
                </ul>
            @else
                <span>هیچ هنرمندی ثبت نشده است</span>
            @endif
        </div>
    </div>
</div>

@endsection