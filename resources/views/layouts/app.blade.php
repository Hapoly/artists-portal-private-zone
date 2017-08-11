<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>شاغلین:@yield('title')</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet"/>

    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet'
          type='text/css'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Lateef" rel="stylesheet">
    
    <script src="{{ asset('js/jquery-3.1.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.autocomplete.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/chartist.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('js/material-dashboard.js') }}"></script>
    <script src="{{ asset('js/reports.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href='http://awebfont.ir/css?id=1920' rel='stylesheet' type='text/css'>
    <script>
        body {
            font-family: '0 Roya', tahoma, Arial;
        }
    </script>
</head>
<body>
<div class="wrapper">
    <div class="main-panel">
        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">سامانه مدیریت اشتغال سازمان منطقه آزاد انزلی</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        @yield('back')
                        <li>
                            <a href="{{url('profile')}}">
                                <i class="material-icons">person</i>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('logout')}}">
                                <i class="material-icons">lock</i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright">
                    <script>document.write(new Date().getFullYear())</script>
                    <a href="http://www.prechaos.ir">Reza</a>&copy; طراحی توسط
                </p>
            </div>
        </footer>
    </div>
    <div class="sidebar" data-color="purple" data-image="{{ asset('img/sidebar-1.jpg') }}">
        <div class="logo">
            <img src="{{ asset('img/logo-small.png') }}"/>
        </div>

        <div class="sidebar-wrapper">
            <ul class="nav">
                @if(Request::url() == url('dashboard'))
                    <li class="active">
                @else
                    <li>
                @endif
                    <a href="{{url('dashboard')}}">
                        <i class="material-icons">dashboard</i>
                        <p>داشبورد</p>
                    </a>
                </li>
                @if ($group_code)
                    @if(Request::url() == url('admin/users'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('admin/users')}}">
                            <i class="material-icons">people</i>
                            <p>کاربران</p>
                        </a>
                    </li>
                    @if(Request::url() == url('admin/units'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('admin/units')}}">
                            <i class="material-icons">library_books</i>
                            <p>کارگاه ها</p>
                        </a>
                    </li>
                    @if(Request::url() == url('admin/employees'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('admin/employees')}}">
                            <i class="material-icons">people_outline</i>
                            <p>شاغلین</p>
                        </a>
                    </li>
                    @if(Request::url() == url('admin/reports'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('admin/reports')}}">
                            <i class="material-icons">show_chart</i>
                            <p>آمار ها و گزارشات</p>
                        </a>
                    </li>
                    @if(Request::url() == url('admin/backup'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('admin/backup')}}">
                            <i class="material-icons">show_chart</i>
                            <p>پشتیبان گیری</p>
                        </a>
                    </li>
                @else
                    @if(Request::url() == url('units'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('units')}}">
                            <i class="material-icons">library_books</i>
                            <p>کارگاه ها</p>
                        </a>
                    </li>
                    @if(Request::url() == url('employees'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('employees')}}">
                            <i class="material-icons">people_outline</i>
                            <p>شاغلین</p>
                        </a>
                    </li>
                @endif
                
            </ul>
        </div>
    </div>
</div>
</body>
@yield('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
</html>
