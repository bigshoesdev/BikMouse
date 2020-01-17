@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    @lang('classify/form.edit') @parent
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="users-add" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            @lang('classify/form.edit')
                        </h4>
                    </div>
                    <div class="panel-body">
                        {!! Form::model($classify, ['url' => URL::to('admin/classify') . '/' . $classify->id, 'method' => 'put', 'class' => 'form-horizontal', 'files'=> true]) !!}
                        <input type="hidden" name="status" value="1" />
                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                @lang('classify/form.title')
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=>trans('classify/form.title'))) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! $errors->first('title', '<span class="help-block">:message</span> ') !!}
                            </div>

                        </div>

                        <div class="form-group {{ $errors->first('logo_file', 'has-error') }}">
                            <label for="pic" class="col-sm-2 control-label">@lang('classify/form.logo')</label>
                            <div class="col-sm-10">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                        <img src="{{ URL::to('/' . $classify->logo ) }}" alt="Logo picture">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new">Upload image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input id="pic" name="logo_file" type="file" class="form-control"/>
                                        </span>
                                        <a href="#" class="btn btn-danger fileinput-exists"
                                           data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                                <span class="help-block">{{ $errors->first('logo_file', ':message') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ URL::to('admin/classify/') }}">
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
@stop