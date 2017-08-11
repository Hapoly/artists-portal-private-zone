<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'اشتغال') }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet"/>

    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lateef" rel="stylesheet">
    <link href='http://awebfont.ir/css?id=1920' rel='stylesheet' type='text/css'>
    <script>
        body {
            font-family: '0 Roya', tahoma, Arial;
        }
    </script>
</head>

<body>

<div class="wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4 col-xs-offset-3 col-xs-6">
                    <img src="{{ asset('img/logo-big.png') }}" class="img-responsive"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger rtl">
                            <ul>
                            @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-12" style="text-align: center;">
                    <div class="card card-nav-tabs">
                        <div class="card-header" data-background-color="purple">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="{{$tab == 'login'? 'active' : ''}} pull-right">
                                            <a href="#login" data-toggle="tab">
                                                ورود
                                            <div class="ripple-container"></div></a>
                                        </li>
                                        <li class="{{$tab == 'register'? 'active' : ''}} pull-right">
                                            <a href="#register" data-toggle="tab">
                                                ثبت نام
                                            <div class="ripple-container"></div></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-content">
                            <div class="tab-content">
                                <div class="tab-pane {{$tab == 'register'? 'active' : ''}}" id="register">
                                    <form action="{{url('register')}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-6 pull-right">
                                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                                    <label class="control-label">نام</label>
                                                    <input type="text" value="{{isset($oldInputs)? $oldInputs['first_name']: ''}}" name="first_name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pull-right">
                                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                                    <label class="control-label">نام خانوادگی</label>
                                                    <input type="text" value="{{isset($oldInputs)? $oldInputs['last_name']: ''}}" name="last_name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pull-right">
                                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                                    <label class="control-label">نام کاربری</label>
                                                    <input type="text" value="{{isset($oldInputs)? $oldInputs['name']: ''}}" name="name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pull-right">
                                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                                    <label class="control-label">آدرس ایمیل</label>
                                                    <input type="email" value="{{isset($oldInputs)? $oldInputs['email']: ''}}" name="email" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pull-right">
                                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                                    <label class="control-label">کلمه عبور</label>
                                                    <input type="password" value="{{isset($oldInputs)? $oldInputs['password']: ''}}" name="password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pull-right">
                                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                                    <label class="control-label">تکرار کلمه عبور</label>
                                                    <input type="password" value="{{isset($oldInputs)? $oldInputs['password_conf']: ''}}" name="password_conf" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pull-right">
                                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                                    <label class="control-label">شماره تماس ثابت</label>
                                                    <input type="text" value="{{isset($oldInputs)? $oldInputs['phone']: ''}}" name="phone" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pull-right">
                                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                                    <label class="control-label">شماره تلفن همراه</label>
                                                    <input type="text" value="{{isset($oldInputs)? $oldInputs['cellphone']: ''}}" name="cellphone" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary pull-right">ثبت نام</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane {{$tab == 'login'? 'active' : ''}}" id="login">
                                    <form action="{{url('login')}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-6 pull-right">
                                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                                    <label class="control-label">نام کاربری</label>
                                                    <input type="text" value="{{isset($oldInputs)? $oldInputs['name']: ''}}" name="name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pull-right">
                                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                                    <label class="control-label">کلمه عبور</label>
                                                    <input type="password" value="{{isset($oldInputs)? $oldInputs['password']: ''}}" name="password" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary pull-right">ورود</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="settings">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="optionsCheckboxes">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="optionsCheckboxes" checked>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                                </td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="optionsCheckboxes">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-simple btn-xs">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
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

    <footer class="footer">
        <div class="container-fluid">
            <p class="copyright">
                <script>document.write(new Date().getFullYear())</script>
                <a href="http://www.prechaos.ir">کبان رایانه</a>&copy; طراحی توسط
            </p>
        </div>
    </footer>
</div>

</body>

<script src="{{ asset('js/jquery-3.1.0.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/chartist.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-notify.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script src="{{ asset('js/material-dashboard.js') }}"></script>
<script src="{{ asset('js/demo.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

    });
</script>

</html>
