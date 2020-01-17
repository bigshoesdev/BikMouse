$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var Cropper = window.Cropper;
    var URL = window.URL || window.webkitURL;
    var container = document.querySelector('.img-container');
    var image = container.getElementsByTagName('img').item(0);
    var options = {
        aspectRatio: 1 / 1,
        preview: '.img-preview',
        ready: function (e) {
            console.log(e.type);
        },
        cropstart: function (e) {
            console.log(e.type, e.detail.action);
        },
        cropmove: function (e) {
            console.log(e.type, e.detail.action);
        },
        cropend: function (e) {
            console.log(e.type, e.detail.action);
        },
        crop: function (e) {
            var data = e.detail;
        },
        zoom: function (e) {
            console.log(e.type, e.detail.ratio);
        }
    };
    var cropper = new Cropper(image, options);
    var originalImageURL = image.src;
    var uploadedImageType = 'image/jpeg';
    var uploadedImageURL;

    if (!document.createElement('canvas').getContext) {
        $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
    }

    if (typeof document.createElement('cropper').style.transition === 'undefined') {
        $('button[data-method="rotate"]').prop('disabled', true);
        $('button[data-method="scale"]').prop('disabled', true);
    }

    document.querySelector('.docs-buttons').onclick = function (event) {
        var e = event || window.event;
        var target = e.target || e.srcElement;
        var cropped;
        var result;
        var input;
        var data;

        if (!cropper) {
            return;
        }

        while (target !== this) {
            if (target.getAttribute('data-method')) {
                break;
            }

            target = target.parentNode;
        }

        if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
            return;
        }

        data = {
            method: target.getAttribute('data-method'),
            target: target.getAttribute('data-target'),
            option: target.getAttribute('data-option') || undefined,
            secondOption: target.getAttribute('data-second-option') || undefined
        };

        cropped = cropper.cropped;

        if (data.method) {
            if (typeof data.target !== 'undefined') {
                input = document.querySelector(data.target);

                if (!target.hasAttribute('data-option') && data.target && input) {
                    try {
                        data.option = JSON.parse(input.value);
                    } catch (e) {
                        console.log(e.message);
                    }
                }
            }

            switch (data.method) {
                case 'rotate':
                    if (cropped && options.viewMode > 0) {
                        cropper.clear();
                    }

                    break;

                case 'getCroppedCanvas':
                    try {
                        data.option = JSON.parse(data.option);
                    } catch (e) {
                        console.log(e.message);
                    }

                    if (uploadedImageType === 'image/jpeg') {
                        if (!data.option) {
                            data.option = {};
                        }

                        data.option.fillColor = '#fff';
                    }

                    break;
            }

            result = cropper[data.method](data.option, data.secondOption);

            switch (data.method) {
                case 'rotate':
                    if (cropped && options.viewMode > 0) {
                        cropper.crop();
                    }

                    break;

                case 'scaleX':
                case 'scaleY':
                    target.setAttribute('data-option', -data.option);
                    break;

                case 'getCroppedCanvas':
                    if (result) {
                        var imgBase = result.toDataURL('image/jpeg');
                        var data = {img: imgBase};
                        $.loader.open();
                        $.post($(".recharge_wrap").data('uploadavatarurl'), data, function (res) {
                            $.loader.close();
                            res = JSON.parse(res);
                            if (res.success == true) {
                                successAlert(res.msg, 1);
                            } else {
                                successAlert('error!');
                            }
                        });
                    }

                    break;

                case 'destroy':
                    cropper = null;

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                        uploadedImageURL = '';
                        image.src = originalImageURL;
                    }

                    break;
            }

            if (typeof result === 'object' && result !== cropper && input) {
                try {
                    input.value = JSON.stringify(result);
                } catch (e) {
                    console.log(e.message);
                }
            }
        }
    };

    document.body.onkeydown = function (event) {
        var e = event || window.event;

        if (!cropper || this.scrollTop > 300) {
            return;
        }

        switch (e.keyCode) {
            case 37:
                e.preventDefault();
                cropper.move(-1, 0);
                break;

            case 38:
                e.preventDefault();
                cropper.move(0, -1);
                break;

            case 39:
                e.preventDefault();
                cropper.move(1, 0);
                break;

            case 40:
                e.preventDefault();
                cropper.move(0, 1);
                break;
        }
    };
    ;
    // Import image
    var inputImage = document.getElementById('inputImage');

    if (URL) {
        inputImage.onchange = function () {
            var files = this.files;
            var file;

            if (cropper && files && files.length) {
                file = files[0];

                if (/^image\/\w+/.test(file.type)) {
                    uploadedImageType = file.type;

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }

                    image.src = uploadedImageURL = URL.createObjectURL(file);
                    cropper.destroy();
                    cropper = new Cropper(image, options);
                    inputImage.value = null;
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        };
    } else {
        inputImage.disabled = true;
        inputImage.parentNode.className += ' disabled';
    }
    var successAlert = function (msg, isReload) {
        var data = msg || 'message'
        var str = '<div id="fixedAlert_e" style="position: fixed;z-index: 99999;width: 320px;height: 70px;left: 50%;top: 50%;margin-left: -160px;margin-top: -35px;border-radius: 5px;background: #333;text-align: center;line-height: 70px;font-size: 14px;color: #fff;">' + data + '</div>'
        $('body').append(str)

        if (isReload) {
            setTimeout(function () {
                window.location.reload()
            }, 1000)
        } else {
            setTimeout(function () {
                $('#fixedAlert_e').remove()
            }, 1000)
        }
    }

    $('#profile_submit_e').on('click', function (e) {
        var name = $('#profile_nick_name_e').val(),
            sex = $('[name="sex"]:checked').val(),
            birthday = $('#profile_birthday_e').val(),
            age = $("#profile_age_e").val(),
            introduction = $('#profile_introduction_e').val(),
            hometown = $('#profile_hometown_e').val();
        if(name == ""){
            successAlert('The name is necessary');
        }else if (name.length > 16) {
            successAlert('The name is too long');
        } else if (introduction.length > 200) {
            successAlert('The introduction is too long');
        } else if (hometown.length > 50) {
            successAlert('The hometown is too long');
        } else {
            $.post($(".recharge_wrap").data('saveprofileurl'), {
                nick_name: name,
                gender: sex,
                address: hometown,
                age: age,
                birthday: birthday,
                introduction: introduction
            }, function (data) {
                data = JSON.parse(data);
                if (data.success) {
                    successAlert(data.msg, 1);
                } else {
                    successAlert(data.msg)
                }
            })
        }
    })
    $('#edit_head_icon_btn').on('click', function (e) {
        $('#edit_head_icon_f_e').addClass('current')
    })
    $('#edit_head_icon_f_e').on('click', '.close_btn_e', function (e) {
        $('#edit_head_icon_f_e').removeClass('current')
    })
    $('[data-toggle="datepicker"]').datepicker({
        format: 'yyyy-mm-dd'
    });
})