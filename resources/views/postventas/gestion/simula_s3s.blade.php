@extends('dash.layouts.backend')
@section('menu_sidebar')
@endsection
@php($title_tdata = 'Listado de Postventas')
@php($descripcion_tdata = 'Listado de Postventas')
@section('content')

<h1>Abrir pantalla de Taller BMS para disponibilidad...</h1>
<a href="http://talleres.casabaca.local/externo/reservar-cita/cita?docidentidad={{ $auto->propietario->cedula }}&placa={{ $auto->placa }}&usuario={{ $gestionAgendado->usuario->name }}&agencia={{ $gestionAgendado->gestionagendadodetalleop[0]->agencia_cita }}" class="btn btn-primary">Respuesta de S3S</a>

@endsection
@section('js_after')
    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js')}}"></script>
    <script>
        //window.location.replace("http://talleres.casabaca.local/externo/reservar-cita/cita?docidentidad=0922178322&placa=PCT7092&usuario=MA_GUERRERO");
    </script>
@endsection
