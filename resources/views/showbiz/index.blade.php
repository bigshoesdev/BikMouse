@extends('layout/default')

@section('title')
    @lang('general/message.showbiz_title')
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{asset('assets/css/bigo/style.css')}}">
@stop

@section('content')
    <div class="room_page_wrap">
        <div class="live_list_page">
            <div class="v_list_box">
                <div class="bigo_room_sort clearfix" id="bigo_room_sort_e">
                    <div class="bigo_sort_country">
                        <div class="bigo_sort_inner bigo_sort_inner_e">
                            <a class="country_select selected" data-id="0" href="javascript:;">All</a>
                            @foreach($countries as $index => $country)
                                @if($index == 5)
                                    @break;
                                @endif
                                <a class="country_select" data-id="{{$country->id}}" href="javascript:;">{{$country->country_name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="more_country_box">
                        <a id="more_country_e" class="more_country_btn" href="javascript:;">More</a>
                        <div class="more_country_hov">
                            <p class="line"></p>
                            <div class="more_country_cont">
                                <ul class="continents_list">
                                    <div class="continents"><i class="name">@lang('general/message.all_country')</i></div>
                                    <div class="continents_country">
                                        @foreach($countries as $index => $country)
                                            @if($index <= 4)
                                                @continue;
                                            @endif
                                            <a class="country_select" data-id="{{$country->id}}" href="javascript:;">{{$country->country_name}}</a>
                                        @endforeach
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bigo_list_type show_live_type">
                    <h1 class="title_name">@lang('general/message.hot_live')</h1>
                </div>
                <div class="bigo_room_box">
                    <ul id="show_list_data_e" class="bigo_room_list clearfix bigo_show_list">
                        <li v-for="todo in todos" class="room_item">
                            <a target="_blank" v-bind:href="itempath + '/' + todo.id">
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{asset('assets/js/bigo/showbiz.js')}}"></script>
@endsection
