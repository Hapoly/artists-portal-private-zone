@extends('layouts.app')

@section('title')
داشبورد
@endsection

@section('content')
<div class="top-buffer row">
    <div class="row">
        <div class="row">
            <div class="col s12 m12">
                <div class="card-panel white">
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs tabs-fixed-width">
                                <li class="tab col s3"><a class="active black-text" href="#inprogress">رویداد های جاری</a></li>
                                <li class="tab col s3"><a href="#futureevents" class="black-text">رویداد های آینده</a></li>
                                <li class="tab col s3"><a href="#request" class="black-text"> درخواست ها</a></li>
                            </ul>
                        </div>
                    <div id="inprogress" class="col s12 top-buffer">
                        <div class="row">
                            <div class="col s12">
                            <EventCard/>
                            </div>
                        </div>
                    </div>
                    <div id="futureevents" class="col s12 top-buffer">
                        <div class="row">
                            <div class="col s12">
                                <table class="bordered">
                                    <thead>
                                        <tr>
                                            <th>عنوان رویداد</th>
                                            <th>دسته بندی</th>
                                            <th>تاریخ</th>
                                            <th>جزییات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>گردهمایی</td>
                                            <td>جلسه هنرمندان</td>
                                            <td><a href="#"><i class="small material-icons">today</i></a></td>
                                            <td><a href="#"><i class="small material-icons">info_outline</i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="request" class="col s12 top-buffer">
                        <div class="row">
                            <div class="col s12">
                            <table class="bordered">
                                <tbody>
                                    <tr>
                                        <td>درخواست شرکت در رویداد استارتاپ ویکند</td>
                                        <td>از طرف رضا</td>
                                        <td ><a href="#"><i class="small material-icons">today</i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12">
                <div class="card-panel white">
                <div class="row">
                <div class="col s12">
                <ul class="tabs tabs-fixed-width">
                <li class="tab col s3"><a class="active black-text" href="#send">ارسال پیام</a></li>
                <li class="tab col s3"><a href="#newmessage" class="black-text">پیام های جدید</a></li>
                </ul>
                </div>

                <div id="send" class="col s12">
                <div class="row">
                <div class="col s12">
                <div class="row"> 
                <div class="input-field col s6 right">
                <input id="last_name" type="text" class="validate"/>
                <label for="last_name">گیرنده</label>
                </div>
                </div>
                <div class="row">
                <div class="input-field col s12">
                <input  id="first_name" type="text" class="validate"/>
                <label for="first_name">عنوان پیام</label>
                </div> 
                </div>
                <div class="row">
                <div class="input-field col s12 ">
                <textarea id="textarea1" class="materialize-textarea "></textarea>
                <label for="textarea1" class="Rt">متن پیام</label>
                </div>
                </div>
                <div class="row">
                <a class="teal lighten-1 btn">ارسال</a>
                </div>
                </div>
                </div>
                </div>
                <div id="newmessage" class="col s12 top-buffer">
                <div class="row">
                <div class="col s12">
                <table class="bordered">
                <thead>
                <tr>
                <th>فرستنده</th>
                <th>عنوان</th>
                <th>حذف</th>
                <th>مشاهده</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td>علی اکبری</td>
                <td>مشکل مالی در غرفه ۱۸</td>
                <td class="text-center"><a href="#"><i class="small material-icons">delete</i></a></td>
                <td class="text-center"><a href="#"><i class="small material-icons">mode_edit</i></a></td>
                </tr>
                <tr>
                <td>ناهید افشار</td>
                <td>سلام</td>
                <td class="text-center"><a href="#"><i class="small material-icons">delete</i></a></td>
                <td class="text-center"><a href="#"><i class="small material-icons">mode_edit</i></a></td>
                </tr>
                <tr>
                <td>مریم وجودی</td>
                <td>ارسال مستندات اضافه</td>
                <td class="text-center"><a href="#"><i class="small material-icons">delete</i></a></td>
                <td class="text-center"><a href="#"><i class="small material-icons">mode_edit</i></a></td>
                </tr>
                </tbody>
                </table>
                </div>
                </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection