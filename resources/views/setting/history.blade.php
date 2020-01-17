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
                @include('partial/setting_menu')
                <div class="recharge_r_c">
                    <div class="recharge_r_bg">
                        <div id="recharge_history_app">
                            <h6 class="recharge_page_title">@lang('general/message.recharge_history')</h6>
                            <div class="recharge_package">
                                <table class="recharge_history">
                                    <tbody>
                                    <tr>
                                        <th width="170">@lang('general/message.date')</th>
                                        <th width="210">@lang('general/message.description')</th>
                                    </tr>
                                    @if(count($transactions) > 0)
                                        @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{$transaction->created_at}}</td>
                                                <td>
                                                    {{$transaction->diamond}}
                                                    @lang('general/message.diamond')s {{$transaction->money }} {{$transaction->currency}}
                                                    <br/>
                                                    {{$transaction->success == 1 ? 'Success' : 'Pending'}} <br/>
                                                    {{$transaction->method}} @lang('general/message.order_no'): {{$transaction->id}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2" style="text-align: center">@lang('general/message.recharge_no_history')</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')

@endsection