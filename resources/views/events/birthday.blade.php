@extends('backpack::layout')

@section('content')
    <!-- Default box -->
    <div class="row">

        <!-- THE ACTUAL CONTENT -->
        <div class="col-md-12">
            <div class="box">

                <form method="post">
                    {{ csrf_field() }}
                <div class="box-header">

                    <a href="{{ url('birthdays') }}" class="btn btn-warning"><i class="fa fa-backward"></i>Volver</a>
                    <h3 style="display: inline">Enviar email de cumpleaños a: {{ $user->fullname }}</h3>
                </div>

                <div class="box-body">
                        <div class="form-group">
                            <label for="">Título</label>
                            <input value="{{ old('title','') }}" type="text" class="form-control" id="emailtitle" placeholder="Título" name="title" >
                        </div>
                        <div class="form-group">
                            <label>Mensaje:</label>
                            <textarea class="form-control" name="message" id="message_editor">{{ old('message','') }}</textarea>
                        </div>



                </div>
                <div class="box-footer">
                    <div class="pull-right text-right">
                        <input type="submit" class="btn btn-success btn-lg" value="Enviar email" />
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('after_scripts')
    <script src="{{  url("js/ckeditor/ckeditor.js") }}"></script>

    <script type="text/javascript">

        var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";

        CKEDITOR.replace( 'message_editor', {
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}',
            uploadUrl: route_prefix + '/upload?type=Images&responseType=json&_token={{csrf_token()}}'

        });


        @if(session('success'))
            window.onload = function () {
            new PNotify({
                title: "Envío exitoso",
                text: "{{ session('success') }}",
                type: "success"
            });
        }

        @endif

    </script>

@endsection

@section('after_styles')
    <style>
        .ck-editor__editable {
            min-height: 400px;
        }
    </style>
@endsection
