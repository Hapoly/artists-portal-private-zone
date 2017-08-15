<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#000000">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link type="text/css" rel="stylesheet" href="{{url('css/materialize.min.css')}}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{url('css/style.css')}}"  media="screen,projection"/>
    <link rel="shortcut icon" href="favicon.ico">

    <script type="text/javascript" src="{{url('js/jquery-2.1.1.min.js')}}"></script>
    <script type="text/javascript" src="{{url('js/materialize.min.js')}}"></script>
    <script type="text/javascript" src="{{url('js/functions.js')}}"></script>
    <title>@yield('title') - هنرمندان</title>
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
  <body class="teal lighten-5" style="direction: rtl; background-image: url({{url('img/bg/6.jpg')}});">
    <div class="navbar-fixed">
        <nav class="nav-color">
            <div class="nav-wrapper nav-color">
                <a href="{{url('dashboard')}}" class="brand-logo center">
                    <img src="{{url('img/logo-big-white.png')}}" alt="" class="responsive-img col" style="width : 5rem;"/>
                </a>
                @if(Auth::user()->group_code == 2)
                <div>
                    <ul class="right hide-on-med-and-down title-text">
                        <li><a href="{{url('admin/reports')}}">گزارشات</a></li>
                        <li><a href="{{url('admin/artists')}}">هنرمندان</a></li>
                        <li><a href="{{url('admin/events')}}">رویداد ها</a></li>
                        <li><a href="{{url('admin/messages')}}">پیام ها</a></li>
                        <li>
                            <a href="{{url('admin/profile')}}">
                                {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a style="margin-top: 10px;" href="{{url('logout')}}" class="waves-effect waves-light btn left">خروج</a>
                        </li>
                    </ul>
                    <ul class="right hide-on-large-only" style="padding-right: 0px;">
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="dropdown1">
                                <i class="material-icons right">reorder</i>
                            </a>
                        </li>
                    </ul>
                    <ul id="dropdown1" class="dropdown-content title-text">
                        <li><a href="{{url('admin/reports')}}">گزارشات</a></li>
                        <li><a href="{{url('admin/artists')}}">هنرمندان</a></li>
                        <li><a href="{{url('admin/events')}}">رویداد ها</a></li>
                        <li><a href="{{url('admin/messages')}}">پیام ها</a></li>
                        <li><a href="{{url('admin/profile')}}">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</a></li>
                    </ul>
                </div>
                @elseif(Auth::user()->group_code == 1)
                <div>
                    <ul class="right hide-on-med-and-down title-text">
                        <li><a href="{{url('user/reports')}}">گزارشات</a></li>
                        <li><a href="{{url('user/artists')}}">هنرمندان</a></li>
                        <li><a href="{{url('user/events')}}">رویداد ها</a></li>
                        <li><a href="{{url('user/messages')}}">پیام ها</a></li>
                        <li><a href="{{url('user/profile')}}">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a style="margin-top: 10px;" href="{{url('logout')}}" class="waves-effect waves-light btn left">خروج</a>
                        </li>
                    </ul>
                    <ul class="right hide-on-large-only" style="padding-right: 0px;">
                        <li>
                            <a class="dropdown-button" href="#!" data-activates="dropdown1">
                                <i class="material-icons right">reorder</i>
                            </a>
                        </li>
                    </ul>
                    <ul id="dropdown1" class="dropdown-content title-text">
                        <li><a href="{{url('user/reports')}}">گزارشات</a></li>
                        <li><a href="{{url('user/artists')}}">هنرمندان</a></li>
                        <li><a href="{{url('user/events')}}">رویداد ها</a></li>
                        <li><a href="{{url('user/messages')}}">پیام ها</a></li>
                        <li><a href="{{url('user/profile')}}">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</a></li>
                    </ul>
                </div>
                @endif
            </div>
        </nav>
    </div>
    @yield('content')
  </body>
</html>