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
        @include('postventas.auto.lista_autos')
    </div>
@endsection
@section('css_after')
    @parent
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection
@section('js_after')
    @parent
    <!-- jQuery (required for BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Inputs + Ion Range Slider + Password Strength Meter plugins) -->
    <script src="{{ asset('js/lib/jquery.min.js')}}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('js/plugins/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script>Dashmix.helpersOnLoad(['js-flatpickr', 'jq-datepicker', 'jq-colorpicker', 'jq-maxlength', 'jq-select2', 'jq-rangeslider', 'jq-pw-strength']);</script>
@endsection

