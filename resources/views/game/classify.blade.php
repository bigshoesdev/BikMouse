@extends('layout/default')

@section('title')
    @lang('general/message.classify_title')
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{asset('assets/css/bigo/index.css')}}">
@stop

@section('content')
    <div class="page_wrap" data-gameclassifyurl="{{route('game.classify')}}">
        <div class="game_margin_wrap" id="game_margin_wrap_e">
            <div class="classify_section" id="classify_vue_e">
                <div class="section_title_box">
                    <a class="section_title">Classify</a>
                </div>
                <div class="classify_content">
                    <ul>
                        <li v-for="classifyData in classifyDataArr">
                            <a v-bind:href="gameclassifyurl+'/' + classifyData.id">
                                <img v-bind:src="rootpath + classifyData.pic">
                                <p class="classify_name">@{{classifyData.title}}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_scripts')
    <script type="text/javascript">
        $(function () {
            var APP = APP || {};
            APP.rootpath = APP.rootpath || $('meta[name="root-path"]').attr('content');

            var classifyDataList = new Vue({
                el: '#classify_vue_e',
                data: {
                    rootpath: APP.rootpath,
                    classifyDataArr: [],
                    gameclassifyurl: $(".page_wrap").data('gameclassifyurl'),
                }
            });

            $.getJSON($('body').data('classifylisturl'), function (json) {
                classifyDataList.classifyDataArr = json;
            });

            APP.adjustGameListSize = function () {
                var respondStyle = $('<style id="respondStyle"></style>');
                $('head').append(respondStyle);
                var marginWrap = $('#game_margin_wrap_e');
                var marginWrapWidth = 0;
                var room_item_w = 0;
                var classify_item_w = 0;
                return function () {
                    if ($('body').height() < $(window).height()) {
                        APP.adjustGameListSizeId = setTimeout(APP.adjustGameListSize, 150);
                        return;
                    }
                    marginWrapWidth = marginWrap.width() + 25;
                    room_item_w = marginWrapWidth / Math.round(marginWrapWidth / 280);
                    classify_item_w = marginWrapWidth / Math.round(marginWrapWidth / 200);
                    var str = '';
                    str += '.bigo_room_list .room_cover{width:' + Math.floor(room_item_w - 25) + 'px !important;}';
                    str += '.show_live_ul_box .room_cover{height:' + (room_item_w - 25) + 'px !important;}';
                    str += '.game_live_ul_box .room_cover{height:' + (room_item_w - 25) * (9 / 16) + 'px !important;}';
                    str += '.classify_content li{width:' + Math.floor(classify_item_w - 25) + 'px !important;height:' + (Math.floor(classify_item_w - 25) * 242 / 174 + 40) + 'px !important;}';
                    str += '.classify_line_one{height:' + ((classify_item_w - 25) * 242 / 174 + 40) + 'px !important;}';
                    respondStyle.html(str);
                }
            }();
            setTimeout(APP.adjustGameListSize, 200);
            APP.adjustGameListSizeId = 0;
            $(window).on('resize', function (event) {
                event.preventDefault();
                clearTimeout(APP.adjustGameListSizeId);
                APP.adjustGameListSizeId = setTimeout(APP.adjustGameListSize, 100);
            });

        })
    </script>
@stop
