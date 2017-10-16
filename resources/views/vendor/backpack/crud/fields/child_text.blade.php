<!-- select2 -->
<div clas="col-md-12">

    <?php $entity_model = $crud->model; ?>

        <input
                type="text"
                ng-model="item.{{isset($super['child_pivot'])?$super['child_pivot'].'.':''}}{{ $field['name'] }}"
                @include('crud::inc.field_attributes', ['default_class' =>  'form-control'])

        >


        @if (isset($field['model']))
            @foreach ($field['model']::all() as $connected_entity_entry)
                <option value="{{ $connected_entity_entry->getKey() }}"
                >{{ $connected_entity_entry->{$field['attribute']} }}</option>
            @endforeach
        @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}