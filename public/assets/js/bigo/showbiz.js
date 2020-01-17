$(function () {
    var APP = APP || {};
    APP.rootpath = APP.rootpath || $('meta[name="root-path"]').attr('content');

    APP.adjustLiveListTimeOut = '';
    APP.adjustLiveList = function () {
        var respondStyle = $('<style id="respondStyle"></style>');
        $('head').append(respondStyle);
        var list_ul = $('.bigo_room_list');
        var list_ul_w = 0;
        var room_item_w = 0;
        return function () {
            if ($('body').height() < $(window).height()) {
                APP.adjustLiveListTimeOut = setTimeout(APP.adjustLiveList, 100);
                return;
            }
            list_ul_w = list_ul.width();
            room_item_w = list_ul_w / Math.ceil(list_ul_w / 270);
            var str = '';
            str += '.room_item{width:' + Math.floor(room_item_w) + 'px !important;}';
            str += '.bigo_show_list .hosts_photo{height:' + (room_item_w - 10) + 'px !important;}';
            str += '.bigo_game_list .hosts_photo{height:' + (room_item_w - 10) * (9 / 16) + 'px !important;}';
            respondStyle.html(str);
        }
    }();
    APP.adjustLiveListTimeOut = setTimeout(APP.adjustLiveList, 50);

    window.onresize = function () {
        clearTimeout(APP.adjustLiveListTimeOut);
        APP.adjustLiveListTimeOut = setTimeout(APP.adjustLiveList, 100);
        APP.windowHeight = $(window).height();
    };

    var vue_app_loading_list = new Vue({
        el: '#show_list_data_e',
        data: {
            itempath: $('body').data('broadcastviewurl'),
            rootpath: APP.rootpath,
            todos: [],
            offset: 0,
            country: 0,
            limit: 20,
            nodata: false
        },
    });

    $.getJSON($('body').data('livelisturl'), {
        'country': vue_app_loading_list.classify,
        'offset': vue_app_loading_list.offset,
        'limit': vue_app_loading_list.limit
    }, function (json) {
        vue_app_loading_list.todos = json;
    });

    $('#bigo_room_sort_e').on('click', '.country_select', function () {
        var more_country_btn = $('#more_country_e');
        $('#bigo_room_sort_e').find('.country_select').removeClass('selected');
        $(this).addClass('selected');
        if ($(this).parent('.bigo_sort_inner_e').length) {
            more_country_btn.removeClass('selected');
        } else {
            more_country_btn.addClass('selected');
        }
        var id = $(this).data('id');
        vue_app_loading_list.offset = 0;
        vue_app_loading_list.country = id;
        vue_app_loading_list.nodata = false;
        vue_app_loading_list.todos = [];

        $.getJSON($('body').data('livelisturl'), {
            'country': vue_app_loading_list.country,
            'offset': vue_app_loading_list.offset,
            'limit': vue_app_loading_list.limit
        }, function (json) {
            vue_app_loading_list.todos = json;

            APP.bodyHeight = $('body').height();
            APP.windowScroll = 1;
            APP.checkAutoLoadAjax();
        });
    });

    APP.bodyHeight = $('body').height();
    APP.windowHeight = $(window).height();
    APP.windowScroll = 1;
    APP.loadAjaxScrollTimeOut = '';
    var loadAjaxScroll = function () {
        if (APP.windowScroll) {
            if ($(window).scrollTop() + APP.windowHeight > APP.bodyHeight - 100) {
                APP.windowScroll = 0;
                vue_app_loading_list.offset = vue_app_loading_list.offset + vue_app_loading_list.limit;
                if (!vue_app_loading_list.nodata) {
                    $.getJSON($('body').data('livelisturl'), {
                        'country': vue_app_loading_list.country,
                        'offset': vue_app_loading_list.offset,
                        'limit': vue_app_loading_list.limit
                    }, function (res) {
                        if (res.length == 0) {
                            vue_app_loading_list.nodata = true;
                        }
                        vue_app_loading_list.todos = vue_app_loading_list.todos.concat(res);
                        APP.bodyHeight = APP.bodyHeight + 300;
                        setTimeout(function () {
                            APP.bodyHeight = $('body').height();
                            APP.windowScroll = 1;
                            APP.checkAutoLoadAjax();
                        }, 300);
                    });
                }
            }
        } else {
            return false;
        }
    };

    APP.checkAutoLoadAjax = function () {
        if (APP.windowScroll && $(window).scrollTop() + APP.windowHeight > APP.bodyHeight - 100) {
            loadAjaxScroll();
        }
    };

    $(window).on('scroll', function (event) {
        if (APP.windowScroll) {
            clearTimeout(APP.loadAjaxScrollTimeOut);
            APP.loadAjaxScrollTimeOut = setTimeout(loadAjaxScroll, 200);
        }
    });
});