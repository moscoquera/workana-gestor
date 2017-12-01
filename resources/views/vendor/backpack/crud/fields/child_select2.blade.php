<!-- select2 -->
<div clas="col-md-12">

    <?php $entity_model = $crud->model; ?>


        <ui-select
                ng-model="item.{{isset($super['child_pivot'])?$super['child_pivot'].'.':''}}{{ $field['name'] }}"
                theme="bootstrap"
                style="min-width: 300px;"
                title="Seleccione una persona">
            <ui-select-match placeholder="Seleccione a una persona de a lista"><%$select.selected.{{$field['attribute'] }}%></ui-select-match>
            <ui-select-choices repeat="type.id as type in {{$field['name']}}_fields | propsFilter: {fullname: $select.search}">
                <div ng-bind-html="{{ 'type.'.$field['attribute'] }} | highlight: $select.search"></div>
            </ui-select-choices>
        </ui-select>



        {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if (!$crud->child_resource_included['select'])

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include select2 css-->
        <link href="{{ asset('vendor/backpack/select2/select2.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/backpack/select2/select2-bootstrap-dick.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="{{ asset('vendor/backpack/select2/select2.js') }}"></script>
    @endpush


    <?php $crud->child_resource_included['select'] = true; ?>
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}