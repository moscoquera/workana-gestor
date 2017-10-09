<div class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-sm-2">Empresa:</label>
        <div class="col-sm-10">
            <input
                    type="text"
                    ng-model="item.company"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

            >
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-sm-2">Nombre del jefe inmediato:</label>
        <div class="col-sm-4">
            <input
                    type="text"
                    ng-model="item.boss"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

            >
        </div>

        <label class="control-label col-sm-1">Teléfono:</label>
        <div class="col-sm-4">
            <input
                    type="text"
                    ng-model="item.phone"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

            >
        </div>

    </div>



    <div class="form-group">
        <label class="control-label col-sm-2">Fecha de ingreso:</label>
        <div class="col-sm-3">
            <input
                    type="date"
                    ng-model="item.start_date"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

            >
        </div>

        <label class="control-label col-sm-1">salida:</label>
        <div class="col-sm-3">
            <input
                    type="date"
                    ng-model="item.end_date"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

            >
        </div>

    </div>



    <div class="form-group">
        <label class="control-label col-sm-2">Motivo del retiro:</label>
        <div class="col-sm-10">
            <input
                    type="text"
                    ng-model="item.retirement"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

            >
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">Funciones a cargo:</label>
        <div class="col-sm-10">
            <input
                    type="text"
                    ng-model="item.functions_in_charge"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

            >
        </div>
    </div>

</div>