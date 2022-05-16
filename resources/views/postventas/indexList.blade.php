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
                            {{ Form::open(['route' => 'postventa.indice', 'method' => 'GET', 'class' => 'row row-cols-lg-auto g-3 align-items-center',]) }}
                            @php($campo = 'search_cliente')
                            <div class="col-12">
                                <label class="visually-hidden" for="example-if-email">{{ __('fo.'.$campo) }}</label>
                                {{ Form::text('search_cliente', request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                            </div>
                            @php($campo = 'search_correo')
                            <div class="col-12">
                                <label class="visually-hidden" for="example-if-email">{{ __('fo.'.$campo) }}</label>
                                {{ Form::text('search_cliente', request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                            </div>
                            @php($campo = 'search_telefono')
                            <div class="col-12">
                                <label class="visually-hidden" for="example-if-email">{{ __('fo.'.$campo) }}</label>
                                {{ Form::text('search_cliente', request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                            </div>
                            @php($campo = 'search_agenente')
                            <div class="col-12">
                                <label class="visually-hidden" for="example-if-email">{{ __('fo.'.$campo) }}</label>
                                {{ Form::text('search_cliente', request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                            </div>
                            @php($campo = 'search_orden')
                            <div class="col-12">
                                <label class="visually-hidden" for="example-if-email">{{ __('fo.'.$campo) }}</label>
                                {{ Form::select($campo, \App\Models\DetalleGestionOportunidades::daroportunidadeslist()->pluck('descServ','codServ'), null,
                                    ['class' => 'js-select2 form-select form-control', 'style' => 'width: 100%', 'data-placeholder' => __('fo.'.$campo),'id' => $campo,'multiple']) }}

                            </div>
                            @php($campo = 'search_oportunidades')
                            <div class="col-12">
                                <label class="visually-hidden" for="example-if-email">{{ __('fo.'.$campo) }}</label>
                                {{ Form::text('search_cliente', request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                            </div>
                            @php($campo = 'search_placa')
                            <div class="col-12">
                                <label class="visually-hidden" for="example-if-email">{{ __('fo.'.$campo) }}</label>
                                {{ Form::text('search_cliente', request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
                            </div>
                             @php($campo = 'search_fechaGestion')
                            <div class="col-12">
                                <label class="" for="example-if-email">{{ __('fo.'.$campo) }}</label>
                                <div class="mb-4">
                                    <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <input type="text" class="form-control" id="example-daterange1" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <span class="input-group-text fw-semibold"> <i class="fa fa-fw fa-arrow-right"></i> </span>
                                        <input type="text" class="form-control" id="example-daterange2" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    </div>
                                </div>
                            </div>
                            @php($campo = 'search_fechaFactura')
                            <div class="col-12">
                                <label class="" for="example-if-email">{{ __('fo.'.$campo) }}</label>
                                <div class="mb-4">
                                    <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <input type="text" class="form-control" id="example-daterange1" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <span class="input-group-text fw-semibold"> <i class="fa fa-fw fa-arrow-right"></i> </span>
                                        <input type="text" class="form-control" id="example-daterange2" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    </div>
                                </div>
                            </div>
                            @php($campo = 'search_fechaCita')
                            <div class="col-12">
                                <label class="" for="example-if-email">{{ __('fo.'.$campo) }}</label>
                                <div class="mb-4">
                                    <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <input type="text" class="form-control" id="example-daterange1" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                        <span class="input-group-text fw-semibold"> <i class="fa fa-fw fa-arrow-right"></i> </span>
                                        <input type="text" class="form-control" id="example-daterange2" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    </div>
                                </div>
                            </div>




                            <div>
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Multiple Items -->
        </div>
    </div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Dynamic Table <small>Full</small>
            </h3>
        </div>
        <div class="block-content block-content-full">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full table-sm">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Cliente</th>
                    <th class="d-none d-sm-table-cell" style="width: 30%;">Mail</th>
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
                            {{ $lista_oportunidade->email_propietario }} {{ ($lista_oportunidade->email_propietario_2 != '' )?" | ".$lista_oportunidade->email_propietario_2:"" }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ $lista_oportunidade->telefono_domicilio ?? $lista_oportunidade->telefono_domicilio ?? $lista_oportunidade->telefono_celular ?? 'No tiene' }}
                            {{ ($lista_oportunidade->telefono_trabajo != '' )?" | ".$lista_oportunidade->telefono_trabajo:"" }}
                            {{ ($lista_oportunidade->telefono_celular != '' )?" | ".$lista_oportunidade->telefono_celular:"" }}
                        </td>
                        <td class="d-none d-sm-table-cell">{{ 'RFM' }}</td>
                        <td class="d-none d-sm-table-cell">{{ 'R' }}</td>
                        <td class="d-none d-sm-table-cell">{{ 'F' }}</td>
                        <td class="d-none d-sm-table-cell">{{ 'M' }}</td>
                        <td class="d-none d-sm-table-cell">{{ 'VHC' }}</td>
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
    </div>
    <!-- END Dynamic Table Full -->

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


