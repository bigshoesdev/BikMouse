@extends('layout/default')

@section('title')
    @lang('general/message.game_title')
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{asset('assets/css/bigo/index.css')}}">
@stop
@section('content')
    <div class="page_wrap" data-classifyid="{{$classify->id}}">
        <div id="game_banner_e" class="game_about_wrap">
            <div class="game_load_about_box">
                <a class="game_name">{{ $classify->title}}</a>
            </div>
        </div>
        <div class="game_margin_wrap" id="game_margin_wrap_e">
            <div class="game_live_section">
                <div class="game_live_ul_box bigo_room_list" id="vue_app_game_list">
                    <ul>
                        <li v-for="todo in todos" class="room_item">
                            <a target="_self" v-bind:href="itempath + '/' + todo.id">
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
    <script src="{{asset('assets/js/bigo/game-classify.js')}}"></script>
@endsection