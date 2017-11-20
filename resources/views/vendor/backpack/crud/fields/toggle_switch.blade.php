<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 11/18/17
 * Time: 10:45 AM
 */

?>

<!-- checkbox field -->

<div @include('crud::inc.field_wrapper_attributes') >
    @include('crud::inc.field_translatable_icon')
    <div class="checkbox">
        <label>
            <input type="hidden" name="{{ $field['name'] }}" value="0">
            <input type="checkbox" value="1"
                   data-toggle="toggle"

                   @if(isset($field['switch_labels']))
                        data-on="{{ $field['switch_labels']['on'] }}"
                        data-off="{{ $field['switch_labels']['off'] }}"
                   @endif


                   name="{{ $field['name'] }}"
                        @if (isset($field['value']))
                            @if( ((int) $field['value'] == 1 || old($field['name']) == 1) && old($field['name']) !== '0' )
                                checked="checked"
                            @endif
                        @elseif (isset($field['default']) && $field['default'])
                                checked="checked"
                        @endif
            @if (isset($field['attributes']))
                @foreach ($field['attributes'] as $attribute => $value)
                    {{ $attribute }}="{{ $value }}"
                @endforeach
            @endif
            > {!! $field['label'] !!}
        </label>

        {{-- HINT --}}
        @if (isset($field['hint']))
            <p class="help-block">{!! $field['hint'] !!}</p>
        @endif
    </div>
</div>

@push('crud_fields_styles')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endpush
