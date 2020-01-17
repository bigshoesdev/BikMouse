@extends('layout/default')

@section('title')
    {{$broadcast->title}} On @lang('general/message.bikmouse')
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{asset('assets/css/bigo/style.css')}}">
    <style>
        .room_page {
            margin-left: 60px;
            margin-right: 60px;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .user_words_msg input {
            width: 268px;
            height: 45px;
            border: none;
            padding: 5px 10px 10px;
            font-size: 14px;
            color: #000;
            font-family: 'sans_300';
        }

        #marquee-text {
            position: absolute;
            z-index: 2;
            color: #eef1ed;
            margin-top: 50px;
            margin-left: 10px;
            margin-right: 10px;
            font-size: 25px;
        }

.emojionearea.emojionearea-inline {
    height: 55px;
    width: 288px;
}
    </style>
@stop

@section('content')
    <div class="room_page_wrap">
        <div class="room_page">
            <div class="room_main clearfix">
                <div class="room_left_box">
                    <div class="hosts_about_box">
                        <div class="hosts_about clearfix">
                            <div class="thumber f_left">
                                <img class="thumb_img" src="{{ asset('/').$broadcast->user->avatar}}">
                            </div>
                            <div class="hosts_name_id f_left">
                                <h3 class="hosts_name">{{$broadcast->title}}</h3>
                                <i id="hosts_id_e"
                                   class="hosts_id">@lang('general/message.broadcast_id') {{$broadcast->bid}}</i>
                                <i class="line">|</i><i class="beans" id="beans_e">0</i>
                                <i class="viewer_num viewer_num_e">{{$broadcast->user_num}}</i>
                            </div>
                        </div>
                    </div>
                    <div class="room_video" id="room_video_e" data-type="{{$broadcast->type}}">
                        <marquee id="marquee-text"></marquee>
                        <div id="flashContent" isie="">
                            <object width="100%" height="100%" id="BikMousePlayer">
                                <a href="http://www.adobe.com/go/getflash">
                                    <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"
                                         alt="Get Adobe Flash Player"/>
                                </a>
                            </object>
                        </div>
                        <div class="video_control_box">
                            <div class="video_control_inner">
                                <div class="volume_control_box" id="volume_control_e">
                                    <p class="horn_btn statu_volume_off" id="volume_horn_e"></p>
                                    <div class="volume_bg" id="volume_max_e">
                                        <div class="volume_current" id="volume_progress_e">
                                            <p class="volume_right_dot"></p>
                                        </div>
                                    </div>
                                </div>
                                <div style="display:none;" class="rotate_v_btn" id="rotate_v_e"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="room_act_banner" id="act_room_banner_e"><a target="_blank" href="https://www.cubetv.sg">
                        <img src="{{asset('assets/img/bigo/en.png')}}">
                    </a></div>
                <div class="room_right">
                    <div class="chat_box" id="chat_scrollBottom_e">
                        <ul class="chat_list">
                            <li>
                                <p class="room_notice public_notice">@lang('general/message.broadcast_view_message_notice')
                                </p>
                            </li>
                        </ul>
                        <ul class="chat_list" id="chat-message-container">
                        </ul>
                    </div>
                    <div class="user_sent_msg">
                        <div class="user_words_msg">
                            <input id="chat-message-input" placeholder="chat with everyone"></input>
                            @if(!Sentinel::check())
                                <div class="login_tips" id="chat_login_tips_e">@lang('general/message.login_to_chat')
                                </div>
                            @endif
                            <a id="chat-message-send-btn" class="send_btn"
                               href="javascript:;">@lang('general/message.send')</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="v_recommend_box" id="v_recommend_box_e">
                <div class="bigo_list_type recom_live_type">
                    <h1 class="title_name">@lang('general/message.recommended_live')</h1>
                    <a id="refresh_btn_e" class="refresh_btn" href="javascript:;">@lang('general/message.change')</a>
                </div>
                <div class="bigo_recom" id="bigo_recom_box_e">
                    <ul class="bigo_room_list clearfix">
                        <li v-for="todo in todos" class="room_item">
                            <a target="_self" v-bind:href="itempath + '/' + todo.id">
                                <div class="hosts_photo">
                                    <img v-bind:src="rootpath + '/' + todo.avatar">
                                </div>
                                <div class="recom_hover">
                                    <p class="room_name">@{{ todo.title }}</p>
                                    <div class="hosts_name_box">
                                        <i class="hosts_name"><p class="text_name">@{{ todo.user.nick_name }}</p></i>
                                        <i class="viewer_num">@{{ todo.user_num }}</i>
                                    </div>
                                </div>
                                <div class="hover_bg_box"><span class="hover_bg"></span></div>
                            </a>
                        </li>
                    </ul>
                    <div style="display:none" id="all_ignore_uids"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{asset('assets/js/bigo/broadcast-view.js')}}"></script>
    <script src="{{ asset('assets/vendors/swfobj/swfobject.js') }}"></script>
    <script src="https://radiocorn.co.kr:3000/socket.io/socket.io.js"></script>
    <script type="text/javascript">
        var chatInfo = {
            broadcast: {
                id: '{{$broadcast->bid}}',
                title: '{{$broadcast->title }}',
                is_start: {{$broadcast->is_start}}
            },
            user: {
                id: '{{Sentinel::getUser()->id}}',
                nick_name: '{{Sentinel::getUser()->nick_name}}',
                pic: '{{ Sentinel::getUser()->avatar }}',
                level: '{{Sentinel::getUser()->level }}'
            }
        };

        // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection.
        var swfVersionStr = "11.1.0";
        // To use express install, set to playerProductInstall.swf, otherwise the empty string.
        var xiSwfUrlStr = "{{asset('assets/swf/playerProductInstall.swf')}}";
        var flashvars = {};

        flashvars.src = "rtmp://192.168.99.172/live/{{$broadcast->bid}}?t={{$token->token}}";
        flashvars.imageURL = "{{ asset('/').$broadcast->avatar}}";
        flashvars.mode = "video";
        flashvars.onLoaded = "onFlashLoaded";

        var params = {};
        params.quality = "high";
        params.bgcolor = "white";
        params.allowscriptaccess = "sameDomain";
        params.allowfullscreen = "true";
        var attributes = {};
        attributes.id = "BikMousePlayer";
        attributes.name = "BikMousePlayer";
        attributes.align = "middle";
        swfobject.embedSWF(
            "{{asset('assets/swf/BikMousePlayer.swf')}}", "flashContent",
            "100%", "100%",
            swfVersionStr, xiSwfUrlStr,
            flashvars, params, attributes);

        var isFlashLoaded, roomConnect = false;

        function onFlashLoaded() {
            isFlashLoaded = true;
        }

    </script>
@endsection
