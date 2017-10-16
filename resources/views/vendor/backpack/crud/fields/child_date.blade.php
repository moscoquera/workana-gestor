<!-- html5 date input -->

<div @include('crud::inc.field_wrapper_attributes') >
    <input type="hidden" datetimez ng-model="item.{{isset($super['child_pivot'])?$super['child_pivot'].'.':''}}{{ $field['name'] }}">
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


