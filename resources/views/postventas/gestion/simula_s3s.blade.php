@extends('dash.layouts.backend')
@section('menu_sidebar')
@endsection
@php($title_tdata = 'Listado de Postventas')
@php($descripcion_tdata = 'Listado de Postventas')
@section('content')

<code>
    <pre>
    {{ print_r($gestionAgendado->citas3s,true) }}
    </pre>
    <hr>
    <pre>
    {{ json_encode($gestionAgendado->citas3s) }}
    </pre>
</code>
<a href="{{ route('postventa.s3spostdatacorerespuesta',['codigo_seguimiento' =>$gestionAgendado->codigo_seguimiento,'respuesta'=> Str::random(10),'userid'=> Auth::user()->email]) }}" class="btn btn-primary">Respuesta de S3S</a>

<iframe name="iframe" id="iframe" src="https://talleres.casabaca.local/" style="height:800px;width:100%" title="Iframe Example"></iframe>
@endsection
@section('js_after')
    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js')}}"></script>
<script>

    $('#taller_casbaca').on('load', function() {
        console.warn('cargado');
        /////////
        const iframeReference = document.getElementById("");
        x = window.frames[0];
        x.postMessage('{"message": "Hello from the parent page!"}', '*');

        ///////////


    });
</script>
@endsection
