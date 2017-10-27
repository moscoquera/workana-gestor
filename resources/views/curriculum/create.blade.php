@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::crud.add') }} <span>{{ $crud->entity_name }}</span>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
            <li class="active">{{ trans('backpack::crud.edit') }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            @if ($crud->hasAccess('list'))
                <a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a><br><br>
            @endif

            @include('crud::inc.grouped_errors')
            {!! Form::open(array('url' => $crud->route, 'method' => 'put', 'files'=>$crud->hasUploadFields('create'))) !!}
            @if ($crud->model->translationEnabled())
                <input type="hidden" name="locale" value={{ $crud->request->input('locale')?$crud->request->input('locale'):App::getLocale() }}>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <!-- <h3 class="box-title">Otros</h3> -->
                        </div>
                        <div class="box-body">
                            @include('crud::inc.form_save_buttons')
                        </div>
                    </div>
                </div>
            </div>

            @foreach($crud->layouts as $row)
                <div class="row">
                    @foreach($row as $column)
                        <div class="col-sm-{{$column['size']}}">
                            @foreach($column['boxes'] as $box)
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">{{$box['title']}}</h3>
                                    </div>
                                    <div class="box-body">
                                    @foreach ($fields as $field)
                                        @if(isset($field['box']) && $field['box']==$box['name'])
                                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                                                @if(view()->exists('vendor.backpack.crud.fields.'.$field['type']))
                                                    @include('vendor.backpack.crud.fields.'.$field['type'], array('field' => $field))
                                                @else
                                                    @include('crud::fields.'.$field['type'], array('field' => $field))
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <!-- <h3 class="box-title">Otros</h3> -->
                        </div>
                        <div class="box-body">
                        @foreach ($fields as $field)
                            @if(!isset($field['box']))
                                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                                    @if(view()->exists('vendor.backpack.crud.fields.'.$field['type']))
                                        @include('vendor.backpack.crud.fields.'.$field['type'], array('field' => $field))
                                    @else
                                        @include('crud::fields.'.$field['type'], array('field' => $field))
                                    @endif
                                @endif
                            @endforeach

                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-4">
                                    @include('crud::inc.form_save_buttons')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/edit.css') }}">

    <!-- CRUD FORM CONTENT - crud_fields_styles stack -->
    @stack('crud_fields_styles')
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/form.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/edit.js') }}"></script>

    <!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
    @stack('crud_fields_scripts')

    <script>
        jQuery('document').ready(function($){

            // Save button has multiple actions: save and exit, save and edit, save and new
            var saveActions = $('#saveActions'),
                crudForm        = saveActions.parents('form'),
                saveActionField = $('[name="save_action"]');

            saveActions.on('click', '.dropdown-menu a', function(){
                var saveAction = $(this).data('value');
                saveActionField.val( saveAction );
                crudForm.submit();
            });

            // Ctrl+S and Cmd+S trigger Save button click
            $(document).keydown(function(e) {
                if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
                {
                    e.preventDefault();
                    // alert("Ctrl-s pressed");
                    $("button[type=submit]").trigger('click');
                    return false;
                }
                return true;
            });

            // Place the focus on the first element in the form
            @if( $crud->autoFocusOnFirstField )
                    @php
                        $focusField = array_first($fields, function($field) {
                            return isset($field['auto_focus']) && $field['auto_focus'] == true;
                        });
                    @endphp

                    @if ($focusField)
                window.focusField = $('[name="{{ $focusField['name'] }}"]').eq(0),
                    @else
            var focusField = $('form').find('input, textarea, select').not('[type="hidden"]').eq(0),
                    @endif

                    fieldOffset = focusField.offset().top,
                scrollTolerance = $(window).height() / 2;

            focusField.trigger('focus');

            if( fieldOffset > scrollTolerance ){
                $('html, body').animate({scrollTop: (fieldOffset - 30)});
            }
            @endif

            // Add inline errors to the DOM
            @if ($crud->inlineErrorsEnabled() && $errors->any())

                window.errors = {!! json_encode($errors->messages()) !!};
            // console.error(window.errors);

            $.each(errors, function(property, messages){

                var field = $('[name="' + property + '[]"]').length ?
                    $('[name="' + property + '[]"]') :
                    $('[name="' + property + '"]'),
                    container = field.parents('.form-group');

                console.log(field);

                container.addClass('has-error');

                $.each(messages, function(key, msg){
                    // highlight the input that errored
                    var row = $('<div class="help-block">' + msg + '</div>');
                    row.appendTo(container);

                    // highlight its parent tab
                            @if ($crud->tabsEnabled())
                    var tab_id = $(container).parent().attr('id');
                    $("#form_tabs [aria-controls="+tab_id+"]").addClass('text-red');
                    @endif
                });
            });

            @endif

        });
    </script>
@endsection