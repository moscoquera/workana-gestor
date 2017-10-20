@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Buscar profesionales
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
            <li class="active">buscar</li>
        </ol>
    </section>
@endsection

<?php

        if (isset($professions)){
            $professions=$professions->keyBy('id');
        }


?>

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <i class="fa fa-search"></i> <span>Buscar:</span>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="control-group">
                                <label class="control-label col-sm-2">Profesión</label>
                                <div class="col-sm-8">
                                    <select
                                            name="professions[]"
                                            style="width: 100%"
                                            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_multiple'])
                                            multiple>
                                            @foreach (\App\Models\Profession::all() as $profession)
                                                <option value="{{ $profession->getKey() }}"
                                                        @if ( (request('professions') && in_array($profession->getKey(), request('professions'))) || ( old('professions') && in_array($profession->getKey(), old('professions')) ) )
                                                        selected
                                                        @endif
                                                >{{ $profession->name }}</option>
                                            @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="control-group">
                                <label class="control-label col-sm-2">Con contrato:</label>
                                <div class="col-sm-1">
                                    <label class="switch-light" onclick="">
                                        <input type="checkbox" {{ old('hired')?'checked':'' }} name="hired">

                                        <span class="alert alert-light">
                                        <span>No</span>
                                        <span>Si</span>
                                        <a class="btn btn-primary"></a>
                                      </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="col-sm-offset-6">
                                <input type="submit" class="btn btn-success btn-lg" value="Buscar" />
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @if(isset($users))
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Resultados</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>ID</th>
                            <th>Nombre completo</th>
                            <th>Profession</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->user_id }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $professions[$user->profession_id]->name }}</td>
                                    <td>
                                        <a class="btn btn-primary" target="_blank" href="{{ url(config('backpack.base.route_prefix')).'/curriculum/'.$user->id }}">Ver curriculum</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    @endif

@endsection



    {{-- FIELD CSS - will be loaded in the after_styles section --}}
@section('after_styles')
    <!-- include select2 css-->
    <link href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@section('after_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('vendor/adminlte/plugins/select2/select2.min.js') }}"></script>
    <script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2_multiple box
            $('.select2_multiple').each(function (i, obj) {
                if (!$(obj).hasClass("select2-hidden-accessible"))
                {
                    $(obj).select2({
                        theme: "bootstrap"
                    });
                }
            });
        });
    </script>
@endsection

