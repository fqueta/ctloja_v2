@extends('adminlte::page')

@section('title')
{{$titulo}}
@stop

@section('content_header')
    <h3>{{$titulo}}</h3>
@stop
@section('content')
<div class="row">
    <div class="col-md-12 mens">
    </div>
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Importação de arquivos</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

<<<<<<< HEAD
                @if(session('error'))
=======
                @if(session('erro'))
>>>>>>> a87a7ce6f2906f994fa9fc31c6e2a856c33f8b38
                    <div class="alert alert-danger">
                        {{ session('erro') }}
                    </div>
                @endif

                @include('config.import')
            </div>
        </div>
    </div>

</div>
@stop

@section('css')
    @include('qlib.csslib')
@stop

@section('js')
    @include('qlib.jslib')
<<<<<<< HEAD
    {{-- <script type="text/javascript">
        $(function(){
            $('a.print-card').on('click',function(e){
                openPageLink(e,$(this).attr('href'),"{{date('Y')}}");
            });
            $('[mask-cpf]').inputmask('999.999.999-99');
            $('[mask-cnpj]').inputmask('99.999.999/9999-99');
            $('[mask-data]').inputmask('99/99/9999');
            $('[mask-cep]').inputmask('99.999-999');
            $('#form-import').on('submit', function(e) {
                e.preventDefault(); // Impede o envio tradicional do form

                let formData = new FormData(this); // Cria objeto com os dados do form
                let url = $('#form-import').attr('action');
                console.log(formData);
                $.ajax({
                    url: url,           // sua rota no backend
                    type: 'POST',
                    data: formData,
                    contentType: false,       // NÃO definir manualmente
                    processData: false,       // NÃO transformar em query string
                    success: function(response) {
                    console.log('Sucesso!', response);
                    },
                    error: function(xhr, status, error) {
                    console.error('Erro:', error);
                    }
                });
            });

        });
    </script> --}}
=======
    <script type="text/javascript">
        // $(function(){
        //     $('a.print-card').on('click',function(e){
        //         openPageLink(e,$(this).attr('href'),"{{date('Y')}}");
        //     });
        //     $('[mask-cpf]').inputmask('999.999.999-99');
        //     $('[mask-cnpj]').inputmask('99.999.999/9999-99');
        //     $('[mask-data]').inputmask('99/99/9999');
        //     $('[mask-cep]').inputmask('99.999-999');
        //     $('#form-import').on('submit', function(e) {
        //         e.preventDefault(); // Impede o envio tradicional do form

        //         let formData = new FormData(this); // Cria objeto com os dados do form
        //         let url = $('#form-import').attr('action');
        //         console.log(formData);
        //         $.ajax({
        //             url: url,           // sua rota no backend
        //             type: 'POST',
        //             data: formData,
        //             contentType: false,       // NÃO definir manualmente
        //             processData: false,       // NÃO transformar em query string
        //             success: function(response) {
        //             console.log('Sucesso!', response);
        //             },
        //             error: function(xhr, status, error) {
        //             console.error('Erro:', error);
        //             }
        //         });
        //     });

        // });
    </script>
>>>>>>> a87a7ce6f2906f994fa9fc31c6e2a856c33f8b38
    {{-- @include('clientes.js_submit') --}}

@stop
