<div class="row">
    <div class="col-xs-3 col-xs-offset-1">
        <img class="img-rounded img-responsive" src="{{ url(Storage::url($curriculum->user->photo)) }}">
    </div>
    <div class="col-xs-6 form-horizontal" >
        <h3>{{ $curriculum->user->full_name }}</h3>
        <div class="form-group">
            <label class="col-xs-4 control-label">Email:</label>
            <div class="col-xs-5" >
                <p class="form-control-static">{{$curriculum->user->email}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-4 control-label">Número de documento:</label>
            <div class="col-xs-8">
                <p class="form-control-static">{{ $curriculum->document }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-4 control-label">Genero:</label>
            <div class="col-xs-8">
                <p class="form-control-static">{{ $curriculum->genre }}</p>
            </div>
        </div>


        <div class="form-group">
            <label class="col-xs-4 control-label">Fecha de nacimiento:</label>
            <div class="col-xs-8">
                <p class="form-control-static"><?php setlocale(LC_TIME, 'es_CO'); echo \Carbon\Carbon::parse($curriculum->date_of_birth)->formatLocalized('%d - %B - %Y'); ?></p>
            </div>
        </div>


        <div class="form-group">
            <label class="col-xs-4 control-label">Profesión:</label>
            <div class="col-xs-8">
                <p class="form-control-static">{{ $curriculum->profession->name }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-4 control-label">Teléfono fijo:</label>
            <div class="col-xs-8">
                <p class="form-control-static">{{ $curriculum->phone }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-4 control-label">Teléfono celular:</label>
            <div class="col-xs-8">
                <p class="form-control-static">{{ $curriculum->mobile }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-4 control-label">Dirección:</label>
            <div class="col-xs-8">
                <address class="form-control-static">
                    {{ $curriculum->current_address  }}<br/>
                    {{ trim($curriculum->currentcity->name.', '.$curriculum->currentdepartment->name) }}<br/>
                    {{ $curriculum->currentcountry->name }}<br/>
                </address>
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-4 control-label">Habilidades:</label>
            <div class="col-xs-8">
                <div class="form-control-static">
                    <ul>
                        @foreach( $curriculum->skills as $skill)
                            <li>{{$skill->name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row" style="margin-top: 20px">
    <div class="col-xs-offset-1 col-xs-11">

        <div class="panel-group" id="detailsGroup">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="panel-title collapsed" role="button" data-toggle="collapse" data-parent="#detailsGroup" href="#details">Detalles:</h3>
                </div>
                <div id="details" class="panel-collapse collapse">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-xs-4 control-label">Lugar de nacimmiento:</label>
                            <div class="col-xs-8">
                                <address class="form-control-static">
                                    {{ trim($curriculum->birthcity->name.', '.$curriculum->birthdepartment->name) }}<br/>
                                    {{ $curriculum->nationality->name }}<br/>
                                </address>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-4 control-label">Empresa:</label>
                            <div class="col-xs-8">
                                <p class="form-control-static">{{ $curriculum->company->name }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-4 control-label">Resumen:</label>
                            <div class="col-xs-8">
                                <p class="form-control-static">{{ $curriculum->resume }}</p>
                            </div>
                        </div>

                        @if($curriculum->educations)
                            <div class="form-group">
                                <label class="col-xs-4 control-label">Estudios:</label>
                                <div class="col-xs-8">
                                    <div class="form-control-static">
                                        <ul>
                                            @foreach( $curriculum->educations as $education)
                                                <li>
                                                    <p>{{$education->course_name}}<br/>
                                                        {{$education->institution}}<br/>
                                                        {{ Carbon\Carbon::parse($education->completion_year)->format('Y/m/d') }}
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($curriculum->experiences && sizeof($curriculum->experiences)>0)
                            <div class="form-group">
                                <label class="col-xs-4 control-label">Experiencia:</label>
                                <div class="col-xs-8">
                                    <div class="form-control-static">
                                        <ul>
                                            @foreach( $curriculum->experiences as $experience)
                                                <li>
                                                    <p>
                                                        <strong>{{$experience->company}}</strong><br/>
                                                        <strong>Jefe inmediato: </strong>{{$experience->boss}}<br/>
                                                        <strong>Teléfono: </strong>{{ $experience->phone }}<br/>
                                                        <strong>Periodo: </strong> {{ $experience->start_date?\Carbon\Carbon::parse($experience->start_date)->format('(Y/m/d)'):'-' }} a {{ $experience->end_date?\Carbon\Carbon::parse($experience->end_date)->format('(Y/m/d)'):'-' }}<br/>
                                                        <strong>Motivo del retiro: </strong>{{$experience->retirement}}<br/>
                                                        <strong>Funciones a cargo: </strong>{{ $experience->functions_in_charge }}
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($curriculum->languages)
                            <div class="form-group">
                                <label class="col-xs-4 control-label">Idiomas:</label>
                                <div class="col-xs-8">
                                    <div class="form-control-static">
                                        <ul>
                                            @foreach( $curriculum->languages as $language)
                                                <li>
                                                    <p>{{$language->name}}<br/>
                                                        Escrito: {{$language->proficency->writing_label}}<br/>
                                                        Hablado: {{$language->proficency->speaking_label}}<br/>
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif


                        @if($curriculum->personal_references && sizeof($curriculum->personal_references)>0)
                            <div class="form-group">
                                <label class="col-xs-4 control-label">Referecias personales:</label>
                                <div class="col-xs-8">
                                    <div class="form-control-static">
                                        <ul>
                                            @foreach( $curriculum->personal_references as $reference)
                                                <li>
                                                    <p>
                                                        <strong>Nombre:</strong> {{$reference->fullname}}<br/>
                                                        <strong>Profesión:</strong> {{ $reference->profession }}<br/>
                                                        <strong>teléfono:</strong> {{$reference->phone}}
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($curriculum->familiar_references && sizeof($curriculum->familiar_references)>0)
                            <div class="form-group">
                                <label class="col-xs-4 control-label">Referecias familiares:</label>
                                <div class="col-xs-8">
                                    <div class="form-control-static">
                                        <ul>
                                            @foreach( $curriculum->familiar_references as $reference)
                                                <li>
                                                    <p>
                                                        <strong>Nombre:</strong> {{$reference->fullname}}<br/>
                                                        <strong>Profesión:</strong> {{ $reference->profession }}<br/>
                                                        <strong>teléfono:</strong> {{$reference->phone}}
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
