@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('user/form.title')
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
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('user/form.title')
                    </h4>
                </div>
                <br />
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th>@lang('user/form.id')</th>
                                <th>@lang('user/form.avatar')</th>
                                <th>@lang('user/form.name')</th>
                                <th>@lang('user/form.loginid')</th>
                                <th>@lang('user/form.gender')</th>
                                <th>@lang('user/form.diamond')</th>
                                <th>@lang('user/form.status')</th>
                                <th>@lang('general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($users))
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td style="text-align: center">
                                            <img width="75" src="{{URL::to('/' . $user->avatar) }}">
                                        </td>
                                        <td>{{ $user->nick_name }}</td>
                                        <td>{{ $user->loginid }}</td>
                                        <td>{{ $user->gender() }}</td>
                                        <td class="td-user-diamond">{{ $user->diamond()->amount }}</td>
                                        <td @if ($user->active == 1) style="color:green" @else style="color:red" @endif>
                                            @if ($user->active == 1)
                                                <span class="label label-sm label-success">@lang('user/form.activated')</span>
                                            @else
                                                <span class="label label-sm label-danger">@lang('user/form.disabled')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ URL::to('admin/users/' . $user->id . '/show' ) }}" class="btn btn-primary btn-xs purple">@lang('general.detail')</a>

                                            @if ($user->active == 1)
                                                <a class="btn btn-warning btn-xs purple" @if (Sentinel::getUser()->id != $user->id) href="{{ route('admin.users.confirm-disable', $user->id) }}" @else href="#" disabled @endif data-toggle="modal" data-target="#delete_confirm">
                                                    @lang('general.disable')
                                                </a>
                                            @else
                                                <a class="btn btn-success btn-xs purple" @if (Sentinel::getUser()->id != $user->id) href="{{ route('admin.users.enable', $user->id) }}" @else href="#" disabled @endif>
                                                    @lang('general.enable')
                                                </a>
                                            @endif
                                            <a class="btn btn-danger btn-xs purple" @if (Sentinel::getUser()->id != $user->id) href="{{ route('admin.users.confirm-delete', $user->id) }}" @else href="#" disabled @endif data-toggle="modal" data-target="#delete_confirm">
                                                @lang('general.delete')
                                            </a>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop
