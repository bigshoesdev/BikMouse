@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('present/form.title')
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/admin/tables.css') }}" rel="stylesheet" type="text/css" />
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
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="film" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('present/form.title')
                    </h4>
                    <div class="pull-right">
                    <a href="{{ URL::to('admin/broadcast') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-list"></span> @lang('present/form.broadcast_list')</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" style="vertical-align: center;">
                            <thead>
                            <tr class="filters">
                                <th>@lang('present/form.id')</th>
                                <th>@lang('present/form.broadcast')</th>
                                <th>@lang('present/form.user')</th>
                                <th>@lang('present/form.amount')</th>
                                <th>@lang('present/form.created_at')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($presents))
                                @foreach ($presents as $present)
                                    <tr>
                                        <td>{{ $present->id }}</td>
                                        <td>{{ $present->broadcast->title }}</td>
                                        <td>{{ $present->user()->name  }}</td>
                                        <td>{{ $present->amount  }}</td>
                                        <td>{{ $present->created_at }}</td>
                                        {{--<td>--}}
                                            {{--<a href="{{ URL::to('admin/present/' . $present->id . '/presents' ) }}"><i class="livicon"--}}
                                                                                                                           {{--data-name="edit"--}}
                                                                                                                           {{--data-size="18"--}}
                                                                                                                           {{--data-loop="true"--}}
                                                                                                                           {{--data-c="#428BCA"--}}
                                                                                                                           {{--data-hc="#428BCA"--}}
                                                                                                                           {{--title="@lang('general.update')"></i></a>--}}

                                            {{--<a href="{{ route('admin.present.confirm-delete', $present->id) }}" data-toggle="modal" data-target="#delete_confirm">--}}
                                                {{--<i class="livicon" data-name="remove-alt" data-size="18"--}}
                                                   {{--data-loop="true" data-c="#f56954" data-hc="#f56954"--}}
                                                   {{--title="@lang('present/form.delete')"></i>--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
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
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="present_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="present_exists" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    @lang('present/message.present_have_card')
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
        $(document).on("click", ".present_exists", function () {

            var group_name = $(this).data('name');
            $(".modal-header h4").text( group_name+" present" );
        });</script>

@stop
