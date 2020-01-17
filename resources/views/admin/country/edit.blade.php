@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    @lang('country/form.edit') @parent
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
                            @lang('country/form.edit')
                        </h4>
                    </div>
                    <div class="panel-body">
                        {!! Form::model($country, ['url' => URL::to('admin/country') . '/' . $country->id, 'method' => 'put', 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="status" value="1" />
                        <div class="form-group {{ $errors->first('country_name', 'has-error') }}">
                            <label for="country_name" class="col-sm-2 control-label">
                                @lang('country/form.name')
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text('country_name', null, array('class' => 'form-control', 'placeholder'=>trans('country/form.name'))) !!}
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
                                {!! Form::text('country_code', null, array('class' => 'form-control', 'placeholder'=>trans('country/form.country_code'))) !!}
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
                                {!! Form::text('phone_code', null, array('class' => 'form-control', 'placeholder'=>trans('country/form.phone_code'))) !!}
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