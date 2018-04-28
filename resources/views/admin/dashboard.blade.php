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


    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Resumen votos</h3>
                </div>
                <div class="box-body">
                    <form id="search" class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Año lectivo</label>
                                    <div class="col-sm-6">
                                        <input id="year" class="form-control"
                                               data-provide="datepicker" data-date-format="yyyy"
                                               data-date-min-view-mode="years"
                                               data-date-view-mode="years"
                                                value="{{ date('Y') }}"
                                        />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Departamento</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="departments" >
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}">{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Municipios</label>
                                    <div class="col-sm-8">
                                        <span class="text-muted">Dejar en blanco para buscar en todos los municipios</span>
                                        <select class="form-control" id="cities" name="cities" >
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Líder</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" id="leaders" >
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Candidato</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" id="candidate" >
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-primary btn-lg" >Filtrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active">
                    <a href="#city" role="tab" data-toggle="tab" aria-controls="#city">Por ciudad</a>
                </li>
                <li role="presentation" class="">
                    <a href="#leader" role="tab" data-toggle="tab" aria-controls="#leader">Por líder</a>
                </li>
                <li role="presentation" class="">
                    <a href="#candidatetab" role="tab" data-toggle="tab" aria-controls="#candidatetab">Por candidato</a>
                </li>
            </ul>
            <div class="tab-content box box-body">
                <div role="tabpanel" class="tab-pane active" id="city">
                    <div class="row">
                        <div class="col-md-6">
                            {!!  $tables['cities']->table() !!}
                        </div>
                        <div class="col-md-6">
                            <div id="chartCity" style="height: 400px">

                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="leader">
                    <div class="row">
                        <div class="col-md-12">
                            {!!  $tables['leaders']->table() !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="chartLeader" style="width:80%">

                            </div>
                        </div>
                    </div>


                </div>
                <div role="tabpanel" class="tab-pane" id="candidatetab">
                    <div class="row">
                        <div class="col-md-12">
                            {!!  $tables['candidates']->table() !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="chartCandidate" style="width:80%">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('after_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" />

    {!! Charts::styles() !!}
@endsection

@section('after_scripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    {!! Charts::scripts() !!}

    <script>

        $('#year').on('change',function(e){
            $('#election').val(null).trigger('change');
        });

        $('#departments').select2({
            theme:'bootstrap'
        });
        $('#departments').on('change',function(e){
            $('#cities').val(null).trigger('change');
        });

        $('#cities').select2({
            theme: 'bootstrap',
            multiple: true,
            placeholder: "Municipio",
            minimumInputLength: 0,
            allowClear: true,
            ajax: {
                url: "{{ url('api/city') }}",
                dataType: 'json',
                quietMillis: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        linked:$('#departments').val()
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    var result = {
                        results: $.map(data.data, function (item) {
                            textField = "name";
                            return {
                                text: item[textField],
                                id: item["id"]
                            }
                        }),
                        more: data.current_page < data.last_page
                    };

                    return result;
                },
                cache: true
            },
        });



        $('#leaders').select2({
            theme: 'bootstrap',
            multiple: false,
            placeholder: "Líder",
            minimumInputLength: 0,
            allowClear: true,
            ajax: {
                url: "{{ url('ajax/users') }}",
                dataType: 'json',
                quietMillis: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    var result = {
                        results: $.map(data.data, function (item) {
                            textField = "fullname";
                            return {
                                text: item[textField],
                                id: item["id"]
                            }
                        }),
                        more: data.current_page < data.last_page
                    };

                    return result;
                },
                cache: true
            },
        });

        $('#election').select2({
            theme: 'bootstrap',
            multiple: false,
            placeholder: "Comicio",
            minimumInputLength: 0,
            allowClear: true,
            ajax: {
                url: "{{ url('ajax/elections') }}",
                dataType: 'json',
                quietMillis: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        linked:$('#year').val()
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    var result = {
                        results: $.map(data.data, function (item) {
                            textField = "name";
                            return {
                                text: item[textField],
                                id: item["id"]
                            }
                        }),
                        more: data.current_page < data.last_page
                    };

                    return result;
                },
                cache: true
            },
        });

        $('#election').on('change',function (e) {
            $('#candidate').val(null).trigger('change');
        });

        $('#candidate').select2({
            theme: 'bootstrap',
            multiple: false,
            placeholder: "Candidato",
            minimumInputLength: 0,
            allowClear: true,
            ajax: {
                url: "{{ url('ajax/election/candidate') }}",
                dataType: 'json',
                quietMillis: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        linked:$('#election').val()
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    var result = {
                        results: $.map(data.data, function (item) {
                            textField = "name";
                            return {
                                text: item[textField],
                                id: item["id"]
                            }
                        }),
                        more: data.current_page < data.last_page
                    };

                    return result;
                },
                cache: true
            },
        });


        $('#search').on('submit', function(e) {
            e.preventDefault();
            window.LaravelDataTables["dtCity"].draw();
            window.LaravelDataTables["dtLeaders"].draw();
            window.LaravelDataTables["dtCandidates"].draw();
            updateCharts();

        });


    </script>

    {!!  $tables['cities']->scripts() !!}
    {!!  $tables['leaders']->scripts() !!}
    {!!  $tables['candidates']->scripts() !!}

    <script type="text/javascript">
        var chartCity=undefined;
        var chartLeader=undefined;
        $(function () {
            chartCity = new Highcharts.Chart({
                chart: {
                    renderTo: "chartCity",
                    height: 400,

                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                tooltip: {
                    pointFormat: '{point.y} <b>({point.percentage:.1f}%)</strong>'
                },
                title: {
                    text:  "Votos",
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</strong>: {point.y} ({point.percentage:.1f}%)',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                colors: [
                    "#2196F3",
                    "#F44336",
                    "#FFC107",
                ],
                legend: {
                },
                series: [],
                loading: {
                    showDuration: 250,
                    hideDuration: 250,
                    labelStyle: { "position": "relative", "top": "45%", "font-family": "sans-serif" },
                },
                lang: {
                    loading: "cargando..."
                }
            });

            chartLeader = new Highcharts.Chart({
                chart: {
                    renderTo: "chartLeader",
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'bar'
                },
                title: {
                    text:  "Votos",
                },
                credits: {
                    enabled: false
                },
                colors: [
                    "#2196F3",
                    "#F44336",
                    "#FFC107",
                    "#5cf442"
                ],
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: true
                },
                series: [],
                loading: {
                    showDuration: 250,
                    hideDuration: 250,
                    labelStyle: { "position": "relative", "top": "45%", "font-family": "sans-serif" },
                },
                lang: {
                    loading: "cargando..."
                },
                xAxis:{
                    categories:[],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Votos',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },

                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                }
            });


            chartCity.showLoading();
            chartLeader.showLoading();
            updateCharts();
        });


        function updateCharts() {

            $.ajax({
                url: "{{route('api.election.results.city')}}",
                type: "GET",
                dataType: "json",
                data : {
                    year : $('#year').val(),
                    department : $('#departments').val(),
                    city : $('#cities').val(),
                    leader : $('#leaders').val(),
                    election : $('#election').val(),
                    candidate : $('#candidate').val(),
                    chart : true,
                },
                success: function(data) {
                    chartCity.hideLoading();
                    var chartCity_values = data.values;
                    var chartCity_labels = data.labels;
                    var chartCity_new_values = [];
                    for (var i = 0; chartCity_labels.length > i; i++) {
                        chartCity_new_values.push({
                            name: chartCity_labels[i],
                            y: parseFloat(chartCity_values[i])
                        });
                    }
                    while(chartCity.series.length > 0)
                        chartCity.series[0].remove(true);

                    chartCity.addSeries({
                        colorByPoint: true,
                        data: chartCity_new_values,
                    });
                },
                cache: false
            });


            $.ajax({
                url: "{{route('api.election.results.leader')}}",
                type: "GET",
                dataType: "json",
                data : {
                    year : $('#year').val(),
                    department : $('#departments').val(),
                    city : $('#cities').val(),
                    leader : $('#leaders').val(),
                    election : $('#election').val(),
                    candidate : $('#candidate').val(),
                    chart : true,
                },
                success: function(data) {
                    chartLeader.hideLoading();


                    chartLeader.xAxis[0].categories=data.categories;

                    while(chartLeader.series.length > 0)
                        chartLeader.series[0].remove(true);

                    for(var i=0;i<data.series.length;i++){
                        chartLeader.addSeries(data.series[i]);
                    }
                },
                cache: false
            });

        }

    </script>

@endsection
