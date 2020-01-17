@extends('layout/default')

@section('title')
    @lang('general/message.bikmouse')
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{asset('assets/css/bigo/index.css')}}">
@stop

@section('content')
    <div class="page_wrap" data-productinstallurl="{{asset('assets/swf/playerProductInstall.swf')}}"
         data-gameclassifyurl="{{route('game.classify')}}"
         data-playerurl="{{asset('assets/swf/BikMousePlayer.swf')}}">
        <div class="banner_wrap" id="index_recommend_live" style="">
            <a class="indexBannerLink" target="_blank" id="indexBannerLink_e" href="javascript:;">bannerLink</a>
            <div class="banner_section" id="video_control_full_e">
                <div class="video_section" id="video_section_e" data-viewtokenurl="{{ route('api.view.token') }}">
                    <div id="flashContent" isie="">
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
                            <a class="enter_room enter_room_btn_e" href="javascript:;"
                               target="_self">@lang('general/message.enter_live_room')</a>
                        </div>
                    </div>
                    <a style="display:none;" class="hover_v_ent_room enter_room_btn_e" href="javascript:;">enter
                        room</a>
                </div>
                <div class="video_ind_section" id="video_select_e">
                    <p class="ind_btn prev_btn"></p>
                    <p class="ind_btn next_btn"></p>
                    <div class="ind_banner_box">
                        <ul class="ind_banner_ul">
                            <li v-for="recommend in recommendArr"
                                v-bind:data-id="recommend.id">
                                <img v-bind:src="rootpath + recommend.avatar">
                                <div class="opa_bg"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="page_content_box index_page_content">
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
            <div class="live_wrap">
                <div class="live_section">
                    <div class="game_live_section">
                        <div class="section_title_box">
                            <a class="section_title">@lang('general/message.game_live')</a>
                            <div class="live_sort_ul" id="index_game_sort_e">
                                <a class="selected" data-id="0" href="javascript:;">@lang('general/message.all')</a>
                                @foreach($recommendClassifies as $classify)
                                    <a data-id="{{$classify->id}}" href="javascript:;">{{$classify->title}}</a>
                                @endforeach
                            </div>
                            <a href="{{route('game')}}" class="live_sort_more">@lang('general/message.more') ></a>
                        </div>
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
                        </div>
                    </div>
                </div>
                <div class="live_right_section">
                    <div class="match_banner_wrap">
                        <div class="section_title_box">
                            <a class="section_title">@lang('general/message.tournament')</a>
                        </div>
                        <div class="match_banner" id="banner_pic_e">
                            <ul class="match_banner_ul banner_ul_e">
                                <li v-for="actAd in actAdDatas.cycle">
                                    <a v-bind:href="actAd.go_url">
                                        <img v-bind:src="actAd.url">
                                    </a>
                                </li>
                            </ul>
                            <ul class="match_banner_ind banner_ind_e">
                                <li class="current"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="live_wrap">
                <div class="live_section">
                    <div class="showbiz_live_section">
                        <div class="section_title_box">
                            <a class="section_title">@lang('general/message.showbiz_live')</a>
                            <div class="live_sort_ul" id="index_show_sort_e">
                                <a class="selected" data-code="ALL" href="javascript:;">@lang('general/message.all')</a>
                                @foreach($recommendCountries as $country)
                                    <a data-id="{{$country->id}}" href="javascript:;">{{$country->country_name}}</a>
                                @endforeach
                            </div>
                            <a href="{{route('showbiz')}}" class="live_sort_more">@lang('general/message.more') ></a>
                        </div>
                        <div class="show_live_ul_box bigo_room_list" id="vue_app_show_list">
                            <ul>
                                <li v-for="todo in todos" class="room_item">
                                    <a target="_self" v-bind:href="itempath + '/' + todo.id">
                                        <div class="room_cover">
                                            <img v-bind:src="rootpath + '/' + todo.avatar">
                                        </div>
                                        <div class="recom_hover">
                                            <p class="room_name">@{{ todo.bid }}</p>
                                            <div class="hosts_name_box">
                                                <i class="hosts_name"><p class="text_name">@{{ todo.user.nick_name
                                                        }}</p></i>
                                                <i class="viewer_num">@{{ todo.user_num }}</i>
                                            </div>
                                        </div>
                                        <div class="hover_bg_box"><span class="hover_bg"></span></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="live_right_section">
                    <div class="top_rank_wrap">
                        <div class="section_title_box">
                            <a class="section_title">@lang('general/message.top_rank')</a>
                        </div>
                        <div class="top_rank_box" id="top_rank_tab_e">
                            <ul class="top_rank_box_tab">
                                <li class="current"><a class="rank_tab_btn beans_bg"
                                                       href="javascript:;">@lang('general/message.beans')</a></li>
                                <li><a class="rank_tab_btn views_bg"
                                       href="javascript:;">@lang('general/message.views')</a></li>
                            </ul>
                            <div class="top_rank_ul_box current">
                                <ul>
                                    <li v-for="(rank, index) in beansRanks">
                                        <p class="rank_num">@{{ index+1 }}</p>
                                        <div class="thumb"><img v-bind:src="rootpath + rank.avatar"></div>
                                        <div class="name_box">
                                            <p class="nick_name">@{{ rank.nick_name }}</p>
                                            <p class="beans_views_num">@{{ rank.bean.amount }}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="top_rank_ul_box">
                                <ul>
                                    <li v-for="(rank, index) in viewsRanks">
                                        <p class="rank_num">@{{ index+1 }}</p>
                                        <div class="thumb"><img v-bind:src="rootpath + rank.avatar"></div>
                                        <div class="name_box">
                                            <p class="nick_name">@{{ rank.nick_name }}</p>
                                            <p class="beans_views_num">@{{ rank.view_num }}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_scripts')
    <script src="{{asset('assets/js/bigo/index.js')}}"></script>
    <script src="{{ asset('assets/vendors/swfobj/swfobject.js') }}"></script>
@stop
