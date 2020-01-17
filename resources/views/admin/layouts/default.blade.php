<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            | @lang('general.title')
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="root-path" content="{{ asset('/') }}"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- global css -->

    <link href="{{ asset('assets/css/admin/app.css') }}" rel="stylesheet" type="text/css"/>
    <!-- font Awesome -->

    <!-- end of global css -->
    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->

<body class="skin-josh">
<header class="header">
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <img src="{{ asset('assets/img/general/logo_img_en.png') }}" alt="logo">
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            @if(Sentinel::getUser()->pic)
                                <img src="{!! url('/').'/'.Sentinel::getUser()->pic !!}" alt="img" height="35px" width="35px"
                                     class="img-circle img-responsive pull-left"/>
                            @else
                                <img src="{{ asset('assets/img/admin/authors/no_avatar.jpg') }}" alt="img" height="35px" width="35px"
                                     class="img-circle img-responsive pull-left"/>
                            @endif
                        <div class="riot">
                            <div style="display: flex;">
                                <p class="user_name_max">{{ Sentinel::getUser()->nick_name }}</p>&nbsp
                                <span>
                                    <i class="caret"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            @if(Sentinel::getUser()->pic)
                                <img src="{!! url('/').'/'.Sentinel::getUser()->pic !!}" alt="img" height="35px" width="35px"
                                     class="img-circle img-responsive pull-left"/>

                            @elseif(Sentinel::getUser()->gender === "male")
                                <img src="{{ asset('assets/img/admin/authors/avatar3.png') }}" alt="img" height="35px" width="35px"
                                     class="img-circle img-responsive pull-left"/>

                            @elseif(Sentinel::getUser()->gender === "female")
                                <img src="{{ asset('assets/img/admin/authors/avatar5.png') }}" alt="img" height="35px" width="35px"
                                     class="img-circle img-responsive pull-left"/>
                            @else
                                <img src="{{ asset('assets/img/admin/authors/no_avatar.jpg') }}" alt="img" height="35px" width="35px"
                                     class="img-circle img-responsive pull-left"/>
                            @endif
                            <p class="topprofiletext">{{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}</p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="" style="text-align: center ">
                                <a href="{{ URL::to('admin/logout') }}">
                                    <i class="livicon" data-name="sign-out" data-s="18"></i>
                                    @lang('general.logout')
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper ">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side ">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <div class="clearfix">
                    <br>
                </div>
                <!-- BEGIN SIDEBAR MENU -->
                @include('admin.layouts._left_menu')
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">

        <!-- Notifications -->
        {{--<div id="notific">--}}
            {{--@include('admin/notifications')--}}
        {{--</div>--}}

        <!-- Content -->
        @yield('content')

    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- global js -->
<script src="{{ asset('assets/js/admin/app.js') }}" type="text/javascript"></script>
<!-- end of global js -->
<!-- begin page level js -->
@yield('footer_scripts')
        <!-- end page level js -->
</body>
</html>
