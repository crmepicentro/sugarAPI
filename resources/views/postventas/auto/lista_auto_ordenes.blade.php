<div class="row">
    <div class="col-12 order-3 col-sm-12 order-sm-3 col-md-10 order-md-0">
        <table class="table table-sm table-vcenter" style="width: 100%">
            <thead>
            <tr class="bg-body-dark">
                <th>
                    OR
                </th>
                <th>
                    AS
                </th>
                <th>
                    FECHA
                </th>
                <th>
                    USUARIO
                </th>
                <th>
                    MONTO
                </th>
                <th>
                    1ER<br/> GESTIÓN
                </th>
                <th>
                    1ER<br/> GESTIÓN<br/> ESTADO
                </th>
                <th>
                    GESTIÓN<br/> FUTURA
                </th>
                <th>
                    GESTIÓN<br/> ESTADO
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Models\Postventas\DetalleGestionOportunidades::
        selectRaw('ordTaller, max(nomUsuarioVista) as nomUsuarioVista, max(codOrdAsesor) as codOrdAsesor,max(nomOrdAsesor) as nomOrdAsesor, max(ordFchaCierre) as ordFchaCierre, (sum(cantidad) * sum(cargosCobrar)) as monto, min(gestion_fecha) as primer_gestion, min(gestion_tipo) as primer_gestion_estado, min(agendado_fecha) as gestion_futura, max(gestion_tipo) as ultima_gestion_estado')
        ->where('auto_id', '=', $auto->id)
        ->agestionar()
        ->groupby('ordTaller')->get() as $oportunidad)
                <tr id="{{ $auto->id }}">
                    <td>
                        {{ $oportunidad->ordTaller}}
                    </td>
                    <td>
                        <strong title="{{ $oportunidad->nomOrdAsesor }}">{{ $oportunidad->codOrdAsesor }}</strong>
                    </td>
                    <td>
                        {{ $oportunidad->ordFchaCierre }}
                    </td>
                    <td>
                        {{ $oportunidad->nomUsuarioVista }}
                    </td>
                    <td style="text-align: end;">
                        <span>{{ $oportunidad->monto }}</span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::create($oportunidad->primer_gestion)->format('y-m-d') }}<br>
                        {{ \Carbon\Carbon::create($oportunidad->primer_gestion)->format('H:i') != '00:00'?\Carbon\Carbon::create($oportunidad->primer_gestion)->format('H:i'):'' }}
                    </td>
                    <td>
                        @switch($oportunidad->primergestioestado)
                            @case('cita')
                                <span class="badge rounded-pill bg-success"
                                      title="{{ \Carbon\Carbon::create($oportunidad->gestion_futura)->diffForHumans() }}">{{ __($oportunidad->primergestioestado) }}</span>
                                @break
                            @case('recordatorio')
                                <span class="badge rounded-pill bg-primary"
                                      title="{{ \Carbon\Carbon::create($oportunidad->gestion_futura)->diffForHumans() }}">{{ __($oportunidad->primergestioestado) }}</span>
                                @break
                            @case('perdido')
                                <span class="badge rounded-pill bg-warning">{{ __($oportunidad->primergestioestado) }}</span>
                                @break
                        @endswitch
                        {{ __() }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::create($oportunidad->gestion_futura)->format('y-m-d') }}<br>
                        {{ \Carbon\Carbon::create($oportunidad->gestion_futura)->format('H:i') != '00:00'?\Carbon\Carbon::create($oportunidad->gestion_futura)->format('H:i'):'' }}
                    </td>
                    <td>
                        @foreach($oportunidad->gestionestados as $gestionestado)
                            @switch($gestionestado)
                                @case('cita')
                                    <span class="badge rounded-pill bg-success">{{ __($gestionestado) }}</span>
                                    @break
                                @case('recordatorio')
                                    <span class="badge rounded-pill bg-primary">{{ __($gestionestado) }}</span>
                                    @break
                                @case('perdido')
                                    <span class="badge rounded-pill bg-warning">{{ __($gestionestado) }}</span>
                                    @break
                            @endswitch

                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-12 order-0 col-sm-12 order-sm-0 col-md-1 order-md-1">
        <a href="{{ route('postventa.edita_auto',[ 'id' => $propietario->id ,'id_auto'  => $auto->id ,'userid'=> Auth::user()->email]) }}"><i
                    class="fa fa-pen-to-square"></i></a>
    </div>
    <div class="col-12 order-1 col-sm-12 order-sm-1 col-md-1 order-md-2">
        <a href="{{ route('postventa.consultaHistorial_pdf', [ 'placa_vehiculo' => $auto->placa ,'userid'=> Auth::user()->email]) }}"
           target="_blank"><i class="fa fa-file-pdf"></i></a>
    </div>
</div>






