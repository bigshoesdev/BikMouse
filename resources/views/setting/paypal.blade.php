@extends('layout/default')

@section('title')
    @lang('general/message.bikmouse')
@stop

@section('header_styles')
    <link rel="stylesheet" href="{{asset('assets/css/bigo/user.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bigo/lib/cropper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/bigo/lib/datepicker.css')}}"/>
@stop


@section('content')
    <div class="recharge_wrap">
        <div class="recharge_page">
            <div class="recharge_cont">
                @include('partial.setting_menu')
                <div class="recharge_r_c">
                    <div class="recharge_r_bg">
                        <h6 class="recharge_page_title">@lang('general/message.recharge_by_paypal')</h6>
                        <div class="recharge_package">
                            <ul class="re_package_list" id="re_package_list_e">
                                @foreach([49, 252, 504, 2520, 5040, 12600, 25200, 37800, 50400, 100800] as $v)
                                    <li data-method="paypal">
                                        <div class="package_num">
                                            <span>{{$v}}</span>
                                        </div>
                                        <div class="package_price"><span>(USD {{number_format($v /50.4,2)}})</span></div>
                                    </li>
                                @endforeach
                            </ul>

                            <form method="post" action={{route('setting.recharge.charge')}} id="recharge-form">
                                {{ csrf_field() }}
                                <input type="hidden" name="diamond" id="recharge-form-diamond">
                                <input type="hidden" name="method" id="recharge-form-method">
                            </form>
                            @if(session()->has('message'))
                                <div class="re_confirm_tips" id="re_confirm_tips_e">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="re_confirm_tips" id="re_confirm_tips_e">
                                @lang('general/message.confirm_recharge')
                            </div>
                            <a id="recharge_btn_e" class="next_btn re_sure_btn"
                               href="javascript:;">@lang('general/message.next')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_scripts')
    <script type="text/javascript">
        $(function () {
            $('#re_package_list_e').on('click', 'li', function (event) {
                var tar = $(this);
                tar.addClass('current').siblings('li').removeClass('current');
                var diamond_num = tar.find('.package_num').find('span').text();
                var recharge_num = tar.find('.package_price').find('span').text();
                $('#re_confirm_tips_e').find('.diamond_num').text(diamond_num).end().find('.recharge_num').text(recharge_num);
            });

            $('#recharge_btn_e').one('click', function (event) {
                $('#recharge_btn_e').attr('style', 'background:#999;')
                var method = $(".re_package_list li.current").data('method');
                var diamond_num = $(".re_package_list li.current").find('.package_num').find('span').text();

                $("#recharge-form-diamond").val(diamond_num);
                $("#recharge-form-method").val(method);
                $("#recharge-form").submit();
            });

            setTimeout(function () {
                $('#re_package_list_e').find('li').eq(0).click();
            }, 500);
        })
    </script>
@endsection