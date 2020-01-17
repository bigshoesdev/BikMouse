<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>
        @section('title')
        @show
    </title>
    <meta name="csrf-token" content="{!! csrf_token() !!}"/>
    <meta name="root-path" content="{{ asset('/') }}"/>
    <link rel="shortcut icon" href="{{ asset('assets/img/general/logo_icon.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/emojionearea/dist/emojionearea.min.css') }}"
          media="screen">
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/css/toastr.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/emojionearea/dist/emojionearea.min.css') }}"
          media="screen">
    <link rel="stylesheet" href="{{asset('assets/css/bigo/public.css')}}">
    @yield('header_styles')
</head>

<body
        data-homeurl="{{route('home')}}"
        data-countrylisturl="{{route('api.countrylist')}}"
        data-classifylisturl="{{route('api.classifylist')}}"
        data-gamelisturl="{{route('api.gamelist')}}"
        data-livelisturl="{{route('api.livelist')}}"
        data-advurl="{{route('api.advertise')}}"
        data-viewuserlisturl="{{route('api.viewuserlist')}}"
        data-beanuserlisturl="{{route('api.beanuserlist')}}"
        data-advurl="{{route('api.advertise')}}"
        data-recommendlisturl="{{route('api.recommendlist')}}"
        data-socialredirecturl="{{route('auth.social.redirect')}}"
        data-sendcodeurl="{{route('auth.sendcode')}}"
        data-signupurl="{{route('auth.register')}}"
        data-broadcastviewurl="{{route('broadcast.view')}}"
        data-signinurl="{{route('auth.login')}}"
        data-resetpasswordurl="{{route('auth.reset.password')}}"
        data-homeurl="{{route('home')}}">
<div class="bigo_page_head" id="bigo_page_head_e">
    <div class="head_left f_left">
        <h1 class="bigo_logo"><a href="/"><img src="{{ asset('assets/img/general/logo_img_en.png') }}"></a></h1>
        <ul class="bigo_nav">
            <li class="@if(Request::url() == route('home')){{'current'}}@endif">
                <a class="" href="/">@lang('general/message.home')</a>
            </li>
            <li class="@if(Request::url() == route('game') || Request::url() == route('classify') ||Request::is('game/classify/*')) {{'current'}}@endif">
                <a href="{{route('game')}}">@lang('general/message.gaming')</a>
            </li>
            <li class="@if(Request::url() == route('showbiz')){{'current'}}@endif">
                <a href="{{route('showbiz')}}">@lang('general/message.showbiz')</a>
            </li>
        </ul>
    </div>
    <div class="head_right f_right">
        <ul class="head_right_tools">
            @if(Sentinel::check())
                <li>
                    <a class="tools tools_1" href="{{route('broadcast')}}">@lang('general/message.broadcast')</a>
                </li>
            @endif
            <li>
                <a class="tools tools_2" href="javascript:;">@lang('general/message.app')</a>
                <div class="load_box">
                    <div class="head_load_box">
                        <p class="arrow"></p>
                        <div class="load_btn_box">
                            <p class="down_list">
                                <a class="item item1"
                                   href="https://itunes.apple.com/app/id1077137248">@lang('general/message.app_store')</a>
                            </p>
                            <p class="down_list">
                                <a class="item item2"
                                   href="http://down.bigo.tv/android/bigolive-bigotv.apk">@lang('general/message.android_apk')</a>
                            </p>
                            <p class="down_list">
                                <a class="item item3"
                                   href="https://play.google.com/store/apps/details?id=sg.bigo.live">@lang('general/message.google_play')</a>
                            </p>
                        </div>
                        <img class="download_code" src="{{asset('assets/img/bigo/code_download.png')}}">
                    </div>
                </div>
            </li>
            <li>
                <a class="tools tools_3" href="{{route('setting.recharge')}}">@lang('general/message.recharge')</a>
            </li>
        </ul>
        <div class="login_wrap">
            @if(!Sentinel::check())
                <div class="login_tap_box current">
                    <a class="login_btn" id="login_btn_e" href="javascript:;">@lang('general/message.login')</a>
                </div>
            @endif
            @if(Sentinel::check())
                <div class="logined_box current" id="logined_box_e">
                    <a class="thumb" href="javascript:;"><img src="{{ asset('/'). Sentinel::getUser()->avatar()}}"></a>
                    <div class="logined_more_box">
                        <a class="name" href="javascript:;">{{Sentinel::getUser()->nick_name}}</a>
                    </div>
                    <div class="logined_user_more" style="display:none;">
                        <div class="log_inner_box">
                            <i class="arrow_dot"></i>
                            <a href="{{route('auth.logout')}}" class="logout">@lang('general/message.log_out')</a>
                        </div>
                    </div>
                    <div class="user_profile_fixed">
                        <p class="arrow"></p>
                        <div class="thumb_wrap thumb_wrap_grade">
                            <div class="thumb_box">
                                <img class="thumb_icon" src="{{ asset('/'). Sentinel::getUser()->avatar()}}">
                            </div>
                            <div class="user_grade">
                                <i class="user_grade_num">{{Sentinel::getUser()->level}}</i>
                            </div>
                        </div>
                        <div class="user_infor">
                            <p class="nick_name">{{Sentinel::getUser()->nick_name}}</p>
                            <p class="bigoid">@lang('general/message.broadcast_id')
                                :<i>{{Sentinel::getUser()->broadcast()->bid}}</i>
                            </p>
                        </div>
                        <div class="balance_recharge">
                            <div class="balance_left">@lang('general/message.balance'):
                                <i class="diamond_num">{{Sentinel::getUser()->diamond()->amount}}</i>
                            </div>
                            <a class="recharge_btn commonbtn"
                               href="{{route('setting.recharge')}}">@lang('general/message.recharge')</a>
                        </div>
                        <ul class="bottom_tools">
                            <li class="btn_line">
                                <a class="user_profile_btn"
                                   href="{{ route('setting.index') }}">@lang('general/message.user_profile')</a>
                            </li>
                            <li class="log_out_btn">
                                <a class="logout_btn logout"
                                   href="{{route('auth.logout')}}">@lang('general/message.log_out')</a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="login_scan_wrap" id="login_scan_wrap_e">
    <div class="login_signup_step_w">
        <p class="close_btn"></p>
        <div class="login_phone_box login_signup_step_box current">
            <h6 class="login_title" style=" margin-top: 50px;">@lang('general/message.join_us')</h6>
            <div class="login_signup_form">
                <ul class="login_sign_ul">
                    <li class="current"><a href="javascript:;">@lang('general/message.log_in')</a></li>
                    <li><a href="javascript:;" stepData=".signup_phone_box"
                           class="switch_step_e">@lang('general/message.sign_up')</a></li>
                </ul>
                <form class="login_sign_form">
                    <div class="form_put_title">@lang('general/message.country_region')</div>
                    <div class="country_select_box country_select_box_e">
                        <p class="current_selected">@{{yourCountryName}}</p>
                        <div class="country_list_box">
                            <ul class="country_list">
                                <li v-for="countryData in numberCodeList" v-bind:countryCode="countryData.country_code">
                                    <span class="country_name" v-text="countryData.country_name"></span>
                                    <span class="country_number" v-text="'+'+countryData.phone_code"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="phone_number_view">
                        <div class="form_put_title">
                            <i>@lang('general/message.phone_number')</i>
                            <a class="forgot_password show_email_view"
                               href="javascript:;">@lang('general/message.email')</a>
                        </div>
                        <div class="phone_number_tab">
                            <div class="phone_number_box">
                                <p class="phone_number_prev">+@{{yourPhonePrevCode}}</p>
                                <input class="input_trim_e" type="text" id="login_phone_num"
                                       v-model="yourPhoneNumber">
                            </div>
                        </div>
                    </div>
                    <div class="email_view" style="display:none;">
                        <div class="form_put_title">
                            <i>@lang('general/message.email')</i>
                            <a class="forgot_password show_phone_number_view"
                               href="javascript:;">@lang('general/message.phone_number')</a>
                        </div>
                        <div class="phone_number_tab">
                            <div class="phone_number_box">
                                <input class="input_trim_e" type="email" v-model="yourEmail">
                            </div>
                        </div>
                    </div>
                    <div class="form_put_title">
                        <i>@lang('general/message.password')</i>
                        <a href="javascript:;" stepdata=".reset_phone_box"
                           class="forgot_password switch_step_e">@lang('general/message.forgot_password')</a>
                    </div>
                    <div class="password_tab">
                        <input class="input_trim_e" id="login_password_put" type="password">
                    </div>
                    @include('partial.sns_signin')
                    <a id="login_submit_e" class="submit_btn allowclick"
                       type="submit">@lang('general/message.log_in')</a>
                </form>
            </div>
        </div>
        <div class="signup_phone_box login_signup_step_box">
            <h6 class="login_title" style=" margin-top: 50px;">@lang('general/message.join_us')</h6>
            <div class="login_signup_form">
                <ul class="login_sign_ul">
                    <li><a href="javascript:;" stepData=".login_phone_box"
                           class="switch_step_e">@lang('general/message.log_in')</a></li>
                    <li class="current"><a href="javascript:;">@lang('general/message.sign_up')</a></li>
                </ul>
                <form class="login_sign_form">
                    <div class="form_put_title">@lang('general/message.country_region')</div>
                    <div class="country_select_box country_select_box_e">
                        <p class="current_selected">@{{yourCountryName}}</p>
                        <div class="country_list_box">
                            <ul class="country_list">
                                <li v-for="countryData in numberCodeList" v-bind:countryCode="countryData.country_code">
                                    <span class="country_name" v-text="countryData.country_name"></span>
                                    <span class="country_number" v-text="'+'+countryData.phone_code"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="phone_number_view">
                        <div class="form_put_title">
                            <i>@lang('general/message.phone_number')</i>
                            <a class="forgot_password show_email_view"
                               href="javascript:;">@lang('general/message.email')</a>
                        </div>
                        <div class="phone_number_tab">
                            <div class="phone_number_box phone_code_box">
                                <p class="phone_number_prev">+@{{yourPhonePrevCode}}</p>
                                <input class="input_trim_e" type="text" id="signup_phone_num"
                                       v-model="yourPhoneNumber">
                            </div>
                            <a class="phone_code_button signup_send_code_e">@lang('general/message.send')</a>
                        </div>
                        <div class="form_put_title">
                            <i>@lang('general/message.verification_code')</i>
                        </div>
                        <div class="password_tab">
                            <input class="input_trim_e" type="text" id="signup_phone_code">
                        </div>
                    </div>
                    <div class="email_view" style="display:none;">
                        <div class="form_put_title">
                            <i>@lang('general/message.email')</i>
                            <a class="forgot_password show_phone_number_view"
                               href="javascript:;">@lang('general/message.phone_number')</a>
                        </div>
                        <div class="phone_number_tab">
                            <div class="phone_number_box phone_code_box">
                                <input class="input_trim_e" id="signup_email" type="email" v-model="yourEmail">
                            </div>
                            <a class="phone_code_button signup_send_code_e">@lang('general/message.send')</a>
                        </div>
                        <div class="form_put_title">
                            <i>@lang('general/message.verification_code')</i>
                        </div>
                        <div class="password_tab">
                            <input class="input_trim_e" type="text" id="signup_email_code">
                        </div>
                    </div>
                    @include('partial.sns_signin')
                    <a id="signup_submit_e" class="submit_btn allowclick"
                       type="submit">@lang('general/message.sign_up1_2')</a>
                </form>
            </div>
        </div>
        <div class="create_phone_box login_signup_step_box">
            <a href="javascript:;" stepData=".signup_phone_box"
               class="back_btn switch_step_e">@lang('general/message.back')</a>
            <h6 class="login_title">@lang('general/message.create_password')</h6>
            <div class="create_password_bg" id="seeable_bg_e"></div>
            <div class="login_signup_form">
                <form class="login_sign_form">
                    <div class="password_tab seeable_password">
                        <input class="input_trim_e" id="create_password" type="password" placeholder="">
                        <a class="seeable_password_btn nosee" id="seeable_password_btn_e"
                           href="javascript:;">@lang('general/message.see')</a>
                    </div>
                    <div class="form_put_title create_password_rules">
                        <i>@lang('general/message.password_description')</i>
                    </div>
                    <a id="createpass_submit_e" class="submit_btn allowclick">@lang('general/message.sign_up2_2')</a>
                </form>
            </div>
        </div>
        <div class="reset_phone_box login_signup_step_box">
            <a href="javascript:;" stepData=".login_phone_box"
               class="back_btn switch_step_e">@lang('general/message.back')</a>
            <h6 class="login_title">@lang('general/message.reset_password')</h6>
            <div class="login_signup_form">
                <form class="login_sign_form">
                    <div class="form_put_title">@lang('general/message.country_region')</div>
                    <div class="country_select_box country_select_box_e">
                        <p class="current_selected">@{{yourCountryName}}</p>
                        <div class="country_list_box">
                            <ul class="country_list">
                                <li v-for="countryData in numberCodeList" v-bind:countryCode="countryData.country_code">
                                    <span class="country_name" v-text="countryData.country_name"></span>
                                    <span class="country_number" v-text="'+'+countryData.phone_code"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="phone_number_view">
                        <div class="form_put_title">
                            <i>@lang('general/message.phone_number')</i>
                            <a class="forgot_password show_email_view"
                               href="javascript:;">@lang('general/message.email')</a>
                        </div>
                        <div class="phone_number_tab">
                            <div class="phone_number_box phone_code_box">
                                <p class="phone_number_prev">+@{{yourPhonePrevCode}}</p>
                                <input class="input_trim_e" type="text" id="signup_phone_num1"
                                       v-model="yourPhoneNumber">
                            </div>
                            <a class="phone_code_button signup_send_code_e">@lang('general/message.send')</a>
                        </div>
                        <div class="form_put_title">
                            <i>@lang('general/message.verification_code')</i>
                        </div>
                        <div class="password_tab">
                            <input class="input_trim_e" type="text" id="signup_phone_code1">
                        </div>
                    </div>
                    <div class="email_view" style="display:none;">
                        <div class="form_put_title">
                            <i>@lang('general/message.email')</i>
                            <a class="forgot_password show_phone_number_view"
                               href="javascript:;">@lang('general/message.phone_number')</a>
                        </div>
                        <div class="phone_number_tab">
                            <div class="phone_number_box phone_code_box">
                                <input class="input_trim_e" type="email" id="signup_email1" v-model="yourEmail">
                            </div>
                            <a class="phone_code_button signup_send_code_e">@lang('general/message.send')</a>
                        </div>
                        <div class="form_put_title">
                            <i>@lang('general/message.verification_code')</i>
                        </div>
                        <div class="password_tab">
                            <input class="input_trim_e" type="text" id="signup_email_code1">
                        </div>
                    </div>
                    <div class="form_put_title"><i>@lang('general/message.new_pasword')</i></div>
                    <div class="password_tab">
                        <input id="reset_password" class="input_trim_e" type="password">
                    </div>
                    <a id="reset_submit_e" type="submit"
                       class="submit_btn allowclick">@lang('general/message.submit')</a></form>
            </div>
        </div>
    </div>
</div>
@yield('content')
<div class="page_bottom_wrap">
    <div class="page_bottom_cont">
        <div class="bott_3" style="padding-top:40px">@lang('general/message.copyright')</div>
    </div>
</div>
<div class="fix_tools" id="fix_tools_e">
    <ul>
        <li>
            <a class="tools tools_1" href="javascript:;"></a>
            <div class="load_box">
                <img class="download_code" src="{{asset('assets/img/bigo/code_download.png')}}">
                <p class="tips">@lang('general/message.scan_download')</p>
                <div class="load_btn_box">
                    <a class="item item1"
                       href="https://itunes.apple.com/app/id1077137248"></a>
                    <a>|</a>
                    <a class="item item2"
                       href="https://down.bigo.tv/android/bigolive-bigotv.apk"></a>
                    <a>|</a>
                    <a class="item item3"
                       href="https://play.google.com/store/apps/details?id=sg.bigo.live"></a>
                </div>
            </div>
        </li>
        <li>
            <a class="tools tools_2" href="javascript:;"></a>
            <div class="follow_box">
                <p class="tips">@lang('general/message.tips')</p>
                <div class="follow_btn_box">
                    <a class="item item1" href="https://www.facebook.com/bigoliveapp/"></a>
                    <a class="item item2" href="https://twitter.com/BIGOLIVEapp"></a>
                    <a class="item item3" href="https://www.instagram.com/bigoliveapp/"></a>
                    <a class="item item4" href="https://www.youtube.com/c/bigoliveofficial"></a>
                </div>
            </div>
        </li>
        <li><a class="tools tools_3" href="javascript:;"></a></li>
    </ul>
</div>
<script src="{{asset('assets/js/bigo/lib/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('assets/js/bigo/lib/vue.min.js')}}"></script>
<script src="{{asset('assets/js/bigo/lib/qrcode.min.js')}}"></script>
<script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/emojionearea/dist/emojionearea.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/emojionearea/dist/emojionearea.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
<script src="{{asset('assets/js/bigo/public.js').'?v='.(new DateTime())->getTimestamp() }}')}}"></script>
@yield('footer_scripts')
<script>
    @if($msg = session()->get('broadcast_stop_msg'))
    toastr.error('{{ $msg }}')
    @endif
</script>
</body>
</html>
