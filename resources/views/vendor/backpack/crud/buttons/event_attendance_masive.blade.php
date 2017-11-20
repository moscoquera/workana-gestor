<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 11/18/17
 * Time: 3:27 PM
 */
?>

@push('crud_list_styles')
    <link href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@endpush

<button type="button" class="btn btn-default" data-toggle="modal" data-target="#importModal">
    Importar por perfíl
</button>


<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Importar todos los usuarios del perfíl</h4>
            </div>
            <div class="modal-body">
                <p class="text-muted">Se añadirán como invitados al evento, a todos los usuarios pertenecientes a los perfiles que seleccionó.</p>
                <form action="{{ Request::url().'/import' }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputName2">Perfiles</label>
                        <select multiple class="form-control" name="levels[]" id="levelsimport" style="width: 100%">
                            @foreach($event->levels as $level)
                                <option value="{{ $level->id }}" >{{ $level->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default">Importar</button>
                </form>

            </div>
        </div>
    </div>
</div>

@push('crud_list_scripts')
    <script src="{{ asset('vendor/adminlte/plugins/select2/select2.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#levelsimport').select2({
                dropdownParent: $('#importModal'),
                language:'es',
                theme: "bootstrap"
            });
        });
    </script>

@endpush