@extends('dash.layouts.backend')
@section('menu_sidebar')
@endsection
@php($title_tdata = 'Listado de Postventas')
@php($descripcion_tdata = 'Listado de Postventas')
@section('content')
    <!-- Page Content -->
    <!-- Appear ([data-toggle="appear"] is initialized in Helpers.jqAppear()) -->
    <div class="content">
        <h1 class="content-heading">Se auementa nueva <small>oportunidad</small>.</h1>
    </div>

@endsection
@section('css_before')

@endsection
@section('js_after')
    <script type="text/javascript">
        window.opener.location.reload(true);
        window.close();
    </script>
@endsection
