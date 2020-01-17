@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('country/form.title')
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
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="globe" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('country/form.title')
                    </h4>
                    <div class="pull-right">
                        <a href="{{ URL::to('admin/country/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" style="vertical-align: center;">
                            <thead>
                            <tr class="filters">
                                <th>@lang('country/form.id')</th>
                                <th>@lang('country/form.name')</th>
                                <th>@lang('country/form.country_code')</th>
                                <th>@lang('country/form.phone_code')</th>
                                <th>@lang('general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($countries))
                                @foreach ($countries as $index => $country)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $country->country_name }}</td>
                                        <td>{{ $country->country_code  }}</td>
                                        <td>{{ $country->phone_code  }}</td>
                                        <td>
                                            <a href="{{ URL::to('admin/country/' . $country->id . '/edit' ) }}" class="btn btn-primary btn-xs purple">@lang('button.edit')</a>

                                            <a href="{{ route('admin.country.confirm-delete', $country->id) }}" class="btn btn-danger btn-xs purple" data-toggle="modal" data-target="#delete_confirm">@lang('button.delete')</a>
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
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="country_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="country_exists" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    @lang('country/message.country_have_card')
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
        $(document).on("click", ".country_exists", function () {

            var group_name = $(this).data('name');
            $(".modal-header h4").text( group_name+" country" );
        });</script>

@stop
