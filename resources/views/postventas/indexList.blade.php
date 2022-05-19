@extends('dash.layouts.backend')
@section('menu_sidebar')
@endsection
@php($title_tdata = 'Listado de Postventas')
@php($descripcion_tdata = 'Listado de Postventas')
@section('content')

    <!-- Page Content -->
    <!-- Dynamic Table Full -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Filtros de Gestion PostVentas</h3>
        </div>
        <div class="block-content">
            <!-- Multiple Items -->

            <div id="accordion2" role="tablist" aria-multiselectable="true">
                <div class="block block-rounded mb-1">
                    <div class="block-header block-header-default" role="tab" id="accordion2_h1">
                        <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion2" href="#accordion2_q1" aria-expanded="true" aria-controls="accordion2_q1">Filtros de Gestion PostVentas</a>
                    </div>
                    <div id="accordion2_q1" class="collapse show" role="tabpanel" aria-labelledby="accordion2_h1">

                        <div class="block-content space-y-2">
                            {{ Form::open(['route' => 'postventa.indice', 'method' => 'GET', 'class' => ' g-3 align-items-center',]) }}
                            <div class="form-group row">
                                <div class="col-3">
                                    <div class="mb-4">
                                        @php($campo = 'search_cliente')
                                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                        {{ Form::text('search_cliente', request($campo), ['class' => 'form-control col-12', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-4">
                                        @php($campo = 'search_chasis')
                                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                        {{ Form::text('search_cliente', request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-4">
                                        @php($campo = 'search_placa')
                                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                        {{ Form::text('search_cliente', request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-4">
                                        @php($campo = 'search_asesor')
                                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                        {{ Form::text('search_cliente', request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-3">
                                    <div class="mb-4">
                                        @php($campo = 'search_orden')
                                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                        {{ Form::text($campo, request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-4">
                                        @php($campo = 'search_oportunidades')
                                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                        {{ Form::select($campo, \App\Models\DetalleGestionOportunidades::daroportunidadeslist()->pluck('descServ','codServ'), null,
                                   ['class' => 'js-select2 form-select form-control col-12', 'style' => '', 'data-placeholder' => __('fo.'.$campo),'id' => $campo,'multiple']) }}
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-4">
                                        @php($campo = 'search_agencia')
                                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                        {{ Form::text($campo, request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-4">
                                        @php($campo = 'search_estados')
                                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                        {{ Form::select($campo, \App\Models\DetalleGestionOportunidades::daroestadoslist()->pluck('gestion_tipo','gestion_tipo'), null,
                                   ['class' => 'js-select2 form-select form-control col-12', 'style' => '', 'data-placeholder' => __('fo.'.$campo),'id' => $campo,'multiple']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <div class="mb-4">
                                        @php($campo = 'search_fechaGestion')
                                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                        <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                            <input type="text" class="form-control" id="example-daterange1" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                            <span class="input-group-text fw-semibold"> <i class="fa fa-fw fa-arrow-right"></i> </span>
                                            <input type="text" class="form-control" id="example-daterange2" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-4">
                                        @php($campo = 'search_fechaFactura')
                                        <div class="mb-4">
                                            {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                            <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                                <input type="text" class="form-control" id="example-daterange1" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                                <span class="input-group-text fw-semibold"> <i class="fa fa-fw fa-arrow-right"></i> </span>
                                                <input type="text" class="form-control" id="example-daterange2" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-6">
                                    <div class="mb-4">
                                        @php($campo = 'search_fechaCita')
                                        {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                                        <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                            <input type="text" class="form-control" id="example-daterange1" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                            <span class="input-group-text fw-semibold"> <i class="fa fa-fw fa-arrow-right"></i> </span>
                                            <input type="text" class="form-control" id="example-daterange2" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6"><div class="mb-4"></div></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-10">
                                    <div class="mb-4">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-4">
                                        <button type="submit" class="btn btn-primary">Buscar</button>
                                    </div>
                                </div>
                            </div>

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Multiple Items -->
        </div>
    </div>
    <!-- Vertical Block Tabs Default Style (Right) -->
    <div class="block block-rounded row flex-md-row-reverse g-0">
        <ul class="nav nav-tabs nav-tabs-block justify-content-end justify-content-md-start flex-md-column col-md-2" role="tablist">
            <li class="nav-item d-md-flex flex-md-column">
                <button class="nav-link text-md-start active" id="btabs-vertical2-home-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical2-home" role="tab" aria-controls="btabs-vertical2-home" aria-selected="true">
                    <i class="fa fa-fw fa-house opacity-50 me-1 d-none d-sm-inline-block"></i> Gestión Inicial
                </button>
            </li>
            <li class="nav-item d-md-flex flex-md-column">
                <button class="nav-link text-md-start" id="btabs-vertical2-profile-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical2-profile" role="tab" aria-controls="btabs-vertical2-profile" aria-selected="false">
                    <i class="fa fa-fw fa-calendar-day opacity-50 me-1 d-none d-sm-inline-block"></i> Recordatorio
                </button>
            </li>
            <li class="nav-item d-md-flex flex-md-column">
                <button class="nav-link text-md-start" id="btabs-vertical2-settings-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical2-settings" role="tab" aria-controls="btabs-vertical2-settings" aria-selected="false">
                    <i class="fa fa-fw fa-filter opacity-50 me-1 d-none d-sm-inline-block"></i> Consulta General
                </button>
            </li>
            <li class="nav-item d-md-flex flex-md-column">
                <button class="nav-link text-md-start" id="btabs-vertical2-settings-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical2-consuxprodu" role="tab" aria-controls="btabs-vertical2-settings" aria-selected="false">
                    <i class="fab fa-fw fa-searchengin opacity-50 me-1 d-none d-sm-inline-block"></i> Consulta x Producto
                </button>
            </li>
        </ul>
        <div class="tab-content col-md-10">
            <div class="block-content tab-pane active" id="btabs-vertical2-home" role="tabpanel" aria-labelledby="btabs-vertical2-home-tab">
                <h4 class="fw-semibold">Gestión Inicial</h4>
                @include('postventas.indice.gestion_inicial')
            </div>
            <div class="block-content tab-pane" id="btabs-vertical2-profile" role="tabpanel" aria-labelledby="btabs-vertical2-profile-tab">
                <h4 class="fw-semibold">Recordatorio</h4>
                <p class="fs-sm">
                    Recordatorio
                </p>
            </div>
            <div class="block-content tab-pane" id="btabs-vertical2-settings" role="tabpanel" aria-labelledby="btabs-vertical2-settings-tab">
                <h4 class="fw-semibold">Consulta General</h4>
                <p class="fs-sm">
                    Consulta General
                </p>
            </div>
            <div class="block-content tab-pane" id="btabs-vertical2-consuxprodu" role="tabpanel" aria-labelledby="btabs-vertical2-settings-tab">
                <h4 class="fw-semibold"> Consulta x Producto</h4>
                <p class="fs-sm">
                    Consulta x Producto
                </p>
            </div>
        </div>
    </div>
    <!-- END Vertical Block Tabs Default Style (Right) -->

    <!-- END Page Content -->
@endsection
@section('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css')}}">

    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endsection
@section('js_after')
    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js')}}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js')}}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js')}}"></script>

    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('js/plugins/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/additional-methods.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Page JS Code -->
    <script>Dashmix.helpersOnLoad(['js-flatpickr', 'jq-datepicker', 'jq-colorpicker', 'jq-maxlength', 'jq-select2', 'jq-rangeslider', 'jq-pw-strength']);</script>
    @include('postventas.datatable_js')
@endsection


