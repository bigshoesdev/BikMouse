$(function () {
    var APP = APP || {};
    APP.rootpath = APP.rootpath || $('meta[name="root-path"]').attr('content');

    var vue_app_show_list = new Vue({
        el: '#vue_app_show_list',
        data: {
            itempath: $('body').data('broadcastviewurl'),
            rootpath: APP.rootpath,
            todos: [],
            offset: 0,
            country: 0,
            limit: 8
        }
    });
    var vue_app_game_list = new Vue({
        el: '#vue_app_game_list',
        data: {
            itempath: $('body').data('broadcastviewurl'),
            rootpath: APP.rootpath,
            todos: [],
            offset: 0,
            classify: 0,
            limit: 8
        }
    });
    var classifyDataList = new Vue({
        el: '#classify_vue_e',
        data: {
            gameclassifyurl: $(".page_wrap").data('gameclassifyurl'),
            rootpath: APP.rootpath,
            classifyDataArr: []
        }
    });

    var actAdBanner = new Vue({
        el: '#banner_pic_e',
        data: {
            actAdDatas: {}
        },
        updated: function () {
            var that = this
            if (that.actAdDatas.bg.url) {
                var str = "url('" + that.actAdDatas.bg.url + "')"
                $('#index_recommend_live').css('background-image', str)
                $('#indexBannerLink_e').attr('href', that.actAdDatas.bg.go_url || 'javascript:;')
            }
        }
    });

    var recommendLive = new Vue({
        el: '#index_recommend_live',
        data: {
            rootpath: APP.rootpath,
            recommendArr: [],
        }
    });

    var topRankTab = new Vue({
        el: '#top_rank_tab_e',
        data: {
            rootpath: APP.rootpath,
            beansRanks: [],
            viewsRanks: []
        }
    });

    $.getJSON($('body').data('classifylisturl'), function (json) {
        var data = json.slice(0, 7);
        classifyDataList.classifyDataArr = data;
    });

    $.getJSON($('body').data('livelisturl'), {
        'country': vue_app_show_list.country,
        'offset': vue_app_show_list.offset,
        'limit': vue_app_show_list.limit
    }, function (json) {
        vue_app_show_list.todos = json;
    });

    $.getJSON($('body').data('gamelisturl'), {
        'classify': vue_app_game_list.classify,
        'offset': vue_app_game_list.offset,
        'limit': vue_app_game_list.limit
    }, function (json) {
        vue_app_game_list.todos = json;
    });

    $.getJSON($('body').data('viewuserlisturl'), function (json, textStatus) {
        topRankTab.viewsRanks = json.slice(0, 20);
    });

    $.getJSON($('body').data('beanuserlisturl'), function (json, textStatus) {
        topRankTab.beansRanks = json.slice(0, 20);
    });


    $.getJSON($('body').data('advurl'), function (json) {
        var data = json;
        data.bg = data[0] || {};
        actAdBanner.actAdDatas = data;
        setTimeout(function () {
            APP.initActAdBanner();
        }, 100);
    });

    APP.initActAdBanner = function () {
        var WR = {};
        WR.indexBanner = function () {
            var banner_box = $('#banner_pic_e'),
                banner_ul = banner_box.find('.banner_ul_e'),
                ind_ul = banner_box.find('.banner_ind_e'),
                ind_li = ind_ul.find('li'),
                ind_li_width = ind_li.width() + parseInt(ind_li.css('marginRight')),
                li = banner_ul.find('li'),
                li_width = li.width(),
                li_num = li.length,
                cur = 1,
                str = '';
            if (li_num === 1) {
                return;
            }
            for (var i = 0; i < li_num - 1; i++) {
                str += '<li></li>';
            }
            ind_ul.append(str);
            ind_li = ind_ul.find('li');
            ind_ul.css('marginLeft', -ind_li_width * li_num / 2);
            banner_ul.append(li.eq(0).clone());
            banner_ul.prepend(li.last().clone());
            li_num = li_num + 2;
            banner_ul.width(li_num * li_width);
            return function (ind) {
                if (banner_ul.is(':animated')) {
                    return;
                }
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
                            cur = li_num - 2;
                        } else if (cur == li_num - 1) {
                            cur = 1;
                        }
                        ;
                        banner_ul.css('left', -cur * li_width);
                        ind_li.removeClass('current').eq(cur - 1).addClass('current');
                    });
            }
        }();
        WR.indexBannerId = setInterval(WR.indexBanner, 2000);
        $('#banner_pic_e').on('click', function (event) {
            var tar = $(event.target),
                index = 0,
                now_index = 0;
            if (tar.hasClass('prev_e')) {
                WR.indexBanner(-1);
            } else if (tar.hasClass('next_e')) {
                WR.indexBanner(1);
            } else if (tar.parents('.banner_ind_e').length) {
                if (tar.hasClass('current')) {
                    return;
                } else {
                    index = tar.index();
                    now_index = tar.siblings('.current').index();
                    WR.indexBanner(index - now_index);
                }
            }
            ;
        });
        $('#banner_pic_e').find('.prev_e, .next_e, .banner_ind_e').hover(function () {
            clearInterval(WR.indexBannerId);
        }, function () {
            WR.indexBannerId = setInterval(WR.indexBanner, 2000);
        });

    };

    $.getJSON($('body').data('recommendlisturl'), function (json) {
        var data = json;
        recommendLive.recommendArr = data;

        setTimeout(function () {
            var len = recommendLive.recommendArr.length;
            APP.indexRecommendThumb = APP.indexRecommendThumbInit(Math.floor(Math.random() * len));
        }, 50);

    });

    $('#index_show_sort_e').on('click', 'a', function () {
        var id = $(this).data('id');
        vue_app_show_list.country = id;
        $(this).addClass('selected').siblings('a').removeClass('selected');
        $.getJSON($('body').data('livelisturl'), {
            'country': vue_app_show_list.country,
            'offset': vue_app_show_list.offset,
            'limit': vue_app_show_list.limit
        }, function (json) {
            vue_app_show_list.todos = json;
        });
    });

    $('#index_game_sort_e').on('click', 'a', function () {
        var id = $(this).data('id');
        $(this).addClass('selected').siblings('a').removeClass('selected');
        vue_app_game_list.classify = id;
        $.getJSON($('body').data('gamelisturl'), {
            'classify': vue_app_game_list.classify,
            'offset': vue_app_game_list.offset,
            'limit': vue_app_game_list.limit
        }, function (json) {
            vue_app_game_list.todos = json;
        });
    });

    $('#volume_horn_e').on('click', function (event) {
        var that = $(this);
        var volume = 0;
        var volumeProgressTag = $('#volume_progress_e');
        if (that.hasClass('statu_volume_off')) {
            volume = volumeProgressTag.width() / 100;
            volumeProgressTag.attr('volume', volume > 1 ? 1 : volume);
            VideoController.setVolumeAndProgress(0);
        } else {
            volume = +volumeProgressTag.attr('volume');
            VideoController.setVolumeAndProgress(volume);
        }
    });

    $('#volume_control_e').on('mousedown', '.volume_right_dot', function (event) {
        event.preventDefault();
        var x = event.pageX,
            that = $(this),
            par = that.parent(),
            parW = par.width(),
            maxW = par.parent().width();
        $(document).on('mousemove', function (event) {
            var mx = event.pageX;
            var nowX = parW + mx - x;
            if (nowX < 0 || nowX > maxW) {
                nowX = nowX < 0 ? 0 : maxW;
            }
            VideoController.setVolumeAndProgress(nowX / maxW);
        });
        $(document).on('mouseup', function (event) {
            $(document).off('mousemove');
            $(document).off('mouseup');
        });
    });

    var VideoController = {
        volumeHornTag: $('#volume_horn_e'),
        volumeProgressTag: $('#volume_progress_e'),
        maxProgressWidth: $('#volume_max_e').width(),
        currentVolume: 1,
        setVolumeAndProgress: function (val) {
            this.currentVolume = val;
            if (val === 0) {
                this.volumeHornTag.removeClass('statu_volume_off').addClass('statu_volume_on');
            } else if (val < 0.5) {
                this.volumeHornTag.removeClass('statu_volume_on').addClass('statu_volume_off');
            }
            this.volumeProgressTag.width(val * this.maxProgressWidth);
            document.getElementById('BikMousePlayer').setVolume(val);
            console.log(val);
        }
    };

    $('#top_rank_tab_e').on('click', function (event) {
        event.preventDefault();
        var that = $(this),
            tar = $(event.target),
            index = 0,
            tag = null;
        if (tar.hasClass('rank_tab_btn')) {
            tag = tar.parent();
            index = tag.index();
            tag.addClass('current').siblings().removeClass('current');
            that.find('.top_rank_ul_box').removeClass('current').eq(index).addClass('current');
        } else if (tar.hasClass('statu_follow')) {
        }
    });


    $('#video_select_e').on('click', function (event) {
        var tar = $(event.target);
        if (tar.hasClass('prev_btn')) {
            APP.indexRecommendThumb(-1);
        } else if (tar.hasClass('next_btn')) {
            APP.indexRecommendThumb(1);
        } else if (tar.parent('li').length) {
            var par = tar.parent('li');
            var id = par.data('id');
            par.siblings('li').removeClass('current').parent().find('li[data-id="' + id + '"]').addClass('current');

            APP.getVideoHtmlByBigoid(tar.parent('li').data('id'));
        }
    });

    var flashVideoHtmlStr =
        ' <div id="flashContent" isie=""><object width="100%" height="100%" id="BikMousePlayer">' +
        '<a href="http://www.adobe.com/go/getflash">' +
        '<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" />' +
        '</a>' +
        '</object></div>';

    APP.getVideoHtmlByBigoid = function (id) {
        $.getJSON($('#video_section_e').data('viewtokenurl'), function (t) {
            var broadcast = _.find(recommendLive.recommendArr, function (o) {
                return o.id == id;
            })

            $('#video_section_e #flashContent').remove();
            $('#video_section_e').prepend(flashVideoHtmlStr);

            $('.enter_room_btn_e').attr('href', $('body').data('broadcastviewurl') + '/' + id);
            var swfVersionStr = "11.1.0";
            var xiSwfUrlStr = $('body').data('productinstallurl');
            var flashvars = {};

            flashvars.src = "rtmp://radiocorn.co.kr/live/" + id + "?t=" + t.token;
            flashvars.imageURL = APP.rootpath + broadcast.avatar;
            flashvars.mode = "video";

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
                $('.page_wrap').data('playerurl'), "flashContent",
                "100%", "100%",
                swfVersionStr, xiSwfUrlStr,
                flashvars, params, attributes);
        });
    };

    APP.indexRecommendThumbInit = function (random) {
        var banner_box = $('#video_select_e'),
            banner_ul = banner_box.find('.ind_banner_ul'),
            li = banner_ul.find('li'),
            li_width = li.width() + 2 * parseInt(li.css('marginRight')) + 4,
            li_num = li.length,
            cur = 5
        banner_ul.append(li.filter(':lt(5)').clone())
        banner_ul.prepend(li.filter(':gt(-6)').clone())
        li = banner_ul.find('li');
        li_num = li_num + 10;
        banner_ul.width(li_num * li_width);
        cur = random + 5 - 2;
        banner_box.find('.opa_bg').eq(5 + random).click();
        banner_ul.css('left', -(random + 5 - 2) * li_width);
        return function (ind) {
            if (banner_ul.is(':animated')) {
                return;
            }
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
                        cur = li_num - 10;
                    } else if (cur == li_num - 5) {
                        cur = 5;
                    }
                    banner_ul.css('left', -cur * li_width);
                });
        }
    };
})