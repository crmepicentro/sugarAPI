<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Anfitriona - Campa&ntilde;a (Qu&eacute;date en Casa)
        </h2>
    </x-slot>
  @if(Session::has('prueba'))
    <div class="alert alert-success">
      <h2>{{ Session::get('prueba') }}</h2>
    </div>
  @endif
    @if (\Session::has('success'))
        <div
            class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
            id="modal-id">
            <div class="relative w-auto my-6 mx-auto max-w-3xl">
                <!--content-->
                <div
                    class="space-x-2 bg-green-50 p-4 rounded flex items-center text-green-600 my-4 shadow-lg mx-auto max-w-2xl w-full">


                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-5 pt-1" viewBox="0 0 24 24">
                            <path
                                d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/>
                        </svg>
                    </div>
                    <h3 class="text-green-800 tracking-wider flex-1">
                        Datos guardados correctamente
                    </h3>
                    <button onclick="toggleModal('modal-id')"
                            class="inline-flex items-center hover:bg-green-100 border
                        border-green-300 hover:text-green-900 focus:outline-none rounded-full p-2 hover:cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4 pt-1" viewBox="0 0 24 24">
                            <path
                                d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"/>
                        </svg>
                    </button>

                </div>
            </div>
        </div>
        <div class="opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>
    @endif

    <div
        class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="loader">
        <div class=" w-auto my-10 mx-auto max-w-3xl">
            <!--content-->
            <div class="loader">Loading...</div>
        </div>
    </div>

    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="loader-backdrop"></div>

    <div class="container text-sm justify-center bg-white mx-auto rounded shadow-2xl">

        <div class=" bg-white p-2 sm:px-20 ">
            <h2 class="text-2xl p-4 text-black font-bold text-center">Ingrese los datos del cliente</h2>

            {!! Form::open(['action' => "DigitalCampaignsController@saveClient",'class' =>'flex flex-wrap w-full text-gray-600']) !!}
            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="tipo_identificacion">Tipo de Identificaci&oacute;n</label>
                {!! Form::select('tipo_identificacion',['C'=>'Cédula','R'=>'RUC','P'=>'Pasaporte'], null, ['required'=>'','id'=>'tipo_identificacion','placeholder' => 'Seleccione un tipo','class' => 'rounded w-full block border border-gray-400 px-4 py-2']) !!}
                <span class="text-red-600">@error('tipo_identificacion'){{$message}}@enderror</span>
            </div>
            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="identificacion">N&uacute;mero de Identificaci&oacute;n</label>
                <input class="rounded w-full block border border-gray-400 px-4 py-2" required type="text"
                       name="identificacion"
                       id="identificacion">
                <span class="text-red-600">@error('identificacion'){{$message}}@enderror</span>
            </div>
            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="nombres">Nombres</label>
                <input class="rounded w-full block border border-gray-400 px-4 py-2" type="text" name="nombres"
                       id="nombres">
                <span class="text-red-600">@error('nombres'){{$message}}@enderror</span>
            </div>
            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="apellidos">Apellidos</label>
                <input class="rounded w-full block border border-gray-400 px-4 py-2" type="text" name="apellidos"
                       id="apellidos">
                <span class="text-red-600">@error('apellidos'){{$message}}@enderror</span>
            </div>

            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="telefono">T&eacute;lefono</label>
                <input class="rounded w-full block border border-gray-400 px-4 py-2" type="text" pattern="0\d{8}"
                       required minlength="9" maxlength="9" name="telefono"
                       id="telefono">
                <span class="text-red-600">@error('telefono'){{$message}}@enderror</span>
            </div>
            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="celular">Celular</label>
                <input class="rounded w-full block border border-gray-400 px-4 py-2" type="text" pattern="09\d{8}"
                       required minlength="10" maxlength="10" name="celular"
                       id="celular">
                <span class="text-red-600">@error('celular'){{$message}}@enderror</span>
            </div>

            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="email">Email</label>
                <input class="rounded w-full block border border-gray-400 px-4 py-2" type="email" required name="email"
                       id="email">
                <span class="text-red-600">@error('email'){{$message}}@enderror</span>
            </div>
            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="genero">G&eacute;nero</label>
                {!! Form::select('genero',['M'=>'Masculino','F'=>'Femenino'], null, ['id'=>'genero','placeholder' => 'Seleccione un genero','class' => 'rounded w-full block border border-gray-400 px-4 py-2']) !!}
                <span class="text-red-600">@error('genero'){{$message}}@enderror</span>
            </div>
            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="linea">L&iacute;nea de Negocio</label>
                {!! Form::select('linea',['d8365338-9206-11e9-a7c3-000c297d72b1'=>'Nuevos','ed7ebf16-a81b-11e9-8f1e-000c297d72b1'=>'Seminuevos','f417e1ae-a81b-11e9-ab2c-000c297d72b1'=>'Exonerados'], null, ['id'=>'linea','required'=>'','placeholder' => 'Seleccione una línea','class' => 'rounded w-full block border border-gray-400 px-4 py-2']) !!}
                <span class="text-red-600">@error('linea'){{$message}}@enderror</span>
            </div>
            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="agencia">Agencia</label>
                {!! Form::select('agencia',[], null, ['id'=>'agencia','required'=>'','placeholder' => 'Seleccione una agencia','class' => 'rounded w-full block border border-gray-400 px-4 py-2']) !!}
                <span class="text-red-600">@error('agencia'){{$message}}@enderror</span>
            </div>
            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="asesor">Asesor</label>
                {!! Form::select('asesor',[], null, ['id'=>'asesor','required'=>'','placeholder' => 'Seleccione un asesor','class' => 'rounded w-full block border border-gray-400 px-4 py-2']) !!}
                <span class="text-red-600">@error('asesor'){{$message}}@enderror</span>
            </div>

            <div class="w-full sm:w-1/2 p-2">
                <label class="block font-bold" for="campania">Campaña</label>
                {!! Form::select('campania',['f39d579a-a7ba-11eb-a019-000c297d72b1'=>'Quédate en Casa'], null, ['required'=>'','class' => 'rounded w-full block border border-gray-400 px-4 py-2']) !!}
                <span class="text-red-600">@error('campania'){{$message}}@enderror</span>
            </div>

            <div class="w-full p-2">
                <label class="block font-bold" for="comentario">Comentarios</label>
                {!! Form::textarea('comentario', null, ['required'=>'','rows'=> 2,'class' => 'rounded w-full block border border-gray-400 px-4 py-2']) !!}
                <span class="text-red-600">@error('comentario'){{$message}}@enderror</span>
            </div>
            <button
                class="font-bold text-white w-1/3 rounded bg-blue-400 hover:bg-blue-600 transition duration-300 mx-auto p-2 m-4 ">
                Guardar
            </button>
            {!! Form::close() !!}

        </div>
    </div>
    <script type="text/javascript">
        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById(modalID + "-backdrop").classList.toggle("flex");
        }
        function bloquearCampo(id) {
            $(id).attr('readonly', true);
            $(id).attr("disabled", true);
        }

        function desbloquearCampo(id) {
            $(id).attr('readonly', false);
            $(id).attr("disabled", false);
        }

        function ocutarCampo(id) {
            $(id).addClass('hidden');
        }

        function mostrarCampo(id) {
            $(id).removeClass('hidden');
        }

        $("#tipo_identificacion").change(function () {
            if ($("#tipo_identificacion option:selected").val() !== '') {
                desbloquearCampo('#identificacion');
            } else {
                bloquearCampo('#identificacion');
            }
        });

        $("#identificacion").blur(function () {
            var identificacion = $("#identificacion").val();
            if (identificacion !== '') {
                toggleModal('loader');
                $.ajax({
                    method: 'GET',
                    dataType: 'json',
                    url: '{{route('campaign.getData.identificacion')}}',
                    async: true,
                    data: {
                        'identificacion': identificacion,
                        'tipo_identificacion': $('#tipo_identificacion').val()
                    }
                }).done(function (resp) {
                    if (resp.result) {
                        $('#nombres').val(resp.first_name);
                        $('#apellidos').val(resp.last_name);
                        $('#genero').val(resp.genero_c);
                        $('#telefono').val(resp.phone_home);
                        $('#celular').val(resp.phone_mobile);
                        $('#email').val(resp.email);
                        if (resp.tiporuc == '01') {
                            mostrarCampo('#apellidos');
                            mostrarCampo('#genero');
                        } else {
                            ocutarCampo('#apellidos');
                            ocutarCampo('#genero');
                            $('#apellidos').val('');
                            $('#genero').val('');
                        }
                    } else {
                        $('#apellidos').val('');
                        $('#genero').val('');
                    }
                    toggleModal('loader');
                });
            }
        });

        $("#linea").change(function () {
            var linea = $("#linea").val();
            $("#agencia").empty();
            $("#agencia").append('<option value="">Seleccione una agencia</option>');
            $("#asesor").empty();
            $("#asesor").append('<option value="">Seleccione un asesor</option>');
            if (linea !== '') {
                toggleModal('loader');
                $.ajax({
                    method: 'GET',
                    dataType: 'json',
                    url: '{{route('campaign.getAgencia.byLinea')}}',
                    async: true,
                    data: {
                        'linea': linea
                    }
                }).done(function (resp) {
                    jQuery.each(resp, function (id, val) {
                        $("#agencia").append('<option value="'+id+'">'+val+'</option>')
                    });
                    toggleModal('loader');
                });
            }
        });

        $("#agencia").change(function () {
            var linea = $("#linea").val();
            var agencia = $("#agencia").val();
            $("#asesor").empty();
            $("#asesor").append('<option value="">Seleccione un asesor</option>');
            if (agencia !== '') {
                toggleModal('loader');
                $.ajax({
                    method: 'GET',
                    dataType: 'json',
                    url: '{{route('campaign.getAsesores.byAgenciaLinea')}}',
                    async: true,
                    data: {
                        'linea': linea,
                        'agencia': agencia,
                    }
                }).done(function (resp) {
                    jQuery.each(resp, function (id, val) {
                        $("#asesor").append('<option value="'+id+'">'+val+'</option>')
                    });
                    toggleModal('loader');
                });
            }
        });


    </script>
    <style>
        .loader {
            color: #2773b9;
            font-size: 90px;
            text-indent: -9999em;
            overflow: hidden;
            width: 1em;
            height: 1em;
            border-radius: 50%;
            margin: 200px auto;
            position: relative;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-animation: load6 1.7s infinite ease, round 1.7s infinite ease;
            animation: load6 1.7s infinite ease, round 1.7s infinite ease;
        }
        @-webkit-keyframes load6 {
            0% {
                box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
            }
            5%,
            95% {
                box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
            }
            10%,
            59% {
                box-shadow: 0 -0.83em 0 -0.4em, -0.087em -0.825em 0 -0.42em, -0.173em -0.812em 0 -0.44em, -0.256em -0.789em 0 -0.46em, -0.297em -0.775em 0 -0.477em;
            }
            20% {
                box-shadow: 0 -0.83em 0 -0.4em, -0.338em -0.758em 0 -0.42em, -0.555em -0.617em 0 -0.44em, -0.671em -0.488em 0 -0.46em, -0.749em -0.34em 0 -0.477em;
            }
            38% {
                box-shadow: 0 -0.83em 0 -0.4em, -0.377em -0.74em 0 -0.42em, -0.645em -0.522em 0 -0.44em, -0.775em -0.297em 0 -0.46em, -0.82em -0.09em 0 -0.477em;
            }
            100% {
                box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
            }
        }
        @keyframes load6 {
            0% {
                box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
            }
            5%,
            95% {
                box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
            }
            10%,
            59% {
                box-shadow: 0 -0.83em 0 -0.4em, -0.087em -0.825em 0 -0.42em, -0.173em -0.812em 0 -0.44em, -0.256em -0.789em 0 -0.46em, -0.297em -0.775em 0 -0.477em;
            }
            20% {
                box-shadow: 0 -0.83em 0 -0.4em, -0.338em -0.758em 0 -0.42em, -0.555em -0.617em 0 -0.44em, -0.671em -0.488em 0 -0.46em, -0.749em -0.34em 0 -0.477em;
            }
            38% {
                box-shadow: 0 -0.83em 0 -0.4em, -0.377em -0.74em 0 -0.42em, -0.645em -0.522em 0 -0.44em, -0.775em -0.297em 0 -0.46em, -0.82em -0.09em 0 -0.477em;
            }
            100% {
                box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
            }
        }
        @-webkit-keyframes round {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes round {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

    </style>
</x-guest-layout>
