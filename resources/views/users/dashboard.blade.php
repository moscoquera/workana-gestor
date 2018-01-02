<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 12/4/17
 * Time: 11:59 AM
 */

?>

@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::base.dashboard') }} : {{ $user->fullname }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/users') }}">usuarios</a></li>
            <li><a >{{ $user->fullname }}</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol>
    </section>
@endsection


@section('after_styles')
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.css"/>
    {!! Charts::styles() !!}
@endsection

@section('after_scripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.js"></script>
    {!! $tables['visits']->scripts() !!}
    {!! $tables['events']->scripts() !!}
    {!! Charts::scripts() !!}
    {!! $charts['event_attendance']->script() !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="#" class="thumbnail">
                                <img src="{{ ($user->photo)?url('storage/'.$user->photo):url('storage/images/no-photo.png') }}">
                            </a>
                        </div>
                        <div class="col-md-8">
                            <h3>{{ $user->fullname }}</h3>
                            <p>
                                <strong>Profesión:</strong> {{  ($user->profession)?$user->profession->name:'' }}
                                <br/>
                                <strong>Edad: </strong> {{ $user->age }}
                                <br/>
                                <strong>Perfíl: </strong> {{ ($user->level)?$user->level->name:'' }}
                                <hr/>
                                <strong>Total visitas:</strong> {{ $user->visits()->count() }}
                                <br/>
                                <strong>Total eventos invitado como asistente:</strong> {{ $user->attendanceToEvents()->count() }}
                                <br/>
                                <strong>Total eventos a los que asistió:</strong> {{ $user->attendanceToEvents()->where('attended',1)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                </div>
                <div class="box-body">
                    {!! $charts['event_attendance']->html() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">HISTORICO DE VISITAS</h3>
                </div>
                <div class="box-body">
                    {!! $tables['visits']->table() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">HISTORICO ASISTENCIA A EVENTOS</h3>
                </div>
                <div class="box-body">
                    {!! $tables['events']->table() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
