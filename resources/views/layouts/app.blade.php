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
    <title>@yield('title') - هنرمندان</title>
    <style>
        body {
            font-family: '0 Roya', tahoma, Arial;
        }
    </style>
  </head>
  <body class="teal lighten-5" style="direction: rtl;">
    <div class="navbar-fixed">
        <nav class="nav-color">
            <div class="nav-wrapper nav-color">
                <a href="{{url('dashboard')}}" class="brand-logo center">
                    <img src="img/logo-big-white.png" alt="" class="responsive-img col" style="width : 5rem;"/>
                </a>
                @if($group_code == 2)
                <div>
                    <ul class="right hide-on-med-and-down title-text">
                        <li><a href="reports">گزارشات</a></li>
                        <li><a href="artists">هنرمندان</a></li>
                        <li><a href="events">رویداد ها</a></li>
                        <li><a href="messages">پیام ها</a></li>
                        <li><a href="profile">{{$profile_name}}</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <button onClick={this.logout} class="glyphicon glyphicon-log-in btn cyan darken-4">خروج</button>
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
                        <li><a href="reports">گزارشات</a></li>
                        <li><a href="artists">هنرمندان</a></li>
                        <li><a href="events">رویداد ها</a></li>
                        <li><a href="messages">پیام ها</a></li>
                        <li><a href="profile">{{$profile_name}}</a></li>
                    </ul>
                </div>
                @endif
            </div>
        </nav>
    </div>
    @yield('content')
  </body>
</html>
