@php( $script_add = "")
@php($contador_elementos = 0)
@if($auto->detalleGestionOportunidadesagestionar->count() > 0)
    {{ Form::open(['route' => ['postventa.add_oportunidades',['userid'=> Auth::user()->email]] , 'method' => 'POST' , 'id' => 'form_add_oportunidades'.$auto->id]) }}
    <div class="mb-4">
        <div class="input-group">
            {!! Form::button('<i class="fa fa-square-plus me-1"></i> Aumentar', array(
                                        'type' => 'submit',
                                        'class' => 'btn btn-primary',
                                        'title' => 'Enviar dato',
                                        'onclick'=>'return confirm("Aumentar Codigo?")'
                                )) !!}
            @php($campo = 'search_codigos_op')
            {{ Form::text($campo, request($campo), ['class' => "form-control srco_op_$auto->id", 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
            <button type="button" class="btn btn-alt-info" onclick="buscar_opLps3('{{ "srco_op_$auto->id" }}')">
                Buscar <i class="fa fa-magnifying-glass-plus"></i>
            </button>
        </div>
    </div>
    {{ Form::close() }}
    <div id="buscar_List_Lps3{{ $auto->id }}"></div>
    <script>
        if(windowObjectReference)
            var windowObjectReference = null; // global variable

        function buscar_opLps3(campo_b_op) {
            var url_get_data = '{{ base64_encode(route('postventa.buscar_oportunidades_add',['auto_id' => $auto->id,'userid'=> Auth::user()->email,'search_codigos_op'=>'search_codigos_op__xxxA'])) }}';
            var valor_bus = $('.'+campo_b_op).val();
            url_get_data = window.atob( url_get_data ).replace('search_codigos_op__xxxA',valor_bus);

            if(windowObjectReference == null || windowObjectReference.closed)
                /* if the pointer to the window object in memory does not exist
                   or if such pointer exists but the window was closed */

            {
                windowObjectReference = window.open(url_get_data,
                    "PromoteFirefoxWindowName", "resizable,scrollbars,status");
                /* then create it. The new window will be created and
                   will be brought on top of any other window. */
            }
            else
            {
                windowObjectReference.focus();
                /* else the window reference must exist and the window
                   is not closed; therefore, we can bring it back on top of any other
                   window with the focus() method. There would be no need to re-create
                   the window or to reload the referenced resource. */
            };
        }
    </script>


    {{ Form::open(['route' => ['postventa.gestion',['userid'=> Auth::user()->email]] , 'method' => 'POST' , 'target' =>'_blank', 'id' => 'form_master'.$auto->id]) }}
    <table class="table table-hover table-vcenter" style="width: 100%">
        <thead>
        <tr class="bg-body-dark">
            <th>
                OR
            </th>
            <th>
                CL
            </th>
            <th title="ASESOR">
                AS
            </th>
            <th>
                FECHA
            </th>
            <th>
                TIPO
            </th>
            <th>
                FR
            </th>
            <th>
                CODIGO
            </th>
            <th>
                DETALLE
            </th>
            <th>
                CANT
            </th>
            <th style="text-align: end">
                VALOR<br/>UNI
            </th>
            <th style="text-align: end">
                VALOR<br/>TOT
            </th>
            <th style="background-color: #59595929;">
                NUEVA<br/>CITA
            </th>
            <th>
                GESTIÓN<br/>FUTURA
            </th>
            <th style="background-color: #59596029;">
                FECHA<br/>GESTIÓN
            </th>
            <th>Estado Global</th>
            <th>
                Nueva<br/>cita
            </th>
            <th>
                Gestión<br/>Futura
            </th>
            <th>
                Desiste
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($auto->detalleGestionOportunidadesagestionar as $oportunidad)
            <tr>
                <td title="Id Oportunidad: {{ $oportunidad->id }}">
                    {{ $oportunidad->ordTaller}}
                </td>
                <td>
                    {{ $oportunidad->tipoCL }}
                </td>
                <td>
                    <strong title="{{ $oportunidad->nomOrdAsesor }}">{{ $oportunidad->codOrdAsesor }}</strong>
                </td>
                <td>
                    <span
                        title="{{ $oportunidad->ordFchaCierre }}">{{ ($oportunidad->ordFchaCierre != null)?\Carbon\Carbon::createFromFormat(config('constants.pv_dateFormat'),$oportunidad->ordFchaCierre)->locale('es')->format('d-M'):'---' }}</span>
                </td>
                <td>
                    {{ $oportunidad->tipoServ }}
                </td>
                <td>
                    {{ $oportunidad->franquicia }}
                </td>
                <td>
                    {{ $oportunidad->codServ }}
                </td>
                <td>
                {{ $oportunidad->descServ }}
                <td>
                    {{ $oportunidad->cantidad }}
                </td>
                <td style="text-align: end">
                    {{ $oportunidad->cargosCobrar }}
                </td>
                <td style="text-align: end">
                    {{ $oportunidad->cantidad * $oportunidad->cargosCobrar }}
                </td>
                <td title="Gestionado Fecha Cita {{ \Carbon\Carbon::parse($oportunidad->cita_fecha)->diffForHumans() }}"
                    style="background-color: #5959590f;">
                    {{ $oportunidad->cita_fecha <> null ?\Carbon\Carbon::create($oportunidad->cita_fecha)->format('y-m-d'):'-' }}
                    <br/>
                    <!--                    <small>{{ \Carbon\Carbon::create($oportunidad->cita_fecha)->format('H:i') != '00:00'?\Carbon\Carbon::create($oportunidad->cita_fecha)->format('H:i'):'' }}</small>-->
                </td>
                <td title="Gestionado Fecha agendado {{ \Carbon\Carbon::parse($oportunidad->agendado_fecha)->diffForHumans() }}">
                    {{ $oportunidad->agendado_fecha <> null ?\Carbon\Carbon::create($oportunidad->agendado_fecha)->format('y-m-d'):'-' }}
                    <br/>
                    <small>{{ \Carbon\Carbon::create($oportunidad->agendado_fecha)->format('H:i') != '00:00'? \Carbon\Carbon::create($oportunidad->agendado_fecha)->format('H:i'):'' }}</small>
                </td>
                <td title="Gestionado Fecha gestion {{ \Carbon\Carbon::parse($oportunidad->gestion_fecha)->diffForHumans() }}"
                    style="background-color: #5959600f;">
                    {{ \Carbon\Carbon::create($oportunidad->gestion_fecha)->format('y-m-d') }}<br/>
                    <small>{{ \Carbon\Carbon::create($oportunidad->gestion_fecha)->format('H:i') != '00:00'? \Carbon\Carbon::create($oportunidad->gestion_fecha)->format('H:i'):'' }}</small>
                </td>
                <td>
                    {{ __($oportunidad->gestion_tipo) }}
                    @if(
                           $oportunidad->s3s_codigo_estado_taller != null
                           && $oportunidad->s3s_codigo_estado_taller != ''
                           && $oportunidad->s3s_codigo_estado_taller>0
                           )
                    <span class="btn btn-sm rounded-pill btn-outline-dark me-1 mb-3">
                        {{ __($oportunidad->nombre_estado_taller) }}
                    </span>
                    @endif
                </td>
                @if(in_array($oportunidad->gestion_tipo, ['nuevo','recordatorio','perdido','perdido_taller','cita_noshow']))
                    @if($oportunidad->stockavalible)
                    @php($contador_elementos ++)
                    <td>
                        <div class="form-check">
                            {{ Form::checkbox($oportunidad->claveunicaprincipal64."['cita']",$oportunidad->claveunicaprincipaljson,false,['class' => "form-check-input boton$oportunidad->claveunicaprincipal citKm",'id' => "id-cita$oportunidad->claveunicaprincipal"]) }}
                        </div>
                    </td>
                    @php( $script_add .= "checkLine('id-cita$oportunidad->claveunicaprincipal','boton$oportunidad->claveunicaprincipal','.pospont$oportunidad->claveunicaprincipal;.perdiot$oportunidad->claveunicaprincipal','$oportunidad->claveunicaprincipal64',nuevacita$auto->id,$auto->id );" )
                    <td>
                        <div class="row">
                            <div class="col-6">
                                {{--  <button type="button" class="btn btn-sm btn-info boton{{ $oportunidad->claveunicaprincipal }} pospont{{$oportunidad->claveunicaprincipal}}" >
                                     <i class="fa fa-clock"></i>
                                 </button>--}}
                            </div>
                            <div class="col-6 form-check">
                                {{ Form::checkbox($oportunidad->claveunicaprincipal64."['recorda']",$oportunidad->claveunicaprincipaljson,false,['class' => "form-check-input boton$oportunidad->claveunicaprincipal recKm",'id' => "id-recorda$oportunidad->claveunicaprincipal"]) }}
                            </div>
                            @php( $script_add .= "checkLine('id-recorda$oportunidad->claveunicaprincipal','boton$oportunidad->claveunicaprincipal','.pospont$oportunidad->claveunicaprincipal;.perdiot$oportunidad->claveunicaprincipal','$oportunidad->claveunicaprincipal64',recordatorio$auto->id,$auto->id);" )
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            {{-- <div class="col-6">
                                <button type="button" class="btn btn-sm btn-danger boton{{ $oportunidad->claveunicaprincipal }} perdiot{{$oportunidad->claveunicaprincipal}}" data-auto="{{ $auto->id }}">
                                    <i class="fa fa-rectangle-xmark"></i>
                                </button>
                            </div>--}}
                            <div class="col-6 form-check">
                                {{ Form::checkbox($oportunidad->claveunicaprincipal64."['perdida']",$oportunidad->claveunicaprincipaljson,false,['class' => "form-check-input boton$oportunidad->claveunicaprincipal perKm",'id' => "id-desistt$oportunidad->claveunicaprincipal"]) }}
                            </div>
                            @php( $script_add .= "checkLine('id-desistt$oportunidad->claveunicaprincipal','boton$oportunidad->claveunicaprincipal','.pospont$oportunidad->claveunicaprincipal;.perdiot$oportunidad->claveunicaprincipal','$oportunidad->claveunicaprincipal64',desiste$auto->id,$auto->id);" )
                        </div>
                    </td>
                    @else
                        <td colspan="3">Sin Stock</td>
                    @endif

                @else
                    @if($oportunidad->gestion_tipo =='cita' && $oportunidad->s3s_codigo_seguimiento == null )
                        @php( $gestion = \App\Models\Postventas\GestionAgendado::where('id',$oportunidad->Idgestion)->first())
                        @if($gestion <> null)
                            <td colspan="3" class="proc_{{ $auto->placa }}{{ $gestion->codigo_seguimiento }}">
                                <a href="javascript: consultar_orden_con_placa('{{ $gestion->codigo_seguimiento }}', '{{ $gestion->gestionagendadodetalleop[0]->agencia_cita }}','{{ $auto->placa }}')">Consulta
                                    estado </a>
                                {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array(
                                       'type' => 'button',
                                       'class' => 'btn btn-info btn-sm',
                                       'title' => 'Borrar Modelo',
                                       'name' => 'formborrad'.$oportunidad->id.'.borrado',
                                       'onclick'=>'cancelar_orden_id_gestion('.$oportunidad->id.')',
                               )) !!}

                            </td>
                        @else
                            <td colspan="3" class="sin_orden{{ $oportunidad->id }}">
                                {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array(
                                       'type' => 'button',
                                       'class' => 'btn btn-info btn-sm',
                                       'title' => 'Borrar Modelo',
                                       'name' => 'formborrad'.$oportunidad->id.'.borrado',
                                       'onclick'=>'cancelar_orden_id_gestion('.$oportunidad->id.')',
                               )) !!}
                            </td>
                        @endif
                    @else
                        @php( $gestion = \App\Models\Postventas\GestionAgendado::where('id',$oportunidad->Idgestion)->first())
                        <td colspan="2">
                            <strong>Gestionando {{ \Carbon\Carbon::parse($oportunidad->cita_fecha)->diffForHumans() }}
                                con orden {{ $oportunidad->s3s_codigo_seguimiento }}</strong></td>
                        <td>
                            <button type="button"
                                    class="btn btn-hero btn-warning act_{{ $oportunidad->s3s_codigo_seguimiento }}"
                                    onclick="actTodaOrden('{{ $oportunidad->s3s_codigo_seguimiento }}','{{ $gestion->id }}')">
                                <i class="fa fa-repeat"></i>
                            </button>
                        </td>
                    @endif
                @endif
            </tr>
            @if($loop->last)
                @if($contador_elementos > 0)
                    <tr>
                        <td colspan="15">&nbsp;</td>
                        <td>
                            <button type="button" class="btn btn-hero btn-success ejecutaCita{{ $auto->id }}"
                                    data-auto="{{ $auto->id }}" disabled
                                    onclick="bt_envioparcial({{ $auto->id }},'citKm')">
                                <i class="fa fa-check"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-hero btn-info super_agenda_{{ $auto->id }}"
                                    data-auto="{{ $auto->id }}" disabled
                                    onclick="bt_envioparcial({{ $auto->id }},'recKm')">
                                <i class="fa fa-clock"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-hero btn-danger super_perdida_{{ $auto->id }}"
                                    data-auto="{{ $auto->id }}" disabled
                                    onclick="bt_envioparcial({{ $auto->id }},'perKm')">
                                <i class="fa fa-rectangle-xmark"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="15">&nbsp;</td>
                        <td colspan="3">
                            <div class="row">
                                <button type="submit"
                                        class="btn btn-success btn-info col-12 total_accion_{{ $auto->id }}"
                                        data-auto="{{ $auto->id }}" data-porte="{{$contador_elementos}}">
                                    <i class="fa fa-floppy-disk me-1"></i>
                                    Guardar Auto
                                </button>
                            </div>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="12">&nbsp;</td>
                    </tr>
                @endif
            @endif
        @endforeach
        </tbody>
    </table>
    {{ Form::close() }}
    @section('css_before')
        @parent
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css')}}">
        <style>
            .border {
                border-right: 1px solid #ccc;
            }
        </style>
    @endsection
    @section('js_after')
        @parent
        <script>
            /**/
            {!! $script_add !!}/**/
            $(function () {
                submitFomr('{{ $auto->id }}')
            });
        </script>
    @endsection
@else
    <h1>Sin Oportunidades</h1>
@endif

