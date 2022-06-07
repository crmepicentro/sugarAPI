@extends('dash.layouts.backend')
@section('menu_sidebar')
@endsection
@php($title_tdata = 'Listado de Postventas')
@php($descripcion_tdata = 'Listado de Postventas')
@section('content')
    <!-- Page Content -->
    <!-- Appear ([data-toggle="appear"] is initialized in Helpers.jqAppear()) -->
    <div class="content">
        <h1 class="content-heading">No tiene Permiso para ingresar, refresque el sitio para volver a intentar.<small>Sistema de post ventas</small></h1>
        <!-- END Appear -->
    </div>
    <!-- END Page Content -->
@endsection
@section('css_before')

@endsection
@section('js_after')
    <script>
        window.top.location.href = "http://crm.epicentro.local/#cb_TraficoControl/layout/stocknuevos";
    </script>
@endsection
