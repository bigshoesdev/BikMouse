@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('broadcast/form.title')
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/admin/tables.css') }}" rel="stylesheet" type="text/css" />
    <style>
        tbody tr td {
            vertical-align: middle !important;
        }
        table {
            text-align: center;
        }
        thead tr th {
            text-align: center !important;
        }
        .btn-broadcast {
            padding: 5px 100px;
            font-size: 20px;
        }
    </style>
@stop


{{-- Page content --}}
@section('content')

    <!-- Main content -->
    <section class="content paddingleft_right15">

        <div id="notific">
            @include('admin/notifications')
        </div>

        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="camera" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('broadcast/form.showbiz')
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div>
                            <a href="{{ URL::to('admin/broadcast/gaming') }}" class="btn btn-sm btn-default btn-broadcast"><span class="glyphicon glyphicon-play"></span> @lang('broadcast/form.gaming')</a>
                            <a href="{{ URL::to('admin/broadcast/showbiz') }}" class="btn btn-sm btn-warning btn-broadcast"><span class="glyphicon glyphicon-camera"></span> @lang('broadcast/form.showbiz')</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" style="vertical-align: center;">
                            <thead>
                            <tr class="filters">
                                <th>@lang('broadcast/form.id')</th>
                                <th>@lang('broadcast/form.logo')</th>
                                <th>@lang('broadcast/form.broadcast')</th>
                                <th>@lang('broadcast/form.user')</th>
                                <th>@lang('broadcast/form.country')</th>
                                {{--<th>@lang('broadcast/form.subcategory')</th>--}}
                                <th>@lang('broadcast/form.live_state')</th>
                                <th>@lang('broadcast/form.status')</th>
                                <th>@lang('general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($broadcasts))
                                @foreach ($broadcasts as $index => $broadcast)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td style="text-align: center">
                                            <img width="150" src="{{URL::to('/' . $broadcast->avatar) }}">
                                        </td>
                                        <td>{{ $broadcast->title }}</td>
                                        <td>{{ $broadcast->user()->nick_name  }}</td>
                                        <td>{{ $broadcast->getCategoryLabel()  }}</td>
                                        {{--<td>{{ $broadcast->subcategory->title  }}</td>--}}
                                        <td @if ($broadcast->is_start == 1) style="color:green" @else style="color:red" @endif>
                                            @if ($broadcast->is_start == 1)
                                                <span class="label label-sm label-success">@lang('broadcast/form.live')</span>
                                            @else
                                                <span class="label label-sm label-danger">@lang('broadcast/form.offline')</span>
                                            @endif
                                        </td>
                                        <td @if ($broadcast->active == 1) style="color:green" @else style="color:red" @endif>
                                            @if ($broadcast->active == 1)
                                                <span class="label label-sm label-success">@lang('broadcast/form.activated')</span>
                                            @else
                                                <span class="label label-sm label-danger">@lang('broadcast/form.disabled')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($broadcast->is_start == 1 && $broadcast->active == 1)
                                                <a href="{{ URL::to('admin/broadcast/' . $broadcast->id . '/connect' ) }}" class="btn btn-warning btn-xs purple">@lang('broadcast/form.connect')</a>
                                            @endif
                                            <a href="{{ URL::to('admin/broadcast/' . $broadcast->id . '/show' ) }}" class="btn btn-primary btn-xs purple">@lang('broadcast/form.detail')</a>
                                            @if ($broadcast->active == 1)
                                                {{--<a class="btn btn-warning btn-xs purple" href="{{ route('admin.broadcast.confirm-delete', $broadcast->id) }}" data-toggle="modal" data-target="#delete_confirm">--}}
                                                {{--@lang('general.disable')--}}
                                                {{--</a>--}}
                                            @else
                                                <a class="btn btn-success btn-xs purple" href="{{ route('admin.broadcast.enable', $broadcast->id) }}">
                                                    @lang('general.enable')
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    <!-- row-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="broadcast_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="broadcast_exists" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    @lang('broadcast/message.broadcast_have_card')
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
        $(document).on("click", ".broadcast_exists", function () {

            var group_name = $(this).data('name');
            $(".modal-header h4").text( group_name+" broadcast" );
        });</script>

@stop
