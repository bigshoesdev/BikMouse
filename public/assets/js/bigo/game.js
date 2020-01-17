$(function () {
    var APP = APP || {};
    APP.rootpath = APP.rootpath || $('meta[name="root-path"]').attr('content');
    var classifyDataList = new Vue({
        el: '#classify_vue_e',
        data: {
            gameclassifyurl: $(".page_wrap").data('gameclassifyurl'),
            rootpath: APP.rootpath,
            classifyDataArr: [],
        }
    });

    $.getJSON($('body').data('classifylisturl'), function (json) {
        var data = json.slice(0, 12);
        classifyDataList.classifyDataArr = data;
    });

    var vue_app_game_list = new Vue({
        el: '#vue_app_game_list',
        data: {
            itempath: $('body').data('broadcastviewurl'),
            rootpath: APP.rootpath,
            todos: [],
            offset: 0,
            classify: 0,
            limit: 20,
            nodata: false
        }
    });

    $.getJSON($('body').data('gamelisturl'), {
        'classify': vue_app_game_list.classify,
        'offset': vue_app_game_list.offset,
        'limit': vue_app_game_list.limit
    }, function (json) {
        vue_app_game_list.todos = json;
    });

    $('#index_game_sort_e').on('click', 'a', function () {
        var classifyID = $(this).data('id');
        $(this).addClass('selected').siblings('a').removeClass('selected');
        vue_app_game_list.offset = 0;
        vue_app_game_list.classify = classifyID;
        vue_app_game_list.nodata = false;
        vue_app_game_list.todos = [];
        $.getJSON($('body').data('gamelisturl'), {
            'classify': vue_app_game_list.classify,
            'offset': vue_app_game_list.offset,
            'limit': vue_app_game_list.limit
        }, function (json) {
            vue_app_game_list.todos = json;
            APP.bodyHeight = $('body').height();
            APP.windowScroll = 1;
            APP.checkAutoLoadAjax();
        });
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
    window.onresize = function () {
        clearTimeout(APP.adjustGameListSizeId);
        APP.adjustGameListSizeId = setTimeout(APP.adjustGameListSize, 100);
    };

    APP.indexBannerPre = function () {
        var banner_box = $('#game_rec_banner_e'),
            banner_ul = banner_box.find('.banner_ul_e'),
            ind_ul = banner_box.find('.banner_ind_e'),
            ind_li = ind_ul.find('li'),
            ind_li_width = ind_li.width() + parseInt(ind_li.css('marginRight')),
            li = banner_ul.find('li'),
            li_width = li.width() + parseInt(li.css('marginRight')),
            li_num = li.length,
            cur = 3,
            str = '';
        for (var i = 0; i < li_num - 1; i++) {
            str += '<li></li>';
        }
        ind_ul.append(str);
        ind_li = ind_ul.find('li');
        // ind_ul.css('marginLeft',  -ind_li_width*li_num/2 );
        banner_ul.append(li.filter(':lt(3)').clone());
        banner_ul.prepend(li.filter(':gt(-4)').clone());
        li = banner_ul.find('li');
        li_num = li_num + 6;
        banner_ul.width(li_num * li_width);
        return function (ind) {
            if (banner_ul.is(':animated')) {
                return;
            }
            ;
            if (arguments.length === 0) {
                cur++;
            } else {
                cur = cur + ind;
            }
            banner_ul.animate({
                    'left': -cur * li_width
                },
                600, function () {
                    if (cur == 0) {
                        cur = li_num - 6;
                    } else if (cur == li_num - 3) {
                        cur = 3;
                    }
                    banner_ul.css('left', -cur * li_width);
                    li.removeClass('current').eq(cur + 1).addClass('current');
                    ind_li.removeClass('current').eq(cur - 3).addClass('current');
                });
        }
    };

    APP.gameRecommendBannerClick = function () {
        $('#game_rec_banner_e').on('click', function (event) {
            var tar = $(event.target),
                index = 0,
                now_index = 0;
            if (tar.hasClass('prev_e')) {
                APP.indexBanner(-1);
            } else if (tar.hasClass('next_e')) {
                APP.indexBanner(1);
            } else if (tar.parents('.banner_ind_e').length) {
                if (tar.hasClass('current')) {
                    return;
                } else {
                    index = tar.index();
                    now_index = tar.siblings('.current').index();
                    APP.indexBanner(index - now_index);
                }
            }
        });
        $('#game_rec_banner_e').find('.prev_e, .next_e, .banner_ind_e').hover(function () {
            clearInterval(APP.indexBannerId);
        }, function () {
            APP.indexBannerId = setInterval(APP.indexBanner, 2000);
        });
    };

    APP.bodyHeight = $('body').height();
    APP.windowHeight = $(window).height();
    APP.windowScroll = 1;
    APP.loadAjaxScrollTimeOut = '';
    var loadAjaxScroll = function () {
        if (APP.windowScroll) {
            if ($(window).scrollTop() + APP.windowHeight > APP.bodyHeight - 100) {
                APP.windowScroll = 0;
                vue_app_game_list.offset = vue_app_game_list.offset + vue_app_game_list.limit;
                if (!vue_app_game_list.nodata) {
                    $.getJSON($('body').data('gamelisturl'), {
                        'classify': vue_app_game_list.classify,
                        'offset': vue_app_game_list.offset,
                        'limit': vue_app_game_list.limit
                    }, function (res) {
                        if (res.length == 0) {
                            vue_app_game_list.nodata = true;
                        }
                        vue_app_game_list.todos = vue_app_game_list.todos.concat(res);
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
        if ($(window).scrollTop() + APP.windowHeight > APP.bodyHeight - 100) {
            loadAjaxScroll();
        }
    };

    $(window).on('scroll', function (event) {
        if (APP.windowScroll) {
            clearTimeout(APP.loadAjaxScrollTimeOut);
            APP.loadAjaxScrollTimeOut = setTimeout(loadAjaxScroll, 200);
        }
    });

})
