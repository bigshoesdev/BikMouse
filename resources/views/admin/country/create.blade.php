@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    @lang('country/form.create')
    @parent
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

    <!-- Main content -->
    <section class="content" style="margin-top: 10px">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="globe" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('country/form.create')
                        </h4>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(array('url' => URL::to('admin/country'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
                        <input type="hidden" name="status" value=1 />
                        <div class="form-group {{ $errors->first('country_name', 'has-error') }}">
                            <label for="country_name" class="col-sm-2 control-label">
                                @lang('country/form.name')
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text('country_name', null, array('class' => 'form-control', 'placeholder'=>'E.g. China')) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! $errors->first('country_name', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('country_code', 'has-error') }}">
                            <label for="country_code" class="col-sm-2 control-label">
                                @lang('country/form.country_code')
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text('country_code', null, array('class' => 'form-control', 'placeholder'=>'E.g. CN')) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! $errors->first('country_code', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('phone_code', 'has-error') }}">
                            <label for="phone_code" class="col-sm-2 control-label">
                                @lang('country/form.phone_code')
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text('phone_code', null, array('class' => 'form-control', 'placeholder'=>'E.g. 86')) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! $errors->first('phone_code', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-default" href="{{ URL::to('admin/country/') }}">
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