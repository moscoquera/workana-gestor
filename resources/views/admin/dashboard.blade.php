@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-3">
            <div  class="info-box">
                <span class="info-box-icon bg-yellow">
                    <i class="fa fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Usuarios:</span>
                    <span class="info-box-number">{{ \App\Models\PublicUser::count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h5 class="box-title">Contratos</h5>
                </div>
                <div class="box-body">
                    <div class="progress-group">
                        <span class="progress-text">Por iniciar:</span>
                        <span class="progress-number"><?= $contracts['nostarted'] ?>/<?= $contracts['all'] ?></span>
                        <div class="progress progress-sm">
                            <div class="progress progress-bar progress-bar-info"
                                 role="progressbar" aria-valuenow="<?= $contracts['nostarted'] ?>" aria-valuemin="0"
                                 style="width: <?= ($contracts['nostarted']/($contracts['all']?$contracts['all']:1))*100 ?>%"
                                 aria-valuemax="<?= $contracts['all'] ?>">

                            </div>
                        </div>
                    </div>

                    <div class="progress-group">
                        <span class="progress-text">En ejecución:</span>
                        <span class="progress-number"><?= $contracts['active'] ?>/<?= $contracts['all'] ?></span>
                        <div class="progress progress-sm">
                            <div class="progress progress-bar progress-bar-green"
                                 role="progressbar" aria-valuenow="<?= $contracts['active'] ?>" aria-valuemin="0"
                                 style="width: <?= ($contracts['active']/($contracts['all']?$contracts['all']:1))*100 ?>%"
                                 aria-valuemax="<?= $contracts['all'] ?>">

                            </div>
                        </div>
                    </div>

                    <div class="progress-group">
                        <span class="progress-text">Finalizados:</span>
                        <span class="progress-number"><?= $contracts['ended'] ?>/<?= $contracts['all'] ?></span>
                        <div class="progress progress-sm">
                            <div class="progress progress-bar progress-bar-danger"
                                 role="progressbar" aria-valuenow="<?= $contracts['ended'] ?>" aria-valuemin="0"
                                 style="width: <?= ($contracts['ended']/($contracts['all']?$contracts['all']:1))*100 ?>%"
                                 aria-valuemax="<?= $contracts['all'] ?>">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
