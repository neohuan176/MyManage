<!DOCTYPE HTML>
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
    {{--<link rel="stylesheet" href="{{ asset('backend/vendor/chartist/css/chartist-custom.css') }}">--}}
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    @yield("css")
    <script src="{{asset('backend/js/jquery.min.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.js')}}"></script>
    <script src="{{asset('backend/js/common/util.js')}}"></script>
    @yield("js-start")
</head>
<body>
<div id="wrapper">
    <!-- NAVBAR -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="brand">
            <a href="{{url('/')}}"><img src="{{asset('backend/image/logo-dark.png')}}" alt="首页" class="img-responsive logo"></a>
        </div>
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-fullwidth" onclick="window.history.back()"><i class="lnr lnr-arrow-left-circle"></i></button>
            </div>
            <div class="navbar-btn navbar-btn-right">
                <a class="btn btn-success update-pro" href="/" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>首页</span></a>
            </div>
            <div id="navbar-menu">
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            <span>菜单</span>
                            <i class="fa fa-home"></i>
                        </a>
                        <ul class="dropdown-menu notifications">
                            <li><a href="{{route('admin')}}" class="{{request()->getPathInfo() == '/admin'?'active':''}}"><i class="fa fa-line-chart"></i> <span>报表统计</span></a></li>
                            <li><a href="{{route('admin.companyManage')}}" class="{{request()->getPathInfo() == '/admin/companyManage'?'active':''}}">公司客户管理</a></li>
                            <li><a href="{{route('admin.personal.personalClientManage')}}" class="{{request()->getPathInfo() == '/admin/personal/personalClientManage'?'active':''}}">个人客户管理</a></li>
                            <li><a href="{{route('admin.orders.companyOrdersManage')}}" class="{{request()->getPathInfo() == '/admin/orders/companyOrdersManage'?'active':''}}">公司订单</a></li>
                            <li><a href="{{route('admin.orders.clientOrdersManage')}}" class="{{request()->getPathInfo() == '/admin/orders/clientOrdersManage'?'active':''}}">个人订单</a></li>
                            <li><a href="{{route('admin.orders.ordinaryOrdersManage')}}" class="{{request()->getPathInfo() == '/admin/orders/ordinaryOrdersManage'?'active':''}}">常规订单</a></li>
                            <li><a href="{{route('admin')}}" class="{{request()->getPathInfo() == '/admin/orders/'?'active':''}}"><i class="fa fa-database"></i> <span>库存管理</span></a></li>
                        </ul>
                    </li>


                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('backend/image/user2.png')}}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('logout')}}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="lnr lnr-exit"></i> <span>退出登录</span></a></li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
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
                    <li><a href="{{route('admin')}}" class="{{request()->getPathInfo() == '/admin'?'active':''}}"><i class="fa fa-line-chart"></i> <span>报表统计</span></a></li>
                    <li>
                        <a href="#subPages" data-toggle="collapse" class="{{(request()->getPathInfo() == '/admin/companyManage' || request()->getPathInfo() == '/admin/personal/personalClientManage')?'active collapsed':''}}"><i class="lnr lnr-user"></i> <span>客户管理</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                        <div id="subPages" class="collapse {{(request()->getPathInfo() == '/admin/companyManage' || request()->getPathInfo() == '/admin/personal/personalClientManage')?'in':''}}">
                            <ul class="nav">
                                <li><a href="{{route('admin.companyManage')}}" class="{{request()->getPathInfo() == '/admin/companyManage'?'active':''}}">公司客户管理</a></li>
                                <li><a href="{{route('admin.personal.personalClientManage')}}" class="{{request()->getPathInfo() == '/admin/personal/personalClientManage'?'active':''}}">个人客户管理</a></li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#subPages1" data-toggle="collapse" class="{{strpos(request()->getPathInfo(),'admin/orders')?'active collapsed':''}}"><i class="lnr lnr-file-empty"></i> <span>订单管理</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                        <div id="subPages1" class="collapse {{strpos(request()->getPathInfo(),'admin/orders')?'in':''}} ">
                            <ul class="nav">
                                <li><a href="{{route('admin.orders.companyOrdersManage')}}" class="{{request()->getPathInfo() == '/admin/orders/companyOrdersManage'?'active':''}}">公司订单</a></li>
                                <li><a href="{{route('admin.orders.clientOrdersManage')}}" class="{{request()->getPathInfo() == '/admin/orders/clientOrdersManage'?'active':''}}">个人订单</a></li>
                                <li><a href="{{route('admin.orders.ordinaryOrdersManage')}}" class="{{request()->getPathInfo() == '/admin/orders/ordinaryOrdersManage'?'active':''}}">常规订单</a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a href="{{route('admin.stock.stockShow')}}" class="{{request()->getPathInfo() == '/admin/stock/stockShow'?'active':''}}"><i class="fa fa-database"></i> <span>库存管理</span></a></li>

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
