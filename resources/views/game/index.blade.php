@extends('layout/default')

@section('title')
    @lang('general/message.game_title')
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{asset('assets/css/bigo/index.css')}}">
@stop

@section('content')
    <div class="page_wrap" data-gameclassifyurl="{{route('game.classify')}}">
        <div class="game_margin_wrap" id="game_margin_wrap_e">
            <div class="classify_section" id="classify_vue_e">
                <div class="section_title_box">
                    <a class="section_title">@lang('general/message.classify')</a>
                    <a href="{{route('classify')}}" class="live_sort_more">@lang('general/message.more') &gt;</a>
                </div>
                <div class="classify_content">
                    <ul class="classify_line_one">
                        <li v-for="classifyData in classifyDataArr">
                            <a v-bind:href="gameclassifyurl+'/' + classifyData.id">
                                <img v-bind:src="rootpath + classifyData.pic">
                                <p class="classify_name">@{{classifyData.title}}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="game_live_section">
                <div class="section_title_box">
                    <a class="section_title">@lang('general/message.game_live')</a>
                    <div class="live_sort_ul" id="index_game_sort_e">
                        <a class="selected" data-id="0" href="javascript:;">@lang('general/message.all')</a>
                        @foreach($recommendClassifies as $classify)
                            <a data-id="{{$classify->id}}" href="javascript:;">{{$classify->title}}</a>
                        @endforeach
                    </div>
                </div>
                <div class="game_live_ul_box bigo_room_list" id="vue_app_game_list">
                    <ul>
                        <li v-for="todo in todos" class="room_item">
                            <a target="_self" v-bind:href="itempath+'/'+ todo.id">
                                <div class="room_cover">
                                    <img v-bind:src="rootpath + todo.avatar">
                                </div>
                                <div class="game_li_detail_box">
                                    <div class="thumb"><img v-bind:src="rootpath + todo.user.avatar"></div>
                                    <div class="name_box">
                                        <p class="room_name">@{{ todo.title }}</p>
                                        <p class="hosts_name">@{{ todo.user.nick_name }}</p>
                                    </div>
                                    <i class="viewer_num">@{{ todo.user_num }}</i>
                                </div>
                                <div class="hover_bg_box hover_bg_game"><span class="hover_bg"></span></div>
                            </a>
                        </li>
                    </ul>
                    <div class="all_ignore_uids" v-if="!nodata"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{asset('assets/js/bigo/game.js')}}"></script>
@endsection
