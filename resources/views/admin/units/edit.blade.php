@extends('layouts.app')

@section('title')
{{$oldInputs['title']}}
@endsection

@section('back')
<li>
    <a href="{{url('admin/units')}}">
        <i class="material-icons">keyboard_return</i>
    </a>
</li>
@endsection

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger rtl">
        <ul>
        @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header rtl" data-background-color="purple">
                <h4 class="title">{{$oldInputs['title']}}</h4>
                <a href="{{url('admin/unit-single-print/' . $oldInputs['id'])}}" data-toggle="tooltip" title="پرینت واحد" target="_blank">
                    <i class="material-icons">print</i>
                </a>
                <a href="{{url('admin/unit-single-print/' . $oldInputs['id'] . '?showEmployees=true')}}" data-toggle="tooltip" target="_blank" title="پرینت واحد و لیست شاغلین">
                    <i class="material-icons">print</i>
                </a>
                <a href="{{url('admin/unit-single-print/' . $oldInputs['id'] . '?showEmployees=true&complete=true')}}" target="_blank" data-toggle="tooltip" title="پرینت واحد و اطلاعات شاغلین">
                    <i class="material-icons">print</i>
                </a>
            </div>
            <div class="card-content">
                <form action="{{url('admin/unit/' . $oldInputs['id'])}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام واحد</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['title']: ''}}" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نوع فعالیت(محصول)</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['product']: ''}}" name="product" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام مدیر</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['manager_title']: ''}}" name="manager_title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12 pull-right">
                            <div class="col-md-8">
                                <div class="form-group rtl col-lg-12 col-md-12">
                                    <div class="form-group" style="margin-top: 0px">
                                        <select class="form-control" name="manager_gender" style="padding-top: 0px">
                                            @foreach ($genders->all() as $gender)
                                                    <option value="{{$gender->id}}" {{isset($oldInputs)?($gender->id==$oldInputs['manager_gender']?'selected':''):''}}>{{$gender->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                                <span>جنسیت</span>
                            </div>
                        </div>
                        <div class="col-md-4 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">کد ملی</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['manager_id_number']: ''}}" name="manager_id_number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 pull-right">
                            <div class="col-md-8 col-sm-8">
                                <div class="form-group rtl col-lg-12 col-md-12">
                                    <div class="form-group" style="margin-top: 0px">
                                        <select class="form-control" name="city" style="padding-top: 0px">
                                            @foreach ($cities->all() as $city)
                                                <option value="{{$city->id}}" {{isset($oldInputs)?($city->id==$oldInputs['city']?'selected':''):''}}>{{$city->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                                <span>شهر کارگاه</span>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-5 col-sm-12 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نشانی دقیق</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['address']: ''}}" name="address" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-12 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">کد پستی</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['zip_code']: ''}}" name="zip_code" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">تلفن تماس ثابت</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['phone']: ''}}" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">تلفن همراه</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['cell_phone']: ''}}" name="cell_phone" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox pull-right">
                                مجوز فعالیت دارد
                                <label>
                                    <input type="checkbox" name="has_certificate" {{isset($oldInputs['has_certificate']) && $oldInputs['has_certificate'] == 1 ?'checked': ''}}>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">شماره مجوز</label>
                                <input type="text" value="{{isset($oldInputs['certificate_id']) && $oldInputs['certificate_id'] != '###' ? $oldInputs['certificate_id']: ''}}" name="certificate_id" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pull-right">
                            <div class="col-md-3">
                                <select class="form-control" name="certificate_date_day" style="padding-top: 0px">
                                    @for ($i=1; $i<=30; $i++)
                                        <option value="{{$i}}" {{isset($oldInputs['certificate_date_day'])? ($i == $oldInputs['certificate_date_day'] ? 'selected': '' ): ''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="certificate_date_month" style="padding-top: 0px">
                                    @foreach($months as $key => $val)
                                        <option value="{{$key}}" {{isset($oldInputs['certificate_date_month'])? ($key == $oldInputs['certificate_date_month'] ? 'selected': '' ): ''}} >{{$val}}</option>    
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="certificate_date_year" style="padding-top: 0px">
                                    @for ($i=1390; $i<1400; $i++)
                                        <option value="{{$i}}" {{isset($oldInputs['certificate_date_year'])? ($i == $oldInputs['certificate_date_year'] ? 'selected': '' ): ''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3" style="margin-top: 30px;">
                                <span>تاریخ صدور</span>
                            </div>
                        </div>
                        <div class="col-md-4 pull-right">
                            <div class="form-group rtl col-lg-12 col-md-12">
                                <div class="form-group" style="margin-top: 0px">
                                    <select class="form-control" name="certificate_type" style="padding-top: 0px">
                                        @foreach ($certificateTypes->all() as $certificateType)
                                                <option value="{{$certificateType->id}}" {{isset($oldInputs)?($certificateType->id==$oldInputs['certificate_type']?'selected':''):''}}>{{$certificateType->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox pull-right">
                                پروانه کسب دارد
                                <label>
                                    <input type="checkbox" name="has_licence" {{isset($oldInputs['has_licence']) && $oldInputs['has_licence'] == 1 ? 'checked': ''}}>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">شماره پروانه</label>
                                <input type="text" value="{{isset($oldInputs['licence_id'])? ($oldInputs['licence_id'] != '###'? $oldInputs['licence_id']: '') : ''}}" name="licence_id" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pull-right">
                            <div class="col-md-3">
                                <select class="form-control" name="licence_date_day" style="padding-top: 0px">
                                    @for ($i=1; $i<=30; $i++)
                                        <option value="{{$i}}" {{isset($oldInputs['licence_date_day'])? ($i == $oldInputs['licence_date_day'] ? 'selected': '' ): ''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="licence_date_month" style="padding-top: 0px">
                                    @foreach($months as $key => $val)
                                        <option value="{{$key}}" {{isset($oldInputs['licence_date_month'])? ($key == $oldInputs['licence_date_month'] ? 'selected': '' ): ''}} >{{$val}}</option>    
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="licence_date_year" style="padding-top: 0px">
                                    @for ($i=1390; $i<1400; $i++)
                                        <option value="{{$i}}" {{isset($oldInputs['licence_date_year'])? ($i == $oldInputs['licence_date_year'] ? 'selected': '' ): ''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3" style="margin-top: 30px;">
                                <span>تاریخ مجوز</span>
                            </div>
                        </div>
                        
                        <div class="col-md-4 pull-right">
                            <div class="form-group rtl col-lg-12 col-md-12">
                                <div class="form-group" style="margin-top: 0px">
                                    <select class="form-control" name="licence_source" style="padding-top: 0px">
                                        @foreach ($business_license_sources->all() as $business_license_source)
                                                <option value="{{$business_license_source->id}}" {{isset($oldInputs)?($business_license_source->id==$oldInputs['certificate_type']?'selected':''):''}}>{{$business_license_source->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">ثبت تغییرات</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
                            <th class="rtl text-center">نام و نام خانوادگی</th>
                            <th class="rtl text-center">محل سکونت</th>
                            <th class="rtl text-center">مدرک و رشته تحصیلی</th>
                            <th class="rtl text-center">کارگاه</th>
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
                                    <td><a href="{{ url( 'admin/employee/' . $employee->id) }}"><i class="material-icons">assignment_ind</i></a></td>
                                    <td><a href="{{ url( 'admin/employee-remove/' . $employee->id) }}"><i class="material-icons">delete</i></a></td>
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
    <div class="col-md-12">
        <a href="{{url('admin/employee-new/' . $oldInputs['id'])}}">
            <button type="button" class="btn btn-primary pull-right">شاغل جدید</button>
        </a>
    </div>
</div>

@endsection