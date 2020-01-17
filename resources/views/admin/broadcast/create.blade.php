@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    @lang('broadcast/form.create') :: @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/admin/wizard.css') }}" rel="stylesheet">
    <!--end of page level css-->
@stop

{{-- Content --}}

@section('content')
    <section class="content-header">
        <h1>
            @lang('broadcast/form.create')
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="film" data-size="16" data-color="#000"></i> Dashboard
                </a>
            </li>
            <li>@lang('broadcast/form.create')</li>
            <li class="active">
                @lang('broadcast/form.create')
            </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="users-add" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('broadcast/form.create')
                        </h4>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(array('url' => URL::to('admin/broadcast'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
                        <input type="hidden" name="status" value=1 />
                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                @lang('broadcast/form.title')
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=>trans('broadcast/form.title'), 'rows' => 5)) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! $errors->first('title', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('category_id', 'has-error') }}">
                            <label for="status" class="col-sm-2 control-label"> @lang('broadcast/form.category') </label>
                            <div class="col-sm-4">
                                <select class="form-control" title="Select Status..." name="category_id">
                                    @foreach ($categories as $category)
                                    <option value={{ $category->id }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ URL::to('admin/broadcast/') }}">
                                    @lang('button.cancel')
                                </a>
                                <button type="submit" class="btn btn-success">
                                    @lang('button.save')
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- row-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/adduser.js') }}"></script>
    <script>
        function formatState (state) {
            if (!state.id) { return state.text; }
            var $state = $(
                '<span><img src="{{ asset('assets/img/countries_flags') }}/'+ state.element.value.toLowerCase() + '.png" class="img-flag" width="20px" height="20px" /> ' + state.text + '</span>'
            );
            return $state;

        }
        $("#countries").select2({
            templateResult: formatState,
            templateSelection: formatState,
            placeholder: "select a country",
            theme:"bootstrap"
        });

    </script>
@stop