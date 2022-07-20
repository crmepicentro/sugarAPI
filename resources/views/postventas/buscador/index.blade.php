@extends('dash.layouts.backend')
@section('menu_sidebar')
@endsection
@php($title_tdata = 'Listado de Postventas')
@php($descripcion_tdata = 'Listado de Postventas')
@section('content')
    <!-- Page Content -->
    <!-- Appear ([data-toggle="appear"] is initialized in Helpers.jqAppear()) -->
    <div class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1 class="content-heading">Listo oara buscar los datos.<small>Sistema de post ventas</small></h1>
        <table class="table table-sm table-vcenter" style="width: 100%">
            <thead>
            <tr class="bg-body-dark">
                <th>
                    Nombre
                </th>
                <th>
                    Codigo
                </th>
                <th>
                    Maximo
                </th>
                <th colspan="2">
                    Acción
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($dato_a_buscars as $dato_a_buscar)
                @php( $unico = uniqid() )
                {{ Form::open(['route' => ['postventa.save_buscar_oportunidades_add',['uuid'=>$unico,'userid'=> Auth::user()->email]] , 'method' => 'POST' , 'id' => 'form_add_oportunidades'.$unico]) }}
                <tr>
                    <td>{{ $dato_a_buscar->descServ }}</td>
                    <td>{{ $dato_a_buscar->codigoRepuesto }}</td>
                    <td>{{ $dato_a_buscar->cantExistencia_total }}</td>
                    <td>
                        @php($campo = 'name[]')
                        {{ Form::hidden($campo, $unico) }}
                        @php($campo = 'maximo_a')
                        {{ Form::hidden($campo, $dato_a_buscar->cantExistencia_total) }}
                        @php($campo = 'auto_id')
                        {{ Form::hidden($campo, $auto_id) }}

                        @php($campo = 'codServ')
                        {{ Form::hidden($campo, $dato_a_buscar->codigoRepuesto) }}
                        @php($campo = 'descServ')
                        {{ Form::hidden($campo, $dato_a_buscar->descServ) }}

                        @php($campo = 'stock_a_aumentar')
                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label visually-hidden']) }}
                        {{ Form::number($campo, request($campo), [
                        'class' => 'form-control',
                        'id' => $campo,
                        'placeholder' => __('fo.'.$campo) ,
                        'max' => $dato_a_buscar->cantExistencia_total,
                        'min' => 0,
                        'step' => "0.01",
                        ]) }}
                    </td>
                    <td>
                        {!! Form::button('<i class="fa fa-square-plus me-1"></i> Aumentar', array(
                                            'name' => 'submit',
                                            'type' => 'submit',
                                            'value' => $unico   ,
                                            'class' => 'btn btn-primary',
                                            'title' => 'Enviar dato',
                                            'onclick'=>'return confirm("Aumentar Codigo?")'
                                    )) !!}
                    </td>
                </tr>
                {{ Form::close() }}
            @endforeach
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
