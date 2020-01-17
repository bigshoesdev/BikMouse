@extends('layout/default')

@section('title')
    @lang('general/message.bikmouse')
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{asset('assets/css/bigo/user.css')}}">
@stop

@section('content')
    <div class="recharge_wrap">
        <div class="recharge_page">
            <div class="recharge_cont">
                @include('partial.setting_menu')
                <div class="recharge_r_c">
                    <div class="recharge_r_bg">
                        <h6 class="recharge_page_title">@lang('general/message.user_profile')</h6>
                        <div class="recharge_package">
                            <div class="user_profile_page">
                                <div class="user_profile_wrap">
                                    <div class="thumb_wrap thumb_wrap_grade">
                                        <div class="thumb_box">
                                            <img class="thumb_icon" src="{{ asset('/').$user->avatar}}">
                                        </div>
                                        <div class="user_grade">
                                            <i class="user_grade_num">{{$user->level}}</i>
                                        </div>
                                    </div>
                                    <div class="profile_wrap">
                                        <div class="profile_name_box">
                                            <i class="name sex{{$user->gender}}">{{$user->nick_name}}</i>
                                            <i class="age">{{$user->age}}</i>
                                            <a  class="edit_btn" href="{{route('setting.profile')}}"></a>
                                        </div>
                                        <table class="profile_intro">
                                            <tbody>
                                            <tr>
                                                <td class="intro_title" width="140">@lang('general/message.self_intro') :</td>
                                                <td width="610">{{$user->introduction}}</td>
                                            </tr>
                                            <tr>
                                                <td class="intro_title">@lang('general/message.hometown') :</td>
                                                <td>{{$user->address}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="profile_recharge">
                                            <tbody>
                                            <tr>
                                                <td width="140"><i class="diamond_num">{{$user->diamond()->amount}}</i></td>
                                                <td width="610">
                                                    <a class="recharge_btn commonbtn" href="{{route('setting.recharge')}}">@lang('general/message.recharge')</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="recharge_tips_wrap">
                        </div>
                        <h6 class="recharge_page_title">@lang('general/message.broadcast_proflie')</h6>
                        <div class="recharge_package">
                            <div class="user_profile_page">
                                <div class="user_profile_wrap">
                                    <div class="thumb_wrap thumb_wrap_grade">
                                        <div class="thumb_box">
                                            <img class="thumb_icon" src="{{ asset('/').$broadcast->avatar}}">
                                        </div>
                                    </div>
                                    <div class="profile_wrap">
                                        <div class="profile_name_box">
                                            <i class="name">{{$broadcast->title}}</i>
                                            <a  class="edit_btn" href="{{route('setting.broadcast')}}"></a>
                                        </div>
                                        <div class="profile_bigoid">@lang('general/message.broadcast_id'): {{$user->broadcast()->bid}}</div>
                                        <table class="profile_intro">
                                            <tbody>
                                            <tr>
                                                <td class="intro_title" width="140">@lang('general/message.type') :</td>
                                                <td width="610" style="text-transform: uppercase;">{{$broadcast->type}}</td>
                                            </tr>
                                            <tr>
                                                <td class="intro_title">@lang('general/message.category') :</td>
                                                <td>{{$broadcast->getCategoryLabel()}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="profile_recharge">
                                            <tbody>
                                            <tr>
                                                <td width="140"></td>
                                                <td width="610">
                                                    <a class="recharge_btn commonbtn" href="{{route('broadcast')}}">@lang('general/message.broadcast')</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="recharge_tips_wrap">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_scripts')
    <script src="//hdjs.hiido.com/hiido_internal.js" type="text/javascript"></script>
@endsection
