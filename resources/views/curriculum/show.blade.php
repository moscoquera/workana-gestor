@extends('backpack::layout')

@section('content-header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::crud.preview') }} <span class="text-lowercase">Curriculum</span>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li class="active">{{ trans('backpack::crud.preview') }}</li>
        </ol>
    </section>
@endsection

@section('content')

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <span class="text-lowercase">Curriculum: {{ $curriculum->user->full_name }}</span>
            </h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-offset-9 col-md-3">
                    <a class="btn btn-default" href="{{ Auth::user()->isAdmin()?url(config('backpack.base.route_prefix', 'admin').'/curriculums'):url('') }}"><i class="fa fa-arrow-left"></i>Volver</a>
                    <a class="btn btn-success" target="_blank" href="{{ url($crud->route.'/'.$curriculum->id.'/export') }}"><i class="fa fa-file-pdf-o"></i>Exportar</a>
                </div>
            </div>
            @include('curriculum.layout')
        </div><!-- /.box-body -->
    </div><!-- /.box -->

@endsection


@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/show.js') }}"></script>
    <script>
        //$('.collapse').
    </script>
@endsection
