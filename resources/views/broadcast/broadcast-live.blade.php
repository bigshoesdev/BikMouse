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

        .broadcast_start {
            position: absolute;
            right: 20px;
            top: 18px;
            border-radius: 3px;
            background: #00ddcc;
            text-align: center;
        }

        .broadcast_start:hover {
            background: #a0d6d2;
        }

        .broadcast_start:before {
            display: block;
            content: "";
            width: 16px;
            height: 16px;
            position: absolute;
            left: 10px;
            top: 7px;
            z-index: 8;
            background: none;
        }

        .broadcast_start a {
            display: block;
            line-height: 30px;
            width: 90px;
            height: 30px;
            color: white;
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
                            @if($broadcast->active == 1)
                                <div class="broadcast_start">
                                    <a href="javascript::" id="broadcast_start_btn">@lang('general/message.start')</a>
                                    <a href="javascript::" style="display: none;"
                                       id="broadcast_stop_btn">@lang('general/message.stop')</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="room_video" id="room_video_e" data-type="{{$broadcast->type}}"
                         style="background-image:none;">
                        <marquee id="marquee-text"></marquee>
                        <div id="flashContent" isie="">
                            <object width="100%" height="100%" id="BikMouseRecorder">
                                <a href="http://www.adobe.com/go/getflash">
                                    <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"
                                         alt="Get Adobe Flash Player"/>
                                </a>
                            </object>
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
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{asset('assets/js/bigo/broadcast-live.js')}}"></script>
    <script src="{{ asset('assets/vendors/swfobj/swfobject.js') }}"></script>
    <script src="https://radiocorn.co.kr:3000/socket.io/socket.io.js"></script>
    <!-- page level js starts-->
    <script type="text/javascript">
        @if($broadcast->active == 0)
        toastr.error('@lang('general/message.broadcast_block')');
        @else
        $.loader.open();

        var chatInfo = {
            broadcast: {
                id: '{{$broadcast->bid}}',
                title: '{{$broadcast->title }}',
                is_start: {{$broadcast->is_start}}
            },
            user: {
                id: '{{$broadcast->user()->id}}',
                nick_name: '{{$broadcast->user()->nick_name}}',
                pic: '{{ $broadcast->user()->avatar }}',
                level: '{{ $broadcast->user()->level }}'
            }
        };

        // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection.
        var swfVersionStr = "11.1.0";
        // To use express install, set to playerProductInstall.swf, otherwise the empty string.
        var xiSwfUrlStr = "{{asset('assets/swf/playerProductInstall.swf')}}";
        var flashvars = {};

        flashvars.connection = "rtmp://192.168.99.172/live?t={{$token->token}}";
        flashvars.bigoid = "{{$broadcast->bid}}";
        flashvars.imageURL = "{{ asset('/').$broadcast->avatar}}";
        flashvars.onLoaded = "onFlashLoaded";

        var params = {};
        params.quality = "high";
        params.bgcolor = "#FFFFFF";
        params.allowscriptaccess = "sameDomain";
        params.allowfullscreen = "true";
        var attributes = {};
        attributes.id = "BikMouseRecorder";
        attributes.name = "BikMouseRecorder";
        attributes.align = "middle";
        swfobject.embedSWF(
            "{{asset('assets/swf/BikMouseRecorder.swf')}}", "flashContent",
            "100%", "100%",
            swfVersionStr, xiSwfUrlStr,
            flashvars, params, attributes);

        var isFlashLoaded = false, roomConnect = false;

        function onFlashLoaded() {
            isFlashLoaded = true;
        }

        var timerFlashID = setInterval(function () {
            if (isFlashLoaded && roomConnect) {
                $.loader.close();
                clearInterval(timerFlashID);
            }
        }, 500);
        @endif
    </script>
    <!--page level js ends-->
@endsection
