<div class="row">
    <div class="col-xs-3 col-xs-offset-1">
        <img class="img-rounded img-responsive" src="{{ url(Storage::url($curriculum->user->photo)) }}">
    </div>
    <div class="col-xs-6 form-horizontal">
        <h3>{{ $curriculum->user->full_name }}</h3>
        <h5>{{ $curriculum->profession->name }}</h5>
        <hr/>
        <h4 class="text-light-blue">Contacto</h4>
        <p>
            <strong>Email: </strong>{{$curriculum->user->email}}<br>
            <strong>Teléfonos: </strong>{{ $curriculum->phone }}, {{ $curriculum->mobile }}<br>

        </p>
        <strong>Dirección: </strong>
        <div style="display: inline-block; vertical-align: top">
            {{ $curriculum->current_address  }}<br>
            {{ trim($curriculum->currentcity->name.', '.$curriculum->currentdepartment->name) }}<br>
            {{ $curriculum->currentcountry->name }}<br>
        </div>
        <hr/>
        <h4 class="text-light-blue">Información personal</h4>
        <strong>Genero: </strong>{{ $curriculum->genre }}<br>
        <strong>Fecha de
            nacimiento: </strong><?php setlocale(LC_TIME, 'es_CO'); echo \Carbon\Carbon::parse($curriculum->date_of_birth)->formatLocalized('%d - %B - %Y'); ?>
        <br>
        <strong>Número de documento: </strong> {{ $curriculum->document }}<br>

        <hr/>

        <h4 class="text-light-blue">Habilidades:</h4>
        <ul style="display: inline-block; vertical-align: top">
            @foreach( $curriculum->skills as $skill)
                <li>{{$skill->name}}</li>
            @endforeach
        </ul>

        <hr/>
        <h4 class="text-light-blue">Resumen:</h4>
        <p class="form-control-static">{{ $curriculum->resume }}</p>

        <hr/>
        @if($curriculum->languages && sizeof($curriculum->languages)>0)
            <h4 class="text-light-blue">Idiomas:</h4>
            <div>
                <ul>
                    @foreach( $curriculum->languages as $language)
                        <li>
                            <strong>{{$language->name}}: </strong><br>
                            Escrito: {{$language->proficency->writing_label}}
                            Hablado: {{$language->proficency->speaking_label}}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</div>

<div class="row" style="margin-top: 20px">
    <div class="col-xs-offset-1 col-xs-11">

        <div class="panel-group" id="detailsGroup">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="panel-title {{isset($show)?'':'collapsed'}}" role="button" data-toggle="collapse"
                        data-parent="#detailsGroup" href="#details">Detalles:</h3>
                </div>
                <div id="details" class="{{ isset($show)?'':'panel-collapse collapse'}}">
                    <strong>Lugar de nacimmiento: </strong>
                        <div style="display: inline-block; vertical-align: top">
                            <address>
                                {{ trim($curriculum->birthcity->name.', '.$curriculum->birthdepartment->name) }}
                                <br>
                                {{ $curriculum->nationality->name }}<br>
                            </address>
                        </div>
                        <br/>
                        <strong>Empresa:  </strong><span>{{ $curriculum->company->name }}</span>




                        @if($curriculum->educations && sizeof($curriculum->educations)>0)
                            <hr/>
                            <h4 class="text-light-blue">Estudios:</h4>
                            <div>
                                <ul>
                                    @foreach( $curriculum->educations as $education)
                                        <li>
                                            <p>{{$education->course_name}}<br>
                                                {{$education->institution}}<br>
                                                {{ Carbon\Carbon::parse($education->completion_year)->format('Y/m/d') }}
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        @endif


                        @if($curriculum->experiences && sizeof($curriculum->experiences)>0)
                            <hr/>
                            <h4 class="text-light-blue">Experiencia laboral:</h4>
                            <div>
                                <ul>
                                    @foreach( $curriculum->experiences as $experience)
                                        <li>
                                            <p>
                                                <strong>{{$experience->company}}</strong><br>
                                                <strong>Jefe inmediato: </strong>{{$experience->boss}}<br>
                                                <strong>Teléfono: </strong>{{ $experience->phone }}<br>
                                                <strong>Periodo: </strong> {{ $experience->start_date?\Carbon\Carbon::parse($experience->start_date)->format('(Y/m/d)'):'-' }}
                                                a {{ $experience->end_date?\Carbon\Carbon::parse($experience->end_date)->format('(Y/m/d)'):'-' }}
                                                <br>
                                                <strong>Motivo del retiro: </strong>{{$experience->retirement}}
                                                <br>
                                                <strong>Funciones a
                                                    cargo: </strong>{{ $experience->functions_in_charge }}
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif



                        @if($curriculum->personal_references && sizeof($curriculum->personal_references)>0)
                            <hr/>
                            <h4 class="text-light-blue">Referecias personales:</h4>
                            <div>
                                <ul>
                                    @foreach( $curriculum->personal_references as $reference)
                                        <li>
                                            <span>
                                                <strong>Nombre:</strong> {{$reference->fullname}}<br>
                                                <strong>Profesión:</strong> {{ $reference->profession }}<br>
                                                <strong>teléfono:</strong> {{$reference->phone}}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($curriculum->familiar_references && sizeof($curriculum->familiar_references)>0)
                            <hr/>
                            <h4 class="text-light-blue">Referecias familiares:</h4>
                            <div>
                                <ul>
                                    @foreach( $curriculum->familiar_references as $reference)
                                        <li>
                                            <span>
                                                <strong>Nombre:</strong> {{$reference->fullname}}<br>
                                                <strong>Profesión:</strong> {{ $reference->profession }}<br>
                                                <strong>teléfono:</strong> {{$reference->phone}}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                </div>
            </div>
        </div>

    </div>
</div>
