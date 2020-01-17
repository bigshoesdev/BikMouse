@extends('layout/default')

@section('title')
    @lang('general/message.bikmouse')
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{asset('assets/css/bigo/user.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bigo/lib/cropper.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/bigo/lib/datepicker.css')}}" />
    <style>
        .recharge_wrap .emojionearea.emojionearea-inline {
            width: 300px;
        }
    </style>
@stop

@section('content')
    <div class="recharge_wrap" data-uploadavatarurl="{{route('setting.upload.avatar')}}" data-saveprofileurl="{{route('setting.profile.save')}}">
        <div class="recharge_page">
            <div class="recharge_cont">
                @include('partial.setting_menu')
                <div class="recharge_r_c">
                    <div class="recharge_r_bg">
                        <h6 class="recharge_page_title">@lang('general/message.edit_profile')</h6>
                        <div class="recharge_package">
                            <div class="user_profile_page">
                                <form class="edit_profile_form">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="intro_title" width="140">
                                                <div class="editing_head_icono">
                                                    <img src="{{asset('/'). $user->avatar()}}">
                                                </div>
                                            </td>
                                            <td width="610">
                                                <a class="edit_head_icon_btn commonbtn" id="edit_head_icon_btn"
                                                   href="javascript:;">@lang('general/message.modify_avatar')</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="intro_title">@lang('general/message.age'):</td>
                                            <td>
                                                <input type="number" id="profile_age_e"
                                                       value="{{$user->age}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="intro_title">@lang('general/message.gender'):</td>
                                            <td>
                                                <label class="radio">
                                                    <input @if($user->gender==0){{'checked'}}@endif name="sex"
                                                           type="radio"
                                                           value="0"/>@lang('general/message.male')
                                                </label>
                                                <label class="radio">
                                                    <input @if($user->gender==1){{'checked'}}@endif name="sex"
                                                           type="radio"
                                                           value="1"/>@lang('general/message.female')
                                                </label>
                                                <label class="radio">
                                                    <input @if($user->gender==2){{'checked'}}@endif name="sex"
                                                           type="radio"
                                                           value="2"/>@lang('general/message.keep_secret')
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="intro_title">@lang('general/message.birthday'):</td>
                                            <td>
                                                <div>
                                                    <input data-toggle="datepicker" id="profile_birthday_e" size="16"
                                                           type="text" value="{{$user->birthday}}">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="intro_title">@lang('general/message.name'):</td>
                                            <td>
                                                <input type="text" id="profile_nick_name_e"
                                                       value="{{$user->nick_name}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="intro_title vertical_align_top">
                                                <i>@lang('general/message.self_introduction'):</i></td>
                                            <td>
                                                <textarea id="profile_introduction_e">{{$user->introduction}}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="intro_title">@lang('general/message.hometown'):</td>
                                            <td>
                                                <input type="text" id="profile_hometown_e" value="{{$user->address}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="intro_title"></td>
                                            <td>
                                                <a id="profile_submit_e" class="save_btn commonbtn"
                                                   href="javascript:;">@lang('general/message.save')</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </form>
                                <div class="edit_head_icon_f" id="edit_head_icon_f_e">
                                    <div class="edit_head_icon_c">
                                        <div class="title_box">
                                            <h3 class="title">@lang('general/message.upload_avatar')</h3>
                                            <a href="javascript:;" class="close_btn_icon close_btn_e"></a>
                                        </div>
                                        <div class="preview_wrap">
                                            <div class="canvas_wrap">
                                                <div class="canvas_box img-container">
                                                    <img id="image" src="{{asset('/'). $user->avatar()}}">
                                                </div>
                                                <div class="upload_tips_box">
                                                    <p class="upload_tips">@lang('general/message.upload_avatar')</p>
                                                    <input type="file" id="inputImage"
                                                           accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                                                </div>
                                            </div>
                                            <div class="preview_box">
                                                <div class="preview_thumb img-preview">
                                                    <img src="{{asset('/'). $user->avatar()}}">
                                                </div>
                                                <p class="preview_font">@lang('general/message.preview')</p>
                                            </div>
                                        </div>
                                        <div class="save_edit_icon_b docs-buttons">
                                            <a class="save_btn save_btn_e commonbtn" data-method="getCroppedCanvas"
                                               data-option='{"width": 300, "height": 300}' href="javascript:;">@lang('general/message.ok')</a>
                                            <a class="cancel_btn close_btn_e" href="javascript:;">@lang('general/message.cancel')</a>
                                        </div>
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
    <script src="{{asset('assets/js/bigo/lib/cropper.js')}}"></script>
    <script src="{{asset('assets/js/bigo/lib/datepicker.js')}}"></script>
    <script src="{{asset('assets/js/bigo/user.js')}}"></script>
    <script type="text/javascript">
        $(function() {
            $("#profile_nick_name_e").emojioneArea();
        })
    </script>
@endsection
