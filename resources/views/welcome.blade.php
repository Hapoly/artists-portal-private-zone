<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#000000">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
    <link rel="shortcut icon" href="favicon.ico">

    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
    <title>هنرمندان</title>
    <style type="text/css">
        @font-face {
          font-family: 'BRoya';
          src: url('{{url('fonts/BRoya.eot?#')}}') format('eot'),  /* IE6–8 */
               url('{{url('fonts/BRoya.woff')}}') format('woff'),  /* FF3.6+, IE9, Chrome6+, Saf5.1+*/
               url('{{url('fonts/BRoya.ttf')}}') format('truetype');  /* Saf3—5, Chrome4+, FF3.5, Opera 10+ */
        }
        body {
            font-family: BRoya, Arial, Helvetica, sans-serif;

        }
    </style>
  </head>
  <body class="teal lighten-5" style="direction: rtl; background-image: url({{url('img/bg/12.jpg')}});">
    <div class="top-buffer row">
        <div class="row">
            <div class="col s12 m4 offset-m4">
                <img src="img/logo-big.png" 
                    alt="" 
                    class="responsive-img"
                />
            </div>
        </div>
        @if (isset($error_type))
            @if (count($errors) > 0 && $error_type == 'fail')
            <div class="row">
                <div class="col s12 m6 offset-m3 top-buffer">
                    <div class="card-panel  red darken-1 white-text">
                        <ul>
                            @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            @if($error_type == 'done')
            <div class="row">
                <div class="col s12 m6 offset-m3 top-buffer">
                    <div class="card-panel green darken-3 white-text">
                        <p>ثبت نام با موفیقت انجام شد</p>
                        <p>هنرمند محترم. درخواست شما برای ثبت نام در سامانه هنرمندان منطقه آزاد انزلی با موفقیت ارسال شد. کارشناسان مربوطه در اسرع وقت با بررسی اطلاعات ارسال شده توسط شما، با درخواست شما موافقت کرده و شما را از طریق ایمیل آگاه خواهند ساخت</p>
                        <p>با تشکر</p>
                    </div>
                </div>
            </div>
            @endif
        @endif
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card-panel white">
                    <div class="row">
                        <div class="col s12">
                        <ul class="tabs tabs-fixed-width">
                            <li class="tab col s3"><a class="{{$tab=='login'?'active':''}} black-text title-size" href="#login">ورود</a></li>
                            <li class="tab col s3"><a class="{{$tab=='register'?'active':''}} black-text title-size" href="#register">ثبت نام</a></li>
                        </ul>
                        </div>
                        <div id="login" class="col s12 top-buffer">
                            <form action="{{url('login')}}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col s12">
                                    <div class="row">
                                        <div class="input-field col s6 right">
                                            <input  id="login_userName" name="email" type="text" class="validate"/>
                                            <label for="login_userName">آدرس ایمیل</label>
                                        </div> 
                                        <div class="input-field col s6 right">
                                            <input id="login_password" name="password" type="password" class="validate"/>
                                            <label for="login_password">رمز عبور</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <button class="btn waves-effect waves-light" type="submit" >ورود
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div id="register" class="col s12 ">
                            <form action="{{url('register')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col s12">
                                    <div class="row"> 
                                        <div class="input-field col m6 s12 right">
                                            <input  id="reg_firstname" name="first_name" type="text" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['first_name']:''}}"/>
                                            <label for="reg_firstname">* نام</label>
                                        </div>
                                        <div class="input-field col m6 s12 right">
                                            <input id="reg_lastname" name="last_name" type="text" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['last_name']:''}}"/>
                                            <label for="reg_lastname">* نام خانوادگی</label>
                                        </div>
                                    </div>

                                    <div class="row"> 
                                        <div class="input-field col s12 m6">
                                            <input  id="reg_email" name="email" type="email" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['email']:''}}"/>
                                            <label for="reg_email">* آدرس ایمیل</label>
                                        </div> 
                                        <div class="input-field col s6 m6">
                                            <select name="gender" value="2">
                                                <option value="1" disabled selected>   مشخص نشده</option>
                                                <option value="2">    مذکر</option>
                                                <option value="3">    مونث</option>
                                            </select>
                                            <label>جنسیت</label>
                                        </div>
                                    </div>

                                    <div class="row"> 
                                        <div class="input-field col m6 s12 right">
                                            <input  id="reg_password" name="password" type="password" class="validate"/>
                                            <label for="reg_password">* کلمه عبور</label>
                                        </div> 
                                        <div class="input-field col m6 s12 right">
                                            <input id="reg_rep_password" name="password_conf" type="password" class="validate"/>
                                            <label for="reg_rep_password">* تکرار کلمه عبور</label>
                                        </div>
                                    </div>

                                    <div class="row"> 
                                        <div class="input-field col m6 s12 right">
                                            <input  id="reg_fathername" name="father_name" type="text" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['father_name']:''}}"/>
                                            <label for="reg_fathername">* نام پدر</label>
                                        </div>
                                        <div class="input-field col m6 s12 right">
                                            <input id="reg_artname" name="nickname" type="text" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['nickname']:''}}"/>
                                            <label for="reg_artname">* نام هنری</label>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <div class="chips chips-autocomplete art-fields-autocomplete"></div>
                                            <input hidden id="art-fields" name="art-fields" value="[]"></input>
                                        </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input type="text" id="religion" name="religion" class="autocomplete religion-autocomplete"
                                            value="{{isset($oldInputs)?$oldInputs['religion']:''}}"/>
                                            <label for="autocomplete-input">* مذهب</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col m6 s12 right">
                                            <input id="habitate_years" name="habitate_years" type="number" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['habitate_years']:''}}"/>
                                            <label for="habitate_years">* سال های سکونت</label>
                                        </div>
                                        <div class="input-field col m6 s12 right">
                                            <input type="text" id="habitate_place" name="habitate_place" class="autocomplete habitate-autocomplete"
                                            value="{{isset($oldInputs)?$oldInputs['habitate_place']:''}}"/>
                                            <label for="habitate_place">* محل سکونت</label>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="input-field col m6 s12 right">
                                            <input  id="phone" type="text" name="phone" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['phone']:''}}"/>
                                            <label for="phone">* شماره تماس ثابت</label>
                                        </div>
                                        <div class="input-field col m6 s12 right">
                                            <input id="cellphone" type="text" name="cellphone" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['cellphone']:''}}"/>
                                            <label for="cellphone">* شماره همراه</label>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="input-field col m12 s12 right">
                                            <input id="address" type="text" name="address" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['address']:''}}"/>
                                            <label for="address">* آدرس</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="chips chips-autocomplete educations-autocomplete"></div>
                                        <input hidden id="educations" name="educations" value="[]"></input>
                                    </div>
                                    <div class="row"> 
                                        <div class="input-field col m3 s6 right">
                                            <input  id="birth_day" type="number" name="birth_day" min="1" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['birth_day']:''}}"/>
                                            <label for="birth_day">* روز تولد</label>
                                        </div>
                                        <div class="input-field col m3 s6 right">
                                            <input id="birth_month" type="number" name="birth_month" min="1" max="12" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['birth_month']:''}}"/>
                                            <label for="birth_month">* ماه تولد</label>
                                        </div>
                                        <div class="input-field col m3 s6 right">
                                            <input id="birth_year" type="number" name="birth_year" min="1300" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['birth_year']:''}}"/>
                                            <label for="birth_year">* سال تولد</label>
                                        </div>
                                        <div class="input-field col m3 s6 right">
                                            <input id="birth_place" type="text" name="birth_place" class="validate"
                                            value="{{isset($oldInputs)?$oldInputs['birth_place']:''}}"/>
                                            <label for="birth_place">* محل تولد</label>
                                        </div>
                                    </div>
                                    <div class="file-field input-field row">
                                        <div class="btn">
                                            <span>عکس پرسنلی</span>
                                            <input id="profile_pic" name="profile_pic" type="file"/>
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text"/>
                                        </div>
                                    </div>
                                    <div class="file-field input-field row">
                                        <div class="btn">
                                            <span>اسکن کارت ملی</span>
                                            <input id="id_card_pic" name="id_card_pic" type="file"/>
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <button class="btn waves-effect waves-light" type="submit" >ثبت نام
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $('.chips').on('chip.add', function(e, chip){
        var tags = $('.art-fields-autocomplete').material_chip('data');
        $('#art-fields').val(JSON.stringify(tags.map(art_field_chip_to_text)));

        var tags = $('.educations-autocomplete').material_chip('data');
        $('#educations').val(JSON.stringify(tags.map(educations_chip_to_text)));
    });

    $('.chips').on('chip.delete', function(e, chip){
        var tags = $('.art-fields-autocomplete').material_chip('data');
        $('#art-fields').val(JSON.stringify(tags.map(art_field_chip_to_text)));

        var tags = $('.educations-autocomplete').material_chip('data');
        $('#educations').val(JSON.stringify(tags.map(educations_chip_to_text)));
    });

    $('.chips').on('chip.select', function(e, chip){
        var tags = $('.art-fields-autocomplete').material_chip('data');
        $('#art-fields').val(JSON.stringify(tags.map(art_field_chip_to_text)));

        var tags = $('.educations-autocomplete').material_chip('data');
        $('#educations').val(JSON.stringify(tags.map(educations_chip_to_text)));
    });
    </script>
  </body>
  <footer class="page-footer nav-color">
      <div class="container" style="">
          <div class="row">
              <h6>
                  آدرس: منطقه آزاد انزلی - فاز تجاری و گردشگری - ساختمان اداری - طبقه اول - دفتر مدیریت فرهنگی هنری و آموزش
              </h6>
              <h6>
                  ۰۱۳-۳۴۴۳۸۱۸۹
              </h6>
          </div>
      </div>
      <div class="footer-copyright">
      <div class="container">
          تمام حقوق معنوی و مادی سامانه توسط شرکت <a class="grey-text text-lighten-4 right" href="http://takbanco.ir">تکبان رایانه کاسپین</a> محفوظ است
      </div>
      </div>
  </footer>
</html>
