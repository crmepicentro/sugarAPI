@extends('dash.layouts.backend')
@section('menu_sidebar')
@endsection
@php($title_tdata = 'Listado de Postventas')
@php($descripcion_tdata = 'Listado de Postventas')
@section('content')
    <!-- Page Content -->
    <!-- Appear ([data-toggle="appear"] is initialized in Helpers.jqAppear()) -->
    <div class="content">
        <h1 class="content-heading">Listo oara buscar los datos.<small>Sistema de post ventas</small></h1>
        <table class="table table-sm table-vcenter" style="width: 100%">
            <thead>
            <tr class="bg-body-dark">
                <th>
                    OR
                </th>
                <th>
                    AS
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td> dato</td>
                <td> dotro ato</td>
            </tr>
            </tbody>
        </table>
        <!-- END Appear -->
    </div>
    <!-- END Page Content -->
@endsection
@section('css_before')

@endsection
@section('js_after')

@endsection
