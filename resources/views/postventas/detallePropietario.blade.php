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
    <script>
        /*
         *  Document   : be_comp_dialogs.js
         *  Author     : pixelcave
         *  Description: Custom JS code used in Dialogs Page
         */

        // SweetAlert2, for more examples you can check out https://github.com/sweetalert2/sweetalert2
        class pageDialogs_op {
            /*
             * SweetAlert2 demo functionality
             *
             */
            static sweetAlert2() {
                // Set default properties
                let toast = Swal.mixin({
                    buttonsStyling: false,
                    target: '#page-container',
                    customClass: {
                        confirmButton: 'btn btn-success m-1',
                        cancelButton: 'btn btn-danger m-1',
                        input: 'form-control'
                    }
                });


                // Init an error dialog on button click
                function arrancaMensaje(){

                    toast.fire({
                        title: 'Esta seguro?',
                        text: 'Esto no es reversible!, Se archivara como perdida la oportunidad',
                        html:
                            '<input id="swal-input1" class="swal2-input">' +
                            '<input id="swal-input2" class="swal2-input">',
                        focusConfirm: false,
                        icon: 'warning',
                        showCancelButton: true,
                        customClass: {
                            confirmButton: 'btn btn-danger m-1',
                            cancelButton: 'btn btn-secondary m-1'
                        },
                        confirmButtonText: 'Yes, Oportunidad perdida',
                        preConfirm: e => {
                            return new Promise(resolve => {
                                setTimeout(() => {
                                    alert(document.getElementById('swal-input1').value);
                                    alert(document.getElementById('swal-input2').value);
                                    resolve();
                                }, 50);
                            });
                        }
                    }).then(result => {
                        if (result.value) {
                            toast.fire('Perdida!', 'La oportunidad se ha registrado como perdida.', 'success');
                            // result.dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                        } else if (result.dismiss === 'cancel') {
                            toast.fire('Cancelada', 'La oportunidad no se ha cambiado :)', 'error');
                        }
                    });
                }
                jQuery( ".js-swal-op-perdida" ).click(function( event ) {
                    event.preventDefault();
                    arrancaMensaje();
                });
            }

            /*
             * Init functionality
             *
             */
            static init() {
                this.sweetAlert2();
            }
        }

        // Initialize when page loads
        Dashmix.onLoad(pageDialogs_op.init());

    </script>
    <script>Dashmix.helpersOnLoad(['js-flatpickr', 'jq-datepicker', 'jq-colorpicker', 'jq-maxlength', 'jq-select2', 'jq-rangeslider', 'jq-pw-strength']);</script>
@endsection

