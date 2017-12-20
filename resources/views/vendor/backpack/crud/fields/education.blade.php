<div class="">
    <div class="form-group">
        <label class="control-label">Título</label>
        <ui-select ng-model="item.profession_id"
                   style="width: 100%;"
                   title="Título" on-select="educationUpdate($item, $model,item,$scope)">
            <ui-select-match placeholder="Seleccione un título"><% $select.selected.name %></ui-select-match>
            <ui-select-choices repeat="type.id as type in profession_id_fields">
                <div ng-bind-html="type.name"></div>
            </ui-select-choices>
        </ui-select>
    </div>

    <div class="form-group">
        <label class="control-label">Tipo:</label>
        <select ui-select2
                ng-model="item.type_id"
                convert-number
                disabled
                @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2'])

        >
            <option ng-selected="type.id == item.type_id" ng-repeat="type in type_id_fields" value="<%type.id%>"><% {{ 'type.name' }} %></option>

        </select>
    </div>


    <div class="form-group">
        <label class="control-label">Institución</label>
        <ui-select ng-model="item.educational_institution_id"
                   style="width: 100%;"
                   title="Institución" on-select="institutionUpdate($item, $model,item)">
            <ui-select-match placeholder="Seleccione una institución..."><% $select.selected.name %></ui-select-match>
            <ui-select-choices repeat="type.id as type in educational_institution_id_fields">
                <div ng-bind-html="type.name"></div>
            </ui-select-choices>
        </ui-select>


    </div>

    <div class="form-group">
        <label class="control-label">Departamento</label>
        <input ng-model="item.department_name" disabled="disabled" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">Ciudad</label>
        <input ng-model="item.city_name" disabled="disabled" class="form-control" />
    </div>


    <div class="form-group" @include('crud::inc.field_wrapper_attributes') >
        <label class="control-label">Fecha de finalización</label>
        <input type="hidden" datetimez ng-model="item.{{isset($super['child_pivot'])?$super['child_pivot'].'.':''}}completion_year">
        @include('crud::inc.field_translatable_icon')
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

        {{-- HINT --}}
        @if (isset($field['hint']))
            <p class="help-block">{!! $field['hint'] !!}</p>
        @endif
    </div>




</div>