@extends('layout/default')

@section('title')
    @lang('general/message.bikmouse')
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{asset('assets/css/bigo/user.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bigo/lib/cropper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/bigo/lib/datepicker.css')}}"/>
    <style>
        .recharge_wrap .emojionearea.emojionearea-inline {
            width: 300px;
        }
    </style>
@stop

@section('content')
    <div class="recharge_wrap" data-uploadavatarurl="{{route('setting.broadcast.upload.avatar')}}"
         data-savebroadcasturl="{{route('setting.broadcast.save')}}">
        <div class="recharge_page">
            <div class="recharge_cont">
                @include('partial.setting_menu')
                <div class="recharge_r_c">
                    <div class="recharge_r_bg">
                        <h6 class="recharge_page_title">@lang('general/message.edit_broadcast')</h6>
                        <div class="recharge_package">
                            <div class="user_profile_page">
                                <form class="edit_profile_form">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="intro_title" width="140">
                                                <div class="editing_head_icono">
                                                    <img src="{{asset('/'). $broadcast->avatar}}">
                                                </div>
                                            </td>
                                            <td width="610">
                                                <a class="edit_head_icon_btn commonbtn" id="edit_head_icon_btn"
                                                   href="javascript:;">@lang('general/message.modify_avatar')</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="intro_title">@lang('general/message.type'):</td>
                                            <td>
                                                <select name="type" id="broadcast_type">
                                                    <option value="game" @if($broadcast->type == 'game' ){{'selected'}}@endif>@lang('general/message.game')</option>
                                                    <option value="live" @if($broadcast->type == 'live' ){{'selected'}}@endif>@lang('general/message.showbiz')</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="intro_title">@lang('general/message.category'):</td>
                                            <td>
                                                <select name="category" id="broadcast_category_live"
                                                        style="@if($broadcast->type == 'game' || $broadcast->type == ""){{'display:none'}}@endif">
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}" @if($broadcast->type == 'live' && $country->id == $broadcast->category_id){{'selected'}}@endif>{{$country->country_name}}</option>
                                                    @endforeach
                                                </select>
                                                <select name="category" id="broadcast_category_game"
                                                        style="@if($broadcast->type == 'live'){{'display:none'}}@endif">
                                                    @foreach($classifies as $classify)
                                                        <option value="{{$classify->id}}" @if($broadcast->type == 'game' && $classify->id == $broadcast->category_id){{'selected'}}@endif>{{$classify->title}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="intro_title">@lang('general/message.title'):</td>
                                            <td>
                                                <input type="text" id="broadcast_title" value="{{$broadcast->title}}">
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
                                                    <img id="image" src="{{asset('/'). $broadcast->avatar}}">
                                                </div>
                                                <div class="upload_tips_box">
                                                    <p class="upload_tips">@lang('general/message.upload_avatar')</p>
                                                    <input type="file" id="inputImage"
                                                           accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                                                </div>
                                            </div>
                                            <div class="preview_box">
                                                <div class="preview_thumb img-preview">
                                                    <img src="{{asset('/'). $broadcast->avatar}}">
                                                </div>
                                                <p class="preview_font">@lang('general/message.preview')</p>
                                            </div>
                                        </div>
                                        <div class="save_edit_icon_b docs-buttons">
                                            <a class="save_btn save_btn_e commonbtn" data-method="getCroppedCanvas"
                                               data-option='{"width": 300, "height": 300}'
                                               href="javascript:;">@lang('general/message.ok')</a>
                                            <a class="cancel_btn close_btn_e"
                                               href="javascript:;">@lang('general/message.cancel')</a>
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
    <script src="{{asset('assets/js/bigo/broadcast.js')}}"></script>
@endsection
