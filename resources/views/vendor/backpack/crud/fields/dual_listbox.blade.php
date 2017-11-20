<div
        @include('crud::inc.field_wrapper_attributes')
>

    <h3>{!! $field['label'] !!}</h3>
    @include('crud::inc.field_translatable_icon')

    <select multiple="multiple" size="10" name="{{ $field['name'] }}[]">
        @foreach($field['source'] as $source_type)
            @foreach ($source_type['model']::all() as $connected_entity_entry)
                <option value="{{$source_type['slug']}}_{{ $connected_entity_entry->getKey() }}">
                    {{$source_type['preffix']}}{{ $connected_entity_entry->{$source_type['attribute']} }}{{$source_type['suffix']}}
                </option>
            @endforeach
        @endforeach
    </select>
</div>




{{-- FIELD JS - will be loaded in the after_scripts section --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    @push('crud_fields_styles')
        <link rel="stylesheet" href="{{ url('css/bootstrap-duallistbox.min.css') }}">
    @endpush

    @push('crud_fields_scripts')
        <script src="{{ url('js/jquery.bootstrap-duallistbox.min.js') }}"></script>
    @endpush
@endif

@push('crud_fields_scripts')
    <script type="text/javascript">

        jQuery(document).ready(function($){
            var dlname="{{ $field['name'] }}[]";
            var dl = $('select[name="'+dlname+'"]').bootstrapDualListbox(
                @if(isset($field['dual_settings']))
                {!! json_encode($field['dual_settings']) !!}
                @endif
            );
        });
    </script>

@endpush

