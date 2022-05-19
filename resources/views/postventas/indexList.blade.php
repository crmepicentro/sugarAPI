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
                    <i class="fa fa-fw fa-home opacity-50 me-1 d-none d-sm-inline-block"></i> Gestión Inicial
                </button>
            </li>
            <li class="nav-item d-md-flex flex-md-column">
                <button class="nav-link text-md-start" id="btabs-vertical2-profile-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical2-profile" role="tab" aria-controls="btabs-vertical2-profile" aria-selected="false">
                    <i class="fa fa-fw fa-user-circle opacity-50 me-1 d-none d-sm-inline-block"></i> Profile
                </button>
            </li>
            <li class="nav-item d-md-flex flex-md-column">
                <button class="nav-link text-md-start" id="btabs-vertical2-settings-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical2-settings" role="tab" aria-controls="btabs-vertical2-settings" aria-selected="false">
                    <i class="fa fa-fw fa-cog opacity-50 me-1 d-none d-sm-inline-block"></i> Settings
                </button>
            </li>
        </ul>
        <div class="tab-content col-md-10">
            <div class="block-content tab-pane active" id="btabs-vertical2-home" role="tabpanel" aria-labelledby="btabs-vertical2-home-tab">
                <h4 class="fw-semibold">Gestión Inicial</h4>

                <!-- Dynamic Table Full -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Post<small>Ventas</small>
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full table-sm">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Cliente</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Teléfono</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">RFM</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">R</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">F</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">M</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">VHC</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">1er Gestión Fecha</th>
                                <!--                    <th class="d-none d-sm-table-cell" style="width: 15%;">1er Gestión Estado</th>-->
                                <th style="width: 15%;"><i class="fa fa-play"></i></th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Gestión Futura Fecha</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Cita Fecha</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Gestión Futura Estado</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Gestión Futura Or</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lista_oportunidades as $lista_oportunidade)
                                <tr>
                                    <td class="text-center">{{$loop->index + 1}}</td>
                                    <td class="fw-semibold">
                                        <a href="#">{{ $lista_oportunidade->nombre_propietario }}</a>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        {{ $lista_oportunidade->telefono_domicilio ?? $lista_oportunidade->telefono_domicilio ?? $lista_oportunidade->telefono_celular ?? 'No tiene' }}
                                        {!! ($lista_oportunidade->telefono_trabajo != '' )?"<br>".$lista_oportunidade->telefono_trabajo:"" !!}
                                        {!! ($lista_oportunidade->telefono_celular != '' )?"<br>".$lista_oportunidade->telefono_celular:"" !!}
                                    </td>
                                    <td class="d-none d-sm-table-cell">{{ 'RFM' }}</td>
                                    <td class="d-none d-sm-table-cell">{{ 'R' }}</td>
                                    <td class="d-none d-sm-table-cell">{{ 'F' }}</td>
                                    <td class="d-none d-sm-table-cell">{{ 'M' }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $lista_oportunidade->cantidad_autos }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $lista_oportunidade->primer_gestion_v2 }}</td>
                                    <!--                        <td class="d-none d-sm-table-cell">{{ $lista_oportunidade->primer_gestion_estado_v2 }}</td>-->
                                    <td><a href="{{ route('postventa.edita', $lista_oportunidade->id) }}" >
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </td>
                                    <td class="d-none d-sm-table-cell">{{ $lista_oportunidade->agendado_fecha }}</td>
                                    <td>{{ __($lista_oportunidade->cita_fecha) }}</td>
                                    <td>{{ __($lista_oportunidade->gestion_tipo) }}</td>
                                    <td>{{ $lista_oportunidade->s3s_codigo_seguimiento }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $lista_oportunidades->links() }}
                </div>
                <!-- END Dynamic Table Full -->

            </div>
            <div class="block-content tab-pane" id="btabs-vertical2-profile" role="tabpanel" aria-labelledby="btabs-vertical2-profile-tab">
                <h4 class="fw-semibold">Profile Content</h4>
                <p class="fs-sm">
                    Mauris tincidunt tincidunt turpis in porta. Integer fermentum tincidunt auctor. Vestibulum ullamcorper, odio sed rhoncus imperdiet, enim elit sollicitudin orci, eget dictum leo mi nec lectus. Nam commodo turpis id lectus scelerisque vulputate. Integer sed dolor erat. Fusce erat ipsum, varius vel euismod sed, tristique et lectus? Etiam egestas fringilla enim, id convallis lectus laoreet at. Fusce purus nisi, gravida sed consectetur ut, interdum quis nisi. Quisque egestas nisl id lectus facilisis scelerisque? Proin rhoncus dui at ligula vestibulum ut facilisis ante sodales! Suspendisse potenti. Aliquam tincidunt.
                </p>
            </div>
            <div class="block-content tab-pane" id="btabs-vertical2-settings" role="tabpanel" aria-labelledby="btabs-vertical2-settings-tab">
                <h4 class="fw-semibold">Settings Content</h4>
                <p class="fs-sm">
                    Integer fermentum tincidunt auctor. Vestibulum ullamcorper, odio sed rhoncus imperdiet, enim elit sollicitudin orci, eget dictum leo mi nec lectus. Nam commodo turpis id lectus scelerisque vulputate. Integer sed dolor erat. Fusce erat ipsum, varius vel euismod sed, tristique et lectus? Etiam egestas fringilla enim, id convallis lectus laoreet at. Fusce purus nisi, gravida sed consectetur ut, interdum quis nisi. Quisque egestas nisl id lectus facilisis scelerisque? Proin rhoncus dui at ligula vestibulum ut facilisis ante sodales! Suspendisse potenti. Aliquam tincidunt sollicitudin sem nec ultrices. Sed at mi velit.
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


