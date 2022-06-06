@extends('dash.layouts.backend')
@section('menu_sidebar')
@endsection
@php($title_tdata = 'Listado de Postventas')
@php($descripcion_tdata = 'Listado de Postventas')
@section('content')

    <!-- Page Content -->
    <!-- Appear ([data-toggle="appear"] is initialized in Helpers.jqAppear()) -->

    <div class="content">
        <h1 class="content-heading">Reporte <small>Sistema de post ventas</small></h1>
        <div class="row">
            <div class="col-sm-4">
                <div class="block block-rounded animated fadeIn" data-toggle="appear">
                    <div class="block-content block-content-full">
                        <div class="py-5 text-center">
                            <div class="item item-2x item-circle bg-info text-white mx-auto">
                                <i class="fa fa-2x fa-train"></i>
                            </div>
                            <div class="fs-4 fw-semibold pt-3 mb-0">Reporte 1</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="block block-rounded animated fadeIn" data-toggle="appear">
                    <div class="block-content block-content-full">
                        <div class="py-5 text-center">
                            <div class="item item-2x item-circle bg-danger text-white mx-auto">
                                <i class="fa fa-2x fa-plane"></i>
                            </div>
                            <div class="fs-4 fw-semibold pt-3 mb-0">Reporte 2</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="block block-rounded animated fadeIn" data-toggle="appear">
                    <div class="block-content block-content-full">
                        <div class="py-5 text-center">
                            <div class="item item-2x item-circle bg-dark text-white mx-auto">
                                <i class="fa fa-2x fa-car"></i>
                            </div>
                            <div class="fs-4 fw-semibold pt-3 mb-0">Reporte 3</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Appear -->
    </div>

    <!-- END Page Content -->
@endsection
@section('css_before')

@endsection
@section('js_after')

@endsection


