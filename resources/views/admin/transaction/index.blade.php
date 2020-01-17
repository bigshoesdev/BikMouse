@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('transaction/form.title')
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/admin/tables.css') }}" rel="stylesheet" type="text/css" />
    <style>
        table {
            text-align: center;
        }
        thead tr th {
            text-align: center !important;
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
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="money" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('transaction/form.title')
                    </h4>
                    {{--<div class="pull-right">--}}
                    {{--<a href="{{ URL::to('admin/broadcast') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-list"></span> @lang('transaction/form.broadcast_list')</a>--}}
                    {{--</div>--}}
                </div>
                <br />
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" style="vertical-align: center;">
                            <thead>
                            <tr class="filters">
                                <th>@lang('transaction/form.id')</th>
                                <th>@lang('transaction/form.user')</th>
                                <th>@lang('transaction/form.paymethod')</th>
                                <th>@lang('transaction/form.diamond')</th>
                                <th>@lang('transaction/form.amount')</th>
                                <th>@lang('transaction/form.created_at')</th>
                                <th>@lang('transaction/form.status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($transactions))
                                @foreach ($transactions as $index => $transaction)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>@if ($transaction->user()) {{ $transaction->user()->nick_name }} @endif</td>
                                        <td style="text-transform: uppercase">{{ $transaction->method }}</td>
                                        <td class="td-transaction-diamond">{{ $transaction->diamond  }} </td>
                                        <td>{{ $transaction->money }} {{ $transaction->currency }}</td>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>
                                            @if ($transaction->success == 1)
                                                <span class="label label-sm label-success">@lang('transaction/form.success')</span>
                                            @else
                                                <span class="label label-sm label-danger">@lang('transaction/form.failed')</span>
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
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="transaction_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="transaction_exists" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    @lang('transaction/message.transaction_have_card')
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
        $(document).on("click", ".transaction_exists", function () {

            var group_name = $(this).data('name');
            $(".modal-header h4").text( group_name+" transaction" );
        });</script>

@stop
