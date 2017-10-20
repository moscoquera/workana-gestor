<div class="">
    <div class="form-group">
        <label class="control-label">Empresa:</label>
            <input
                    type="text"
                    ng-model="item.company"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

            >
    </div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label class="control-label">Nombre del jefe inmediato:</label>
            <input
                        type="text"
                        ng-model="item.boss"
                        @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

                >
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="control-label">Teléfono:</label>
                <input
                        type="text"
                        ng-model="item.phone"
                        @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

                >
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label">Fecha de ingreso:</label>

                    <input type="hidden" datetimez ng-model="item.start_date">
                    <div class="input-group date">
                        <input
                                data-bs-datepicker="{{ isset($field['date_picker_options']) ? json_encode($field['date_picker_options']) : '{}'}}"
                                type="text"
                                @include('crud::inc.field_attributes')
                        >
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>

                </div>

            </div>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label class="control-label">salida:</label>
                    <input type="hidden" datetimez ng-model="item.end_date">
                    <div class="input-group date">
                        <input
                                data-bs-datepicker="{{ isset($field['date_picker_options']) ? json_encode($field['date_picker_options']) : '{}'}}"
                                type="text"
                                @include('crud::inc.field_attributes')
                        >
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                    </div>

                </div>
        </div>
    </div>


    <div class="form-group">
        <label class="control-label">Motivo del retiro:</label>

            <textarea
                    ng-model="item.retirement"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

            ></textarea>

    </div>

    <div class="form-group">
        <label class="control-label">Funciones a cargo:</label>

            <textarea
                    ng-model="item.functions_in_charge"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

            ></textarea>

    </div>

</div>