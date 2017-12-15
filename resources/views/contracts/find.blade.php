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
                            <div class="form-group">
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
                            <div class="form-group">
                                <label class="control-label col-sm-2">Habilidades</label>
                                <div class="col-sm-8">
                                    <select
                                            name="skills[]"
                                            style="width: 100%"
                                            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_multiple'])
                                            multiple>
                                        @foreach (\App\Models\Skill::all() as $skill)
                                            <option value="{{ $skill->getKey() }}"
                                                    @if ( (request('skills') && in_array($skill->getKey(), request('skills'))) || ( old('skills') && in_array($skill->getKey(), old('skills')) ) )
                                                    selected
                                                    @endif
                                            >{{ $skill->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Entidades donde ha trabajado:</label>
                                <div class="col-sm-8">
                                    <select
                                            name="companies[]"
                                            style="width: 100%"
                                            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_multiple'])
                                            multiple>
                                        @foreach (\App\Models\Company::all() as $company)
                                            <option value="{{ $company->getKey() }}"
                                                    @if ( (request('companies') && in_array($company->getKey(), request('companies'))) || ( old('companies') && in_array($company->getKey(), old('companies')) ) )
                                                    selected
                                                    @endif
                                            >{{ $company->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Nivel educativo:</label>
                                <div class="col-sm-8">
                                    <select
                                            name="educations"
                                            style="width: 100%"
                                            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_multiple'])
                                            >
                                        @foreach (\App\Models\Education::all() as $education)
                                            <option value="{{ $education->getKey() }}"
                                                    @if ( (request('educations') && $education->getKey() ==request('educations')) || ( old('educations') && $education->getKey() ==  old('educations') ))
                                                    selected
                                                    @endif
                                            >{{ $education->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Sexo:</label>
                                <div class="col-sm-8">
                                    <select
                                            name="sex"
                                            style="width: 100%"
                                            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_multiple'])
                                            >
                                            <option value="">Calquiera</option>
                                            <option value="f"
                                                    @if ( (request('sex') && request('sex')=='f') || ( old('sex') && old('sex')=='f' ) )
                                                    selected
                                                    @endif
                                            >Femenino</option>

                                        <option value="m"
                                                @if ( (request('sex') && request('sex')=='m') || ( old('sex') && old('sex')=='m' ) )
                                                selected
                                                @endif
                                        >Masculino</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Rango de edad:</label>
                                <div class="col-sm-8">
                                    <b style="margin-right: 30px">18</b>  <input id="ageid" type="text" class="span2" value="<?= old('ages',request('ages','')) ?>" name="ages" data-slider-min="18" data-slider-max="100" data-slider-step="1" data-slider-value="[<?= old('ages',request('ages','18,100')) ?>]"/> <b style="margin-left: 30px">100</b>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Idiomas:</label>
                                <div class="col-sm-8">
                                    <select
                                            name="languages[]"
                                            style="width: 100%"
                                            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_multiple'])
                                            multiple>
                                        @foreach (\App\Models\Language::all() as $language)
                                            <option value="{{ $language->getKey() }}"
                                                    @if ( (request('languages') && in_array($language->getKey(), request('languages'))) || ( old('languages') && in_array($language->getKey(), old('languages')) ) )
                                                    selected
                                                    @endif
                                            >{{ $language->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Municipio de residencia:</label>
                                <div class="col-sm-8">
                                    <select
                                            name="cities[]"
                                            style="width: 100%"
                                            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_multiple'])
                                            multiple>
                                        @foreach (\App\Models\City::with('department')->get() as $city)
                                            <option value="{{ $city->getKey() }}"
                                                    @if ( (request('cities') && in_array($city->getKey(), request('cities'))) || ( old('cities') && in_array($city->getKey(), old('cities')) ) )
                                                    selected
                                                    @endif
                                            >( {{ $city->department->name }} ) - {{ $city->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
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
                        <div class="row">

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
                    <a class="pull-right btn btn-success btn-sm" href="{{ url('contracts/search/export?'.http_build_query($queryArgs)) }}">Exportar</a>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>ID</th>
                            <th>Nombre completo</th>
                            <th>Profession</th>
                            <th>Habilidades</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->user_id }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $professions[$user->curriculum->profession_id]->name }}</td>
                                    <td>
                                        <ul>
                                            @foreach($user->curriculum->skills as $skill)
                                                <li>{{ $skill->name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" target="_blank" href="{{ url(config('backpack.base.route_prefix')).'/curriculum/'.$user->curriculum->id }}">Ver curriculum</a>
                                        <a class="btn btn-success" target="_blank" href="{{ url(config('backpack.base.route_prefix')).'/contracts/create?user='.$user->id }}">Contratar</a>
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

            $("#ageid").slider({});
        });
    </script>
@endsection

