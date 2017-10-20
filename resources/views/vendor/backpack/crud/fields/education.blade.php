<div class="">
    <div class="form-group">
        <label class="control-label">Título</label>
        <input type="text" ng-model="item.course_name" @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2']) />
    </div>

    <div class="form-group">
        <label class="control-label">Institución</label>
        <input type="text" ng-model="item.institution" @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2']) />
    </div>

    <div class="form-group">
        <label class="control-label">Tipo:</label>
            <select select2
                    ng-model="item.type_id"
                    convert-number
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2'])

            >
                <option ng-selected="type.id == item.type_id" ng-repeat="type in type_id_fields" value="<%type.id%>"><% {{ 'type.name' }} %></option>

            </select>
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