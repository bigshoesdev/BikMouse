@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    @lang('broadcast/form.connect') @parent
@stop

@section('header_styles')
    {{--<link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/css/bootstrap-iso.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('assets/css/broadcast/connect.css') }}">
    <style>
        #marquee-text {
            position: absolute;
            z-index: 2;
            color: #eef1ed;
            margin-top: 50px;
            margin-left: 10px;
            margin-right: 10px;
            font-size: 25px;
        }

        .broadcast-row {
            margin-bottom: 10px;
        }

        .broadcast-content {
            font-weight: bold;
            color: #61291f;
            font-size: 16px;
        }

        .broadcast-schema {
            color: #7d5f5f;
            font-size: 15px;
        }

        li {
            list-style: none;
        }

        .chat_box {
            width: 100%;
            overflow: auto;
        }

        .chat_list {
            width: 350px;
            overflow: hidden;
        }

        .chat_list img {
            vertical-align: middle;
            margin: 0px 5px;
            max-height: 40px;
        }

        .chat_list .user_grade {
            display: inline-block;
            /*position: absolute;
            left: 0;
            top: 0;*/
            margin-left: -25px;
            margin-right: 5px;
        }

        .chat_list .grade_num {
            display: block;
            width: 20px;
            height: 20px;
            border-radius: 20px;
            background: #00ddcc;
            color: #fff;
            text-align: center;
            line-height: 20px;
            font-size: 13px;
        }

        .chat_list .user_name {
            font-size: 14px;
            font-family: 'sans_500';
            color: #2e2e2e;
            margin: 0 5px 0 0;
            line-height: 18px;
        }

        .chat_list li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 25px;
            width: 400px;
        }

        .chat_list .user_text_content {
            font-size: 14px;
            color: #666666;
            /*word-break: break-all;*/
            font-family: 'sans_300';
        }

        .chat_list .room_notice {
            font-size: 14px;
            color: #00ddcc;
            font-family: 'sans_500';
        }

        .chat_list .public_notice {
            width: 310px;
            position: relative;
            left: -20px;
            padding-top: 10px;
        }

        .chat_list .name_dot_chat {
            font-family: 'sans_500';
            font-size: 16px;
            color: #666;
        }

        .flex-video iframe, .flex-video object, .flex-video embed, .flex-video video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .row.secBg {
            margin-bottom: 15px;
        }
    </style>
@stop
{{-- Content --}}

@section('content')
    <!-- Main content -->
    <section class="content" style="margin-top: 20px" data-returnurl="{{route('admin.broadcast.gaming')}}">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left"><i class="livicon" data-name="film" data-size="16"
                                                             data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('broadcast/form.connect')
                        </h4>
                        <div class="pull-right">
                            <a href="{{ URL::to('admin/broadcast') }}" class="btn btn-sm btn-default"><span
                                        class="glyphicon glyphicon-list"></span> @lang('broadcast/form.list')</a>
                        </div>
                        <div class="pull-right">
                            @if ($broadcast->active == 1)
                                <a class="btn btn-sm btn-warning" style="margin-right: 10px" id="delete-broadcast-btn"
                                   href="javascript:;"
                                   data-deleteurl="{{ route('admin.broadcast.delete', $broadcast->id) }}">
                                    <span class="glyphicon glyphicon-remove"></span> @lang('broadcast/form.disable')
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-8" style="border-right: 1px solid #ebebeb">
                            <div class="row secBg">
                                <div class="col-sm-2">
                                    <a href="javascript:;">
                                        <img src="{{ asset('/').$broadcast->user->avatar }}"
                                             width="100%" style="border-radius: 50%">
                                    </a>
                                </div>
                                <div class="col-sm-10">
                                    <h3 style="color:#af6060;font-weight: bold;margin-top: 10px">{{$broadcast->title}}</h3>
                                    <h5 style=" width: 100%; overflow: hidden;font-weight: bold; margin-top: 10px">
                                        @lang('general/message.broadcast'): {{$broadcast->bid}}
                                        <span style="float:right;color: #5a5755;">
                                                <i class="fa fa-user"
                                                   style="color: #e96969;font-size: 20px;margin-right:5px;"></i>
                                                <b id="room-number"
                                                   style="font-size: 19px;margin-right:15px;font-weight:normal">0</b>
                                            </span>
                                    </h5>
                                </div>
                            </div>
                            <div class="row secBg">
                                <div class="col-md-12 inner-flex-video">
                                    <div class="flex-video widescreen" style="height:500px;">
                                        <marquee id="marquee-text"></marquee>
                                        <div id="flashContent">
                                            <object width="100%" height="100%" id="BikMousePlayer">
                                                <a href="http://www.adobe.com/go/getflash">
                                                    <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"
                                                         alt="Get Adobe Flash Player"/>
                                                </a>
                                            </object>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-sm-4">
                            <div class="row" style="margin-top: 10px;">
                                <i class="fa fa-comment" style="color: #af6060;font-size: 20px;"></i>&nbsp
                                <span style="font-size: 20px; font-weight: bold"> @lang('general/message.live_chat')</span>
                            </div>
                            <div class="row" style=" margin-top: 10px; margin-bottom: 10px;">
                                <div class="chat_box" id="chat_scrollBottom_e">
                                    <ul class="chat_list" id="chat-message-container">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row-->
    </section>
@stop

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script src="{{ asset('assets/js/admin/connect.js') }}"></script>
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