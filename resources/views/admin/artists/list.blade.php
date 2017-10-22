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
                <form method="get" action="{{url('admin/artists/' . $sort)}}">
                    <div class="input-field">
                        <input value="{{$search}}" placeholder="جستجوی نام و نام خانوادگی" style="text-align: center; line-height: 60px; height: 60px;" name="search" type="search" required>
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
                                    <a href="{{url('admin/artist/show/' . $artist->id)}}" class="waves-effect waves-light btn right" target="_blank">جزئیات</a>
                                    <a href="{{url('admin/artist-remove/' . $artist->id)}}" class="waves-effect waves-light btn-flat right">حذف</a>
                                    @if($artist->status == 1)
                                        <a href="{{url('admin/artist-accept/' . $artist->id)}}" class="waves-effect waves-light btn-flat right">تائید</a>
                                    @elseif($artist->status == 2)
                                        <a href="{{url('admin/artist-ban/' . $artist->id)}}" class="waves-effect waves-light btn-flat right">محروم</a>
                                    @elseif($artist->status == 3)
                                        <a href="{{url('admin/artist-active/' . $artist->id)}}" class="waves-effect waves-light btn-flat right">فعال</a>
                                    @elseif($artist->status == 4)
                                        <a href="{{url('admin/artist-recylce/' . $artist->id)}}" class="waves-effect waves-light btn-flat right">بازگردانی</a>
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
            <div class="row center-align">
                <span>هیچ هنرمند ثبت نشده است</span>
            </div>
            @endif
            <a href="{{url('admin/artist-new/')}}" class="waves-effect waves-light btn right" target="_blank">هنرمند جدید</a>
        </div>
    </div>
    <div class="col s12 m8 offset-m2">
        <div class="card-panel white">
            <h5>جستجوی پیشرفته</h5>
            <div class="row">
                <form class="col s12" method="get" action="{{url('admin/artists/')}}">
                    <div class="row">
                        <div class="input-field col s6 m6">
                            <input name="first_name" id="first_name" type="text" class="validate"
                                value="{{$first_name}}">
                            <label for="first_name">نام</label>
                        </div>
                        <div class="input-field col s6 m6">
                            <input id="last_name" name="last_name" type="text" class="validate"
                                value="{{$last_name}}">
                            <label for="last_name">نام خانوادگی</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <select name="habitate_place">
                                <option value="0" disabled selected>   شهر را انتخاب کنید</option>
                                <option value="1" {{ $habitate_place == "1"? 'selected': ''}}>    رشت</option>
                                <option value="2" {{ $habitate_place == "2"? 'selected': ''}}>    آستانه</option>
                                <option value="3" {{ $habitate_place == "3"? 'selected': ''}}>    انزلی</option>
                                <option value="4" {{ $habitate_place == "4"? 'selected': ''}}>    صومعه سرا</option>
                                <option value="5" {{ $habitate_place == "5"? 'selected': ''}}>    رودسر</option>
                                <option value="6" {{ $habitate_place == "6"? 'selected': ''}}>    لاهیجان</option>
                                <option value="7" {{ $habitate_place == "7"? 'selected': ''}}>    جیرده</option>
                            </select>
                            <label>شهر</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <select name="gender">
                                <option value="1" disabled selected>   همه</option>
                                <option value="2" {{ $gender == "2"? 'selected': ''}}>    مذکر</option>
                                <option value="3" {{ $gender == "3"? 'selected': ''}}>    مونث</option>
                            </select>
                            <label>جنسیت</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <div class="chips chips-autocomplete art-fields-autocomplete chips-initial"></div>
                          <input hidden id="art-fields" name="art-fields" value="{{$art_fields}}"></input>
                        </div>

                    </div>
                    <div class="row">
                        <button class="btn waves-effect waves-light" type="submit" name="action" value="t">جستجو</button>
                        <button class="btn waves-effect waves-light" type="submit" name="print" target="_blank" value="t">چاپ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
  $('.chips').on('chip.add', function(e, chip){
    var tags = $('.art-fields-autocomplete').material_chip('data');
    $('#art-fields').val(JSON.stringify(tags.map(art_field_chip_to_text)));
  });

  $('.chips').on('chip.delete', function(e, chip){
    var tags = $('.art-fields-autocomplete').material_chip('data');
    $('#art-fields').val(JSON.stringify(tags.map(art_field_chip_to_text)));
  });

  $('.chips').on('chip.select', function(e, chip){
    var tags = $('.art-fields-autocomplete').material_chip('data');
    $('#art-fields').val(JSON.stringify(tags.map(art_field_chip_to_text)));
  });
</script>
@endsection