<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 11/18/17
 * Time: 7:38 PM
 */

?>

<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 11/18/17
 * Time: 7:38 PM
 */

?>
<td>
    <div class="checkbox hidden-print">
        <label>

            <input type="hidden" name="{{ $column['name'] }}" value="0">

            <input data-targetid="{{ $entry->getKey() }}" class="active_toggle" type="checkbox" value="1"
                   data-toggle="toggle"

                   @if(isset($column['switch_labels']))
                   data-on="{{ $column['switch_labels']['on'] }}"
                   data-off="{{ $column['switch_labels']['off'] }}"
                   @endif
                   name="{{ $column['name'] }}"

                   @if (isset($column['value']) && ((int) $field['value'] == 1))
                   checked="checked"
                   @elseif ((int) $entry->{$column['name']} == 1)
                   checked="checked"
            @endif

            @if (isset($field['attributes']))
                @foreach ($field['attributes'] as $attribute => $value)
                    {{ $attribute }}="{{ $value }}"
                @endforeach
            @endif
            >
        </label>
    </div>

    <div class="visible-print-inline-block">
        @if((int) $entry->{$column['name']} == 1)
            {{ $column['switch_labels']['on'] }}
        @else
            {{ $column['switch_labels']['off'] }}
        @endif
    </div>




</td>



@pushonce('crud_list_styles:active_toggle_switch')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpushonce


@pushonce('crud_list_scripts:active_toggle_switch')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
    $('.active_toggle').change(function() {
        var id =$(this).attr('data-targetid');
        var checked=$(this).prop('checked');
        $.ajax({
            type:'PUT',
            url:"{{ url($crud->route) }}/attended",
            dataType:'json',
            data:{
                '_token' : '<?php echo csrf_token() ?>',
                'id':id,
                'checked':checked?1:0
            },
            success:function(data){
                console.log(data);
            },
            error:function (xhr,status,err) {
                new PNotify({
                    title: "No se pudo actualizar",
                    text: "Ha ocurrido un error actualizando la asistencia.",
                    type: "error"
                });
                console.log(status);
                console.log(err);
            }
        });

    });
</script>
@endpushonce
