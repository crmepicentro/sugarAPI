<div class="row">
    <div class="col-12 order-3 col-sm-12 order-sm-3 col-md-10 order-md-0">
        <table class="table-striped table-sm">
            <thead>
            <tr class="bg-body-dark">
                <th>
                    OR
                </th>
                <th>
                    ASESOR
                </th>
                <th>
                    FECHA FACTURA
                </th>
                <th>
                    USUARIO
                </th>
                <th>
                    MONTO
                </th>
                <th>
                    1ER GESTION
                </th>
                <th>
                    1ER GESTION ESTADO
                </th>
                <th>
                    GESTION FUTURA
                </th>
                <th>
                    GESTION ESTADO
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Models\DetalleGestionOportunidades::
        selectRaw('ordTaller, max(nomOrdAsesor) as nomOrdAsesor, max(ordFchaCierre) as ordFchaCierre, (sum(cantidad) * sum(cargosCobrar)) as monto, min(gestion_fecha) as primer_gestion, min(gestion_tipo) as primer_gestion_estado, min(agendado_fecha) as gestion_futura, max(gestion_tipo) as ultima_gestion_estado')
        ->where('auto_id', '=', $auto->id)
        ->agestionar()
        ->groupby('ordTaller')->get() as $oportunidad)
                <tr id="{{ $auto->id }}">
                    <td>
                        {{ $oportunidad->ordTaller}}
                    </td>
                    <td>
                        {{ $oportunidad->nomOrdAsesor }}
                    </td>
                    <td>
                        {{ $oportunidad->ordFchaCierre }}
                    </td>
                    <td>
                        USUARIO
                    </td>
                    <td>
                        ${{ $oportunidad->monto }}
                    </td>
                    <td>
                        {{ $oportunidad->primer_gestion }}
                    </td>
                    <td>
                        {{ __($oportunidad->primergestioestado) }}
                    </td>
                    <td>
                        {{ $oportunidad->gestion_futura }}
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
        <a href="{{ route('postventa.edita_auto',[ 'id' => $propietario->id ,'id_auto'  => $auto->id ]) }}"><i class="fa fa-pen-to-square"></i></a>
    </div>
    <div class="col-12 order-1 col-sm-12 order-sm-1 col-md-1 order-md-2">
        <a href="{{ route('postventa.consultaHistorial_pdf', [ 'placa_vehiculo' => $auto->placa]) }}" target="_blank"><i class="fa fa-file-pdf"></i></a>
    </div>
</div>






