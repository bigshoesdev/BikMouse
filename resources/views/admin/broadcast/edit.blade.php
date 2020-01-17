@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    @lang('subcategory/form.edit') :: @parent
@stop

{{-- Content --}}

@section('content')
    <section class="content-header">
        <h1>
            @lang('subcategory/form.edit')
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="film" data-size="16" data-color="#000"></i> Dashboard
                </a>
            </li>
            <li>@lang('subcategory/form.edit')</li>
            <li class="active">
                @lang('subcategory/form.edit')
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
                            @lang('subcategory/form.edit')
                        </h4>
                    </div>
                    <div class="panel-body">
                        {!! Form::model($subcategory, ['url' => URL::to('admin/subcategory') . '/' . $subcategory->id, 'method' => 'put', 'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="status" value="1" />
                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                @lang('subcategory/form.title')
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=>trans('subcategory/form.title'))) !!}
                            </div>
                            <div class="col-sm-3">
                                {!! $errors->first('title', '<span class="help-block">:message</span> ') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('category_id', 'has-error') }}">
                            <label for="status" class="col-sm-2 control-label"> @lang('subcategory/form.category') </label>
                            <div class="col-sm-4">
                                <select class="form-control" title="Select Status..." name="category_id">
                                    @foreach ($categories as $category)
                                        <option value={{ $category->id }} @if ($category->id === $subcategory->category_id) selected="selected" @endif >{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ URL::to('admin/subcategory/') }}">
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