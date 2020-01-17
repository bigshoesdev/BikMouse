@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    @lang('broadcast/form.show') @parent
@stop

@section('header_styles')
    <style>
        .broadcast-row {
            margin-bottom: 10px;
        }
        .broadcast-content {
            font-weight: bold;
            color: #61291f;
            font-size: 16px;
        }
        .broadcast-schema {
            color: #7d5f5f;
            font-size: 15px;
        }
    </style>
@stop
{{-- Content --}}

@section('content')
    <!-- Main content -->
    <section class="content paddingleft_right15" style="margin-top: 10px">

        <div class="row">
                <div class="panel panel-primary ">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left"> <i class="livicon" data-name="film" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('broadcast/form.show')
                        </h4>
                        <div class="pull-right">
                            <a href="{{ URL::to('admin/broadcast') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-list"></span> @lang('broadcast/form.list')</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-4">
                            <div class="broadcast-content" style="margin-top: 20px">
                                    <img src="{{ URL::to('/' . $broadcast->avatar) }}" width="100%" />
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="row broadcast-row" style="margin-top: 20px">
                                <div class="col-sm-4">
                                    <span class="broadcast-schema">@lang('broadcast/form.broadcast') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="broadcast-content">{{ $broadcast->title }}</span>
                                </div>
                            </div>
                            <div class="row broadcast-row">
                                <div class="col-sm-4">
                                    <span class="broadcast-schema">@lang('broadcast/form.user') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="broadcast-content">{{ $broadcast->user()->nick_name }}</span>
                                </div>
                            </div>
                            <div class="row broadcast-row">
                                <div class="col-sm-4">
                                    <span class="broadcast-schema">@lang('broadcast/form.classify') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="broadcast-content">{{ $broadcast->getCategoryLabel() }}</span>
                                </div>
                            </div>
                            <div class="row broadcast-row">
                                <div class="col-sm-4">
                                    <span class="broadcast-schema">@lang('broadcast/form.present_amount') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="broadcast-content beans">0</span>
                                </div>
                            </div>
                            <div class="row broadcast-row">
                                <div class="col-sm-4">
                                    <span class="broadcast-schema">@lang('broadcast/form.user_num') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="broadcast-content viewer_num">{{ $broadcast->user_num }}</span>
                                </div>
                            </div>
                            <div class="row broadcast-row">
                                <div class="col-sm-4">
                                    <span class="broadcast-schema">@lang('broadcast/form.broadcast_id') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="broadcast-content">{{ $broadcast->bid }}</span>
                                </div>
                            </div>
                            <div class="row broadcast-row">
                                <div class="col-sm-4">
                                    <span class="broadcast-schema">@lang('broadcast/form.live_state') :</span>
                                </div>
                                <div class="col-sm-8">
                                    @if ($broadcast->is_start)
                                        <span class="label label-sm label-success">
                                            @lang('broadcast/form.live')
                                        </span>
                                    @else
                                        <span class="label label-sm label-danger">
                                            @lang('broadcast/form.offline')
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row broadcast-row">
                                <div class="col-sm-4">
                                    <span class="broadcast-schema">@lang('broadcast/form.status') :</span>
                                </div>
                                <div class="col-sm-8">
                                    @if ($broadcast->active)
                                        <span class="label label-sm label-success">
                                        @lang('broadcast/form.activated')
                                    </span>
                                    @else
                                        <span class="label label-sm label-danger">
                                        @lang('broadcast/form.disabled')
                                    </span>
                                    @endif
                                </div>
                            </div>
                            {{--<div class="row broadcast-row">--}}
                                {{--<div class="col-sm-4">--}}
                                    {{--<span class="broadcast-schema">@lang('broadcast/form.present_amount') :</span>--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-8">--}}
                                    {{--<span class="broadcast-content"><i class="fa fa-heart" style="color: #e96969"></i> </span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
        </div>
        <!-- row-->
    </section>
@stop
