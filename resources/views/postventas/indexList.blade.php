@extends('dash.layouts.backend')
@section('menu_sidebar')
@endsection
@php($title_tdata = 'Listado de Postventas')
@php($descripcion_tdata = 'Listado de Postventas')
@section('content')

    <!-- Page Content -->
    <!-- Vertical Block Tabs Default Style (Right) -->
    <div class="block block-rounded row flex-md-row-reverse g-0">
        <ul class="nav nav-tabs nav-tabs-block justify-content-end justify-content-md-start flex-md-column col-md-2" role="tablist">
            <li class="nav-item d-md-flex flex-md-column">
                <button class="nav-link text-md-start active" id="btabs-vertical2-home-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical2-home" role="tab" aria-controls="btabs-vertical2-home" aria-selected="true">
                    <i class="fa fa-fw fa-house opacity-50 me-1 d-none d-sm-inline-block"></i> Gestión Citas
                </button>
            </li>
            <li class="nav-item d-md-flex flex-md-column">
                <button class="nav-link text-md-start" id="btabs-vertical2-profile-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical2-profile" role="tab" aria-controls="btabs-vertical2-profile" aria-selected="false">
                    <i class="fa fa-fw fa-calendar-day opacity-50 me-1 d-none d-sm-inline-block"></i> Gestion Futura
                </button>
            </li>
            <li class="nav-item d-md-flex flex-md-column">
                <button class="nav-link text-md-start" id="btabs-vertical2-settings-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical2-settings" role="tab" aria-controls="btabs-vertical2-settings" aria-selected="false">
                    <i class="fa fa-fw fa-filter opacity-50 me-1 d-none d-sm-inline-block"></i> Consulta General
                </button>
            </li>
{{--
            <li class="nav-item d-md-flex flex-md-column">
                <button class="nav-link text-md-start" id="btabs-vertical2-settings-tab" data-bs-toggle="tab" data-bs-target="#btabs-vertical2-consuxprodu" role="tab" aria-controls="btabs-vertical2-settings" aria-selected="false">
                    <i class="fab fa-fw fa-searchengin opacity-50 me-1 d-none d-sm-inline-block"></i> Consulta x Producto
                </button>
            </li>--}}
        </ul>
        <div class="tab-content col-md-10">
            <div class="block-content tab-pane active" id="btabs-vertical2-home" role="tabpanel" aria-labelledby="btabs-vertical2-home-tab">
                <h4 class="fw-semibold">Gestión Citas</h4>
                @include('postventas.indice.gestion_inicial')
            </div>
            <div class="block-content tab-pane" id="btabs-vertical2-profile" role="tabpanel" aria-labelledby="btabs-vertical2-profile-tab">
                <h4 class="fw-semibold">Gestion Futura</h4>
                <p class="fs-sm">
                    @php( $lista_oportunidades = $lista_recordatorio)
                    @include('postventas.indice.gestion_inicial')
                </p>
            </div>
            <div class="block-content tab-pane" id="btabs-vertical2-settings" role="tabpanel" aria-labelledby="btabs-vertical2-settings-tab">
                <h4 class="fw-semibold">Consulta General</h4>
                <p class="fs-sm">
                    @include('postventas.indice.consulta_general')
                    @php( $lista_oportunidades = $lista_consultageneral)
                    @include('postventas.indice.gestion_inicial')
                </p>
            </div>
{{--            <div class="block-content tab-pane" id="btabs-vertical2-consuxprodu" role="tabpanel" aria-labelledby="btabs-vertical2-settings-tab">
                <h4 class="fw-semibold"> Consulta x Producto</h4>
                <p class="fs-sm">
                    Consulta x Producto
                </p>
            </div>--}}
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


