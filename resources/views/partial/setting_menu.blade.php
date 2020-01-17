<div class="recharge_l_c">
    <div class="recharge_nav_box">
        <ul class="recharge_nav">
            <li>
                <a class="recharge_nav_list recharge_nav_user @if(Request::url() == route('setting.index') || Request::url() == route('setting.profile')){{'current'}}@endif"
                   href="{{route('setting.index')}}">@lang('general/message.user_profile')</a>
            </li>
            <li>
                <p class="recharge_nav_list recharge_nav_channel @if(Request::url() == route('setting.recharge.paypal')){{'current'}}@endif">@lang('general/message.recharge_methods')</p>
                <ul class="nav_nav">
                    <li>
                        <a href="{{route('setting.recharge.paypal')}}">
                            <p class="payicon_b"><img src="{{asset('assets/img/general/paypal_img.png')}}"></p>
                            <i class="payicon_name">@lang('general/message.paypal')</i>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="recharge_nav_list recharge_nav_history @if(Request::url() == route('setting.recharge.history')){{'current'}}@endif"
                   href="{{route('setting.recharge.history')}}">@lang('general/message.recharge_history')</a>
            </li>
        </ul>
    </div>
</div>