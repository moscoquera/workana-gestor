<!-- select2 -->
<div clas="col-md-12">

    <?php $entity_model = $crud->model; ?>
    <select
            ng-model="item.{{ $field['name'] }}"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2'])
    >
        <option value="">-</option>

        @if (isset($field['options']))
            @foreach ($field['options'] as $item)
                <option value="{{ $item['id'] }}"
                >{{ $item['label'] }}</option>
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}