var APP = APP || {};

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    APP.rootpath = APP.rootpath || $('meta[name="root-path"]').attr('content');

    APP.fixToolsGoTop = $('#fix_tools_e')
    $(window).on('scroll.scrollDiluted', scrollDiluted)

    function scrollDiluted() {
        scrollCallBack()
        $(window).off('scroll.scrollDiluted')
        setTimeout(function () {
            $(window).on('scroll.scrollDiluted', scrollDiluted)
        }, 500)
    }

    function scrollCallBack() {
        if ($(window).scrollTop() > 300) {
            APP.fixToolsGoTop.addClass('current')
        } else {
            APP.fixToolsGoTop.removeClass('current')
        }
    }

    $('#fix_tools_e').on('click', '.tools_3', function () {
        $('body, html').animate({'scrollTop': 0}, 300)
    });

    var loginView = new Vue({
        el: '#login_scan_wrap_e',
        data: {
            numberCodeList: {},
            yourPhonePrevCode: localStorage.phonePrevCode || "",
            yourCountryCode: localStorage.phonePrevCode || "",
            yourCountryName: localStorage.countryName || "",
            yourPhoneNumber: "",
            yourEmail: "",
            type: 'phone',
            activated: false,
        }
    });

    $.getJSON($('body').data('countrylisturl'), function (json, textStatus) {
        loginView.numberCodeList = json.data;
    });

    var userInfo = new Vue({
        el: '#logined_box_e',
        data: {
            userInfo: {}
        }
    });

    var AppLoginWeb = {
        tagLoginWrap: $('#login_scan_wrap_e'),
        tagLoginImage: $('#login_code_image_e'),
        verifyCode: '',
        user: {},
        alertLoginBox: function () {
            this.tagLoginWrap.addClass('loginStatu').find('.login_after_e').removeClass('current').end().find('.login_before').addClass('current');
        },
        hideLoginBox: function () {
            this.tagLoginWrap.removeClass('loginStatu');
        },
        requestLogin: function () {
            this.alertLoginBox();
        },
        switchLoginStep: function (stepClassName) {
            this.tagLoginWrap.find('.login_signup_step_box').removeClass('current').end().find(stepClassName).addClass('current');
        },
        checkPassword: function (val) {
            return /^\w{6,16}$/.test(val);
        },
        checkPhoneNumber: function(phonenumber) {
            var regex = /^([0-9]{11})$/;
            return regex.test(phonenumber);
        },
        checkEmail: function (email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        },
        statusCodeMapping: {
            '94': 'The phone number is not valid',
            '95': 'There are some problems sending verification code',
            '96': 'The verification code doe not match.',
            '97': 'The verification code is not sent.Please send verification code.',
            '98': 'The email is not valid',
            '99': 'The email can not be empty',
            '100': 'Please choose the country corresponding to the phone number',
            '101': 'The phone number can not be empty',
            '102': 'The verification code must be filled',
            '103': 'The password can not be empty',
            '104': 'The password can not be less than 6 characters and no more than 16 characters',
            '105': 'The password can only be the combination of numbers，underscores or letters',
            '106': 'The phone number must be combined by numbers',
            '107': 'Your request is too frequent',
            '108': 'The phone number must be combined by numbers',
            '109': 'The password can not be less than 6 characters',
            '110': 'The verification code has been sent and is valid for 5 minutes',
            '111': 'The verification code must be combined by numbers',
            '100001': 'The formot of phone number is wrong',
            '100002': 'The password can not be less than 6 characters',
            '100003': 'The password can only be the combination of numbers，underscores or letters',
            '100004': 'Verification Code error',
            '11000': 'The user is not exsited',
            '200': 'Success',
            '401': 'The phone number or password is error',
            '404': 'Your phone number is not registered yet. Please turn to sign up first',
            '409': 'The phone number has registered. Please just login in',
            '420': 'The same phone number can not be re-register in 30 days',
            '422': 'Invalid phone number',
            '430': 'It seems that the policy reasons lead to  the restriction of registration',
            '453': 'Your request is too frequent. Please try again 30 minutes later',
            '521': 'The verification code is wrong',
            '522': 'The verification code has been sent. Please use the obtained verification code or try later',
            '524': 'Invalid phone number or expired verification code',
            '531': 'It seems that you are on the blacklist. Please try to contact us',
            other: 'There seems some errors with the service. Please try again'
        },
        alertLoginMsg: function (statusCode, msg) {
            var str = '<div id="alertLoginMsg_e" style="position:absolute;width:100%;height:100%;z-index:999;left:0;top:0;"><div style="padding:20px 10px;width:300px;color:#fff;font-size:14px;text-align: center;margin:200px auto 0;background: rgba(0,0,0,0.5);border-radius: 3px;line-height: 150%;">[===]:===</div></div>';
            if (msg) {
                str = str.replace(/===/, statusCode).replace(/===/, msg);
            } else {
                str = str.replace(/===/, statusCode).replace(/===/, this.statusCodeMapping[statusCode] || this.statusCodeMapping.other);
            }
            this.tagLoginWrap.find('.login_signup_step_w').find('#alertLoginMsg_e').remove().end().append(str);
            setTimeout(function () {
                $('#alertLoginMsg_e').remove();
            }, 1000);
        },
        sendCodeCounter: function (dom) {
            if (window.timer) {
                window.clearTimeout(window.timer);
            }

            var timeCounterCont = 'Resend(===)';
            var timeStart = (+new Date());
            dom.addClass('noClick');
            var counter = function () {
                var time = 300000 - (+new Date()) + timeStart;
                if (time < 0) {
                    dom.text('Resend');
                    dom.removeClass('noClick');
                    AppLoginWeb.verifyCode = "";
                    return;
                } else {
                    dom.text(timeCounterCont.replace(/===/, Math.floor(time / 1000)));
                    window.timer = setTimeout(function () {
                        counter();
                    }, 1000);
                }
            };
            counter();
        },
    }

    $('#login_submit_e').on('click', function (event) {
        var phoneNum = loginView.yourPhoneNumber;
        var email = loginView.yourEmail;
        var password = $.trim($('#login_password_put').val());
        var phonePrevCode = loginView.yourPhonePrevCode;
        var type = loginView.type;
        if (type == 'phone') {
            if (phoneNum.length === 0) {
                AppLoginWeb.alertLoginMsg('101');
                $('#signup_phone_num').focus();
                return false;
            }
            if (!AppLoginWeb.checkPhoneNumber(phoneNum)) {
                AppLoginWeb.alertLoginMsg('94');
                $('#signup_phone_num').focus();
                return false;
            }
            if (phonePrevCode.length === 0) {
                AppLoginWeb.alertLoginMsg('100');
                return false;
            }
        } else {
            if (email.length === 0) {
                AppLoginWeb.alertLoginMsg('99')
                $('#signup_email').focus()
                return false;
            }
            if (!AppLoginWeb.checkEmail(email)) {
                AppLoginWeb.alertLoginMsg('98');
                $('#signup_email').focus();
                return false;
            }
        }
        if (password.length < 6) {
            AppLoginWeb.alertLoginMsg('109');
            return false;
        }

        AppLoginWeb.user.loginid = type == "email" ? email : phoneNum;
        AppLoginWeb.user.type = type;
        AppLoginWeb.user.password = password;
        AppLoginWeb.user.phonecode = phonePrevCode;

        $.loader.open();
        $.post($('body').data('signinurl'), AppLoginWeb.user, function (result) {
            if (result.success) {
                AppLoginWeb.alertLoginMsg('200');
                location.reload(result.url);
            } else {
                AppLoginWeb.alertLoginMsg('401', result.msg);
            }
            $.loader.close();
        }, 'json');
    });

    $('#signup_submit_e').on('click', function (event) {
        var phoneNum = loginView.yourPhoneNumber;
        var phoneCode = $.trim($('#signup_phone_code').val());
        var phonePrevCode = loginView.yourPhonePrevCode;
        var email = $.trim(loginView.yourEmail);
        var emailCode = $.trim($('#signup_email_code').val());
        var type = loginView.type;

        if (AppLoginWeb.verifyCode == "") {
            AppLoginWeb.alertLoginMsg('97');
            return false;
        }

        if (type == 'phone') {
            if (phoneNum.length === 0) {
                AppLoginWeb.alertLoginMsg('101')
                $('#signup_phone_num').focus()
                return false;
            } else if (phoneCode.length === 0) {
                AppLoginWeb.alertLoginMsg('102')
                $('#signup_phone_code').focus();
                return false;
            } else if (phonePrevCode.length === 0) {
                AppLoginWeb.alertLoginMsg('100');
                return false;
            }
        } else {
            if (email.length === 0) {
                AppLoginWeb.alertLoginMsg('99')
                $('#signup_email').focus()
                return false;
            } else if (emailCode.length === 0) {
                AppLoginWeb.alertLoginMsg('102')
                $('#signup_email_code').focus();
                return false;
            }
            if (!AppLoginWeb.checkEmail(email)) {
                AppLoginWeb.alertLoginMsg('98');
                $('#signup_email').focus();
                return false;
            }
        }

        var v = type == 'phone' ? phoneCode : emailCode;

        if (v != AppLoginWeb.verifyCode) {
            AppLoginWeb.alertLoginMsg('96');
            return;
        }

        AppLoginWeb.verifyCode = '';
        AppLoginWeb.user.loginid = type == "email" ? email : phoneNum;
        AppLoginWeb.user.type = type;
        AppLoginWeb.user.phonecode = phonePrevCode;
        AppLoginWeb.switchLoginStep('.create_phone_box');
    });

    $("#reset_submit_e").click(function() {
        var phoneNum = loginView.yourPhoneNumber;
        var phoneCode = $.trim($('#signup_phone_code1').val());
        var phonePrevCode = loginView.yourPhonePrevCode;
        var email = $.trim(loginView.yourEmail);
        var emailCode = $.trim($('#signup_email_code1').val());
        var type = loginView.type;

        if (type == 'phone') {
            if (phoneNum.length === 0) {
                AppLoginWeb.alertLoginMsg('101')
                $('#signup_phone_num1').focus()
                return false;
            } else if (phoneCode.length === 0) {
                AppLoginWeb.alertLoginMsg('102')
                $('#signup_phone_code1').focus();
                return false;
            } else if (phonePrevCode.length === 0) {
                AppLoginWeb.alertLoginMsg('100');
                return false;
            }
        } else {
            if (email.length === 0) {
                AppLoginWeb.alertLoginMsg('99')
                $('#signup_email1').focus()
                return false;
            } else if (emailCode.length === 0) {
                AppLoginWeb.alertLoginMsg('102')
                $('#signup_email_code1').focus();
                return false;
            }
            if (!AppLoginWeb.checkEmail(email)) {
                AppLoginWeb.alertLoginMsg('98');
                $('#signup_email1').focus();
                return false;
            }
        }

        var v = type == 'phone' ? phoneCode : emailCode;

        if (v != AppLoginWeb.verifyCode) {
            AppLoginWeb.alertLoginMsg('96');
            return;
        }
        var password = $.trim($('#reset_password').val());
        if (password.length < 6 || password.length > 16) {
            AppLoginWeb.alertLoginMsg('104');
            return false;
        } else if (!AppLoginWeb.checkPassword(password)) {
            AppLoginWeb.alertLoginMsg('105');
            return false;
        }

        AppLoginWeb.user.loginid = type == "email" ? email : phoneNum;
        AppLoginWeb.user.type = type;
        AppLoginWeb.user.phonecode = phonePrevCode;
        AppLoginWeb.user.password = password;

        $.loader.open();

        $.post($('body').data('resetpasswordurl'), AppLoginWeb.user, function (result) {
            if (result.success) {
                AppLoginWeb.alertLoginMsg('200', result.msg);
            } else {
                AppLoginWeb.alertLoginMsg('200', result.msg);
            }
            $.loader.close();
        }, 'json');
    });

    $('#createpass_submit_e').on('click', function (event) {
        var password = $.trim($('#create_password').val());
        if (password.length < 6 || password.length > 16) {
            AppLoginWeb.alertLoginMsg('104');
            return false;
        } else if (!AppLoginWeb.checkPassword(password)) {
            AppLoginWeb.alertLoginMsg('105');
            return false;
        }
        AppLoginWeb.user.password = password;

        $.loader.open();

        $.post($('body').data('signupurl'), AppLoginWeb.user, function (result) {
            if (result.success) {
                AppLoginWeb.alertLoginMsg('200');
                location.reload();
            } else {
                AppLoginWeb.alertLoginMsg('200', result.msg);
            }
            $.loader.close();
        }, 'json');
    });

    $('.phone_code_button.signup_send_code_e').on('click', function (event) {
        if ($(this).hasClass('noClick')) {
            return;
        }
        var phoneNum = loginView.yourPhoneNumber;
        var phonePrevCode = loginView.yourPhonePrevCode;
        var email = $.trim(loginView.yourEmail);
        var type = loginView.type;
        var obj = {};

        if (type == 'phone') {
            if (phoneNum.length === 0) {
                AppLoginWeb.alertLoginMsg('101')
                $('#signup_phone_num').focus()
                return false;
            } else if (phonePrevCode.length === 0) {
                AppLoginWeb.alertLoginMsg('100');
                return false;
            }
        } else {
            if (email.length === 0) {
                AppLoginWeb.alertLoginMsg('99')
                $('#signup_email').focus()
                return false;
            }
            if (!AppLoginWeb.checkEmail(email)) {
                AppLoginWeb.alertLoginMsg('98');
                $('#signup_email').focus();
                return;
            }
        }
        obj.type = type;
        obj.loginid = obj.type == "email" ? email : phoneNum;
        obj.phonecode = phonePrevCode;

        $.loader.open();
        $.post($('body').data('sendcodeurl'), obj, function (result) {
            if (result.success) {
                AppLoginWeb.verifyCode = result.code;
                AppLoginWeb.alertLoginMsg('110');
                AppLoginWeb.sendCodeCounter($('.signup_send_code_e'));
            } else {
                AppLoginWeb.alertLoginMsg('200', result.msg);
            }
            $.loader.close();
        }, 'json');
    });

    $('#seeable_password_btn_e').on('click', function (event) {
        var that = $(this);
        var seePasswordBg = $('#seeable_bg_e');
        var passwordInput = $('#create_password');
        if (that.hasClass('nosee')) {
            that.removeClass('nosee');
            seePasswordBg.removeClass('nosee');
            passwordInput.attr('type', 'text');
        } else {
            that.addClass('nosee');
            seePasswordBg.addClass('nosee');
            passwordInput.attr('type', 'password');
        }
    });

    $('.country_select_box_e').on('click', function (event) {
        event.preventDefault();
        var that = $(this);
        var tar = $(event.target);
        var countryCode = "";
        if (that.hasClass('current')) {
            that.removeClass('current');
        } else {
            that.addClass('current');
        }
        if (tar.parents('ul').length) {
            countryCode = tar.attr('countrycode') || tar.parent().attr('countrycode');

            loginView.yourPhonePrevCode = loginView.numberCodeList[countryCode].phone_code;
            loginView.yourCountryCode = countryCode;
            loginView.yourCountryName = loginView.numberCodeList[countryCode].country_name;

            localStorage.phonePrevCode = loginView.yourPhonePrevCode;
            localStorage.countryCode = loginView.yourCountryCode;
            localStorage.countryName = loginView.yourCountryName;
        }
    });

    $("#login_scan_wrap_e .sns-enter").click(function () {
        var snsType = $(this).data('channel');
        window.loginWindow = window.open('', 'Login',"menubar=1,resizable=1");
        window.loginWindow.document.write('Loading preview...');

        $.getJSON($('body').data('socialredirecturl') + "/" + snsType, function (json) {
            window.handleLogin = handleLoginWindowPopupResult;
            window.loginWindow.location.href = json.url;
            // window.loginWindow = window.open(json.url, "Login", "menubar=1,resizable=1");
        });
    })

    $("#login_scan_wrap_e .show_email_view").on('click',   function () {
        loginView.type = 'email';
        $("#login_scan_wrap_e .phone_number_view").hide();
        $("#login_scan_wrap_e .email_view").show();
    });

    $("#login_scan_wrap_e .show_phone_number_view").on('click', function () {
        loginView.type = 'phone';
        $("#login_scan_wrap_e .phone_number_view").show();
        $("#login_scan_wrap_e .email_view").hide();
    });

    $('#login_scan_wrap_e').on('click', '.close_btn', function (event) {
        AppLoginWeb.hideLoginBox();
        $('#login_btn_e').one('click', function (event) {
            AppLoginWeb.requestLogin();
        });
    });

    $('.switch_step_e').on('click', function (event) {
        event.preventDefault();
        var stepClassName = $(this).attr('stepData');
        AppLoginWeb.switchLoginStep(stepClassName);
        if (!document.getElementById('google-recaptcha')) {
            // BigoLoginWeb.initGoogleRecaptcha()
        }
    });

    $('#login_btn_e').one('click', function (event) {
        AppLoginWeb.requestLogin();
    });

    $(window).on('load', function (event) {
        event.preventDefault();
        if (!localStorage.getItem('firstLogin') && $('.login_wrap').length) {
            $('.login_wrap').append('<div class="login_guide"><p class="login_guide_btn"></p></div>');
            localStorage.setItem('firstLogin', 'visited');
        }
    });

    $('.login_wrap').on('click', '.login_guide_btn', function (e) {
        $('.login_guide').remove();
    });

    function handleLoginWindowPopupResult(result) {
        if (window.loginWindow)
            window.loginWindow.close();
        if (result.success == true) {
            location.reload();
        } else if (result.success == false) {
            toastr.error(result.msg);
        }
    }
});
