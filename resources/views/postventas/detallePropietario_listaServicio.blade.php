@extends('dash.layouts.backend')
@section('menu_sidebar')
@endsection
@php($title_tdata = 'Detalle Propietario')
@php($descripcion_tdata = 'Detalle del Propietario')
@section('content')

    <div class="container">
        <div class="row g-sm">
            <div class="col-6">
                <div class="row">
                    @include('postventas.propietarios.show')
                </div>
            </div>
            <div class="col-6">
                @include('postventas.auto.otros_contactos_auto')
            </div>
        </div>
        <hr>
        <a href="{{ route('postventa.edita_auto',[ 'id' => $propietario->id ,'id_auto'  => 'all', 'todos_auto' => true ,'userid'=> Auth::user()->email]) }}" class="btn btn-primary">
            <i class="fas fa-car-side"></i> Todos las oportunidades
        </a>
        <hr>
        @include('postventas.auto.lista_autos_facturas')
    </div>
@endsection
@section('css_after')

@endsection
@section('js_after')
@endsection

