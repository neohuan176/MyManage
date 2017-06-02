<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '后台管理') }}</title>

    <!-- Styles -->
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/linearicons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/chartist/css/chartist-custom.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    @yield("css")
    <script src="{{asset('backend/js/jquery.min.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.js')}}"></script>
    @yield("js-start")
</head>
<body>
<div id="wrapper">
    <!-- NAVBAR -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="brand">
            <a href="{{url('/')}}"><img src="{{asset('backend/image/logo-dark.png')}}" alt="Klorofil Logo" class="img-responsive logo"></a>
        </div>
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-fullwidth" onclick="window.history.back()"><i class="lnr lnr-arrow-left-circle"></i></button>
            </div>
            {{--<form class="navbar-form navbar-left">--}}
                {{--<div class="input-group">--}}
                    {{--<input type="text" value="" class="form-control" placeholder="Search dashboard...">--}}
                    {{--<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>--}}
                {{--</div>--}}
            {{--</form>--}}
            <div class="navbar-btn navbar-btn-right">
                <a class="btn btn-success update-pro" href="#downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>大钣机械后台管理</span></a>
            </div>
            <div id="navbar-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            <i class="lnr lnr-alarm"></i>
                            <span class="badge bg-danger">5</span>
                        </a>
                        <ul class="dropdown-menu notifications">
                            <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
                            <li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
                            <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
                            <li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
                            <li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
                            <li><a href="#" class="more">查看所有通知</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('backend/image/user2.png')}}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="lnr lnr-user"></i> <span>个人资料</span></a></li>
                            <li><a href="{{route('logout')}}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                ><i class="lnr lnr-exit"></i> <span>退出登录</span></a></li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    <!-- <li>
                        <a class="update-pro" href="#downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->
    <!-- LEFT SIDEBAR -->
    <div id="sidebar-nav" class="sidebar">
        <div class="sidebar-scroll">
            <nav>
                <ul class="nav">
                    <li><a href="{{route('admin')}}" class="{{request()->getPathInfo() == '/admin'?'active':''}}"><i class="lnr lnr-home"></i> <span>首页</span></a></li>
                    <li>
                        <a href="#subPages" data-toggle="collapse" class="{{(request()->getPathInfo() == '/admin/companyManage' || request()->getPathInfo() == '/admin/personal/personalClientManage')?'active collapsed':''}}"><i class="lnr lnr-file-empty"></i> <span>客户管理</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                        <div id="subPages" class="collapse {{(request()->getPathInfo() == '/admin/companyManage' || request()->getPathInfo() == '/admin/personal/personalClientManage')?'in':''}}">
                            <ul class="nav">
                                <li><a href="{{route('admin.companyManage')}}" class="{{request()->getPathInfo() == '/admin/companyManage'?'active':''}}">公司客户管理</a></li>
                                <li><a href="{{route('admin.personal.personalClientManage')}}" class="{{request()->getPathInfo() == '/admin/personal/personalClientManage'?'active':''}}">个人客户管理</a></li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#subPages1" data-toggle="collapse" class="{{request()->getPathInfo() == '/admin/orders/companyOrdersManage'?'active collapsed':''}}"><i class="lnr lnr-file-empty"></i> <span>订单管理</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                        <div id="subPages1" class="collapse ">
                            <ul class="nav" {{(request()->getPathInfo() == '/admin/orders' || request()->getPathInfo() == '/admin/orders/companyOrdersManage')?'in':''}}>
                                <li><a href="{{route('admin.orders.companyOrdersManage')}}" class="{{request()->getPathInfo() == '/admin/orders/companyOrdersManage'?'active':''}}">公司订单</a></li>
                                <li><a href="page-login.html" class="">个人订单</a></li>
                                <li><a href="page-login.html" class="">常规订单</a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a href="{{route('admin')}}" class="{{request()->getPathInfo() == '/admin'?'active':''}}"><i class="lnr lnr-home"></i> <span>库存管理</span></a></li>

                </ul>
            </nav>
        </div>
    </div>
    <!-- END LEFT SIDEBAR -->
    <!-- MAIN -->
    <div class="main">
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="container-fluid">
                @yield("content")
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN -->
    <div class="clearfix"></div>
    <footer>
        <div class="container-fluid">
            <p class="copyright">&copy; 2017 <a href="#" target="_blank">Theme I Need</a>. All Rights Reserved. More Templates <a href="#" target="_blank" title="IT之家">IT之家</a> - Collect from <a href="#" title="Neo" target="_blank">Neo</a></p>
        </div>
    </footer>
</div>
<!-- Scripts -->
@yield("js-end")

{{--<script src="{{asset('backend/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>--}}
{{--<script src="{{asset('backend/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>--}}
{{--<script src="{{asset('backend/vendor/chartist/js/chartist.min.js')}}"></script>--}}
{{--<script src="{{asset('backend/js/klorofil-common.js')}}"></script>--}}
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
</body>
</html>
