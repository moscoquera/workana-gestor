<div class="">
    <div class="form-group">
        <label class="control-label">Idioma:</label>
        <select select2
                ng-model="item.proficency.language_id"
                convert-number
                @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2'])

        >
            <option ng-selected="type.id == item.language_id" ng-repeat="type in language_id_fields" value="<%type.id%>"><% {{ 'type.name' }} %></option>

        </select>
    </div>

    <div class="form-group">
        <label class="control-label">Nivel escrito:</label>
        <select select2
                ng-model="item.proficency.writing"
                convert-number
                @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2'])

        >
            <option ng-selected="type.id == item.proficency.writing" ng-repeat="type in writing_fields" value="<%type.id%>"><% {{ 'type.label' }} %></option>

        </select>
    </div>

    <div class="form-group">
        <label class="control-label">Nivel hablado:</label>
        <select select2
                ng-model="item.proficency.speaking"
                convert-number
                @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2'])

        >
            <option ng-selected="type.id == item.proficency.speaking" ng-repeat="type in speaking_fields" value="<%type.id%>"><% {{ 'type.label' }} %></option>

        </select>
    </div>


</div>