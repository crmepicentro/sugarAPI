<h1>Ordenes</h1>
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
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Models\DetalleGestionOportunidades::
        selectRaw('ordTaller, max(nomOrdAsesor) as nomOrdAsesor, max(ordFchaCierre) as ordFchaCierre, (sum(cantidad) * sum(cargosCobrar)) as monto ')
        ->where('auto_id', '=', $auto->id)
        ->groupby('ordTaller')->get() as $oportunidad)
                <tr>
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






