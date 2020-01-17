<!DOCTYPE html>
<html>

<head>
    <title>@lang('user/form.login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link href="{{ asset('assets/css/admin/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>
    <!-- end of global level css -->
    <!-- page level css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin/auth/login.css') }}" />
    <link href="{{ asset('assets/vendors/iCheck/css/square/blue.css') }}" rel="stylesheet"/>
    <!-- end of page level css -->

</head>

<body>
<div class="container">
    <div class="row vertical-offset-100">
        <!-- Notifications -->
        <div id="notific">
            {{--@include('notifications')--}}
        </div>

        <div class="col-sm-6 col-sm-offset-3  col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
            <div id="container_demo">
                <a class="hiddenanchor" id="toregister"></a>
                <a class="hiddenanchor" id="tologin"></a>
                <a class="hiddenanchor" id="toforgot"></a>
                <div id="wrapper">
                    <div id="login" class="animate form">
                        <form action="{{ route('signin') }}" autocomplete="on" method="post" role="form" id="login_form">
                            <h3 class="black_bg">
                                <img src="{{ asset('assets/img/general/logo_img_en.png') }}" alt="josh logo" style="margin-bottom: 10px;">
                            </h3>
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group {{ $errors->first('loginid', 'has-error') }}">
                                <label style="margin-bottom:0px;" for="loginid" class="uname control-label"> <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                    @lang('user/form.loginid')
                                </label>
                                <input id="loginid" name="loginid" type="text" placeholder="@lang('user/form.loginid')"
                                       value="{!! old('loginid') !!}"/>
                                <div class="col-sm-12">
                                    {!! $errors->first('loginid', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                <label style="margin-bottom:0px;" for="password" class="youpasswd"> <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                    @lang('user/form.password')
                                </label>
                                <input id="password" name="password" type="password" placeholder="@lang('user/form.password')" />
                                <div class="col-sm-12">
                                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <p class="login button">
                                <input type="submit" value="@lang('user/form.login')" class="btn btn-success" style="padding: 9px 6px 9px 6px;width: 95%;"/>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- global js -->
<script src="{{ asset('assets/js/admin/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/js/admin/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<!--livicons-->
<script src="{{ asset('assets/js/admin/raphael-min.js') }}"></script>
<script src="{{ asset('assets/js/admin/livicons-1.4.min.js') }}"></script>
<script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/admin/auth/login.js') }}" type="text/javascript"></script>
<!-- end of global js -->
</body>
</html>