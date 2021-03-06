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
        <nav>
            <div class="nav-wrapper teal">
                <form method="get" action="{{url('user/artists/' . $sort)}}">
                    <div class="input-field">
                        <input value="{{isset($search)? $search: ''}}" placeholder="جتسجوی نام و نام خانوادگی" style="text-align: center; line-height: 60px; height: 60px;" name="search" type="search" required>
                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </div>
        </nav>
    </div>
    <div class="col s12 m8 offset-m2">
        <div class="card-panel white">
            @if (sizeof($artists) > 0)
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
                                    <a href="{{url('user/artist/show/' . $artist->id)}}" class="waves-effect waves-light btn right" target="_blank">جزئیات</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <ul class="pagination center">
                    <li class="{{$page==$pageCount?'disabled':'waves-effect'}}"><a href="{{url('user/artists/' . ($page+1) . $sort)}}"><i class="material-icons">chevron_right</i></a></li>
                    <li class="active"><a href="#!">{{$page.'/'.$pageCount}}</a></li>
                    <li class="{{$page==1?'disabled':'waves-effect'}}"><a href="{{url('user/artists/' . ($page-1) . $sort)}}"><i class="material-icons">chevron_left</i></a></li>
                </ul>

            @else
            <div class="row center-align">
                <span>هیچ هنرمند ثبت نشده است</span>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection