@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    @lang('user/form.show') @parent
@stop

@section('header_styles')
    <style>
        .user-row {
            margin-bottom: 10px;
        }
        .user-content {
            font-weight: bold;
            color: #61291f;
            font-size: 16px;
        }
        .user-schema {
            color: #7d5f5f;
            font-size: 15px;
        }
    </style>
@stop
{{-- Content --}}

@section('content')
    <!-- Main content -->
    <section class="content" style="margin-top: 10px">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading clearfix">
                        <h2 class="panel-title pull-left"> <i class="livicon" data-name="users-add" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('user/form.show')
                        </h2>
                        <div class="pull-right">
                            <a href="{{ URL::to('admin/users') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-list"></span>  @lang('user/form.list')</a>
                        </div>
                    </div>
                    <div class="panel-body">
                            <div class="col-sm-3">
                                <span class="user-content">
                                    @if ($user->pic)
                                        <img src="{{ URL::to('/' . $user->pic) }}" width="100%" />
                                    @else
                                        <img src="{{ asset('assets/img/no_avatar.jpg') }}" width="100%" />
                                    @endif
                                </span>
                            </div>
                        <div class="col-sm-9">
                            <div class="row user-row" style="margin-top: 20px">
                                <div class="col-sm-4">
                                    <span class="user-schema">@lang('user/form.name') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="user-content">{{ $user->nick_name }}</span>
                                </div>
                            </div>
                            <div class="row user-row">
                                <div class="col-sm-4">
                                    <span class="user-schema">@lang('user/form.loginid') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="user-content">{{ $user->loginid }}</span>
                                </div>
                            </div>
                            <div class="row user-row">
                                <div class="col-sm-4">
                                    <span class="user-schema">@lang('user/form.gender') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="user-content">{{ $user->gender() }}</span>
                                </div>
                            </div>
                            <div class="row user-row">
                                <div class="col-sm-4">
                                    <span class="user-schema">@lang('user/form.birthday') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="user-content">{{ $user->birthday }}</span>
                                </div>
                            </div>
                            <div class="row user-row">
                                <div class="col-sm-4">
                                    <span class="user-schema">@lang('user/form.address') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="user-content">{{ $user->address }}</span>
                                </div>
                            </div>
                            <div class="row user-row">
                                <div class="col-sm-4">
                                    <span class="user-schema">@lang('user/form.intro') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="user-content">{{ $user->introduction }}</span>
                                </div>
                            </div>
                            <div class="row user-row">
                                <div class="col-sm-4">
                                    <span class="user-schema">@lang('user/form.diamond') :</span>
                                </div>
                                <div class="col-sm-8">
                                    <span class="user-content user-diamond">{{ $user->diamond()->amount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row-->
    </section>
@stop