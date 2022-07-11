
<!-- Dynamic Table Full -->
<div class="block block-rounded">
    <table class="table table-bordered table-striped table-vcenter table-sm">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Cliente</th>
            <th class="d-none d-sm-table-cell" style="width: 15%;">Teléfono</th>
<!--            <th class="d-none d-sm-table-cell">RFM</th>
            <th class="d-none d-sm-table-cell" >R</th>
            <th class="d-none d-sm-table-cell" >F</th>
            <th class="d-none d-sm-table-cell" >M</th>-->
            <th class="d-none d-sm-table-cell" >VHC-OR-OP</th>
            <th class="d-none d-sm-table-cell" >Fecha Facturación</th>
            <th class="d-none d-sm-table-cell" style="width: 15%;">1er Gestión Fecha</th>
            <!--<th class="d-none d-sm-table-cell" style="width: 15%;">1er Gestión Estado</th>-->
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
                <td class="text-center" title="{{$lista_oportunidade->select_original}}">{{$loop->index + 1}}</td>
                <td class="fw-semibold">
                    <a href="#">{{ $lista_oportunidade->nombre_propietario }}</a>
                </td>
                <td class="d-none d-sm-table-cell">
                    {{ $lista_oportunidade->telefono_domicilio ?? $lista_oportunidade->telefono_domicilio ?? $lista_oportunidade->telefono_celular ?? 'No tiene' }}
                    {!! ($lista_oportunidade->telefono_trabajo != '' )?"<br>".$lista_oportunidade->telefono_trabajo:"" !!}
                    {!! ($lista_oportunidade->telefono_celular != '' )?"<br>".$lista_oportunidade->telefono_celular:"" !!}
                </td>
<!--                <td class="d-none d-sm-table-cell">{{ 'RFM' }}</td>
                <td class="d-none d-sm-table-cell">{{ 'R' }}</td>
                <td class="d-none d-sm-table-cell">{{ 'F' }}</td>
                <td class="d-none d-sm-table-cell">{{ 'M' }}</td>-->
                <td class="d-none d-sm-table-cell" title="{{ $lista_oportunidade->cant_op_p }}">{{ $lista_oportunidade->cantidad_autos }}-{{ $lista_oportunidade->cantidad_ordenes }}-{{ $lista_oportunidade->cant_op_p }}</td>
                <td class="d-none d-sm-table-cell">
                    @if($lista_oportunidade->ordFchaCierre != '')
                        @if(\Carbon\Carbon::createFromFormat('d-m-Y', $lista_oportunidade->ordFchaCierre)->greaterThan(\Carbon\Carbon::now()->sub('1 day')))
                            <span class="badge bg-success"> {{ $lista_oportunidade->ordFchaCierre }}</span>
                        @elseif( \Carbon\Carbon::createFromFormat('d-m-Y', $lista_oportunidade->ordFchaCierre)->greaterThan(\Carbon\Carbon::now()->sub('2 day')))
                            <span class="badge bg-warning">{{ $lista_oportunidade->ordFchaCierre }}</span>
                        @else
                            <span class="badge bg-danger">{{ $lista_oportunidade->ordFchaCierre }}</span>
                        @endif
                    @else
                        <span class="badge bg-danger"><u>Sin fecha de Factura</u></span>
                    @endif
                </td>
                <td class="d-none d-sm-table-cell">{{ $lista_oportunidade->primer_gestion_v2 }}</td>
                <!--                        <td class="d-none d-sm-table-cell">{{ $lista_oportunidade->primer_gestion_estado_v2 }}</td>-->
                <td><a href="{{ route('postventa.edita', ['id' => $lista_oportunidade->id_p,'userid'=> Auth::user()->email]) }}" >
                        <i class="fa fa-play"></i>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">{{ $lista_oportunidade->agendado_fecha }}</td>
                <td>{{ __($lista_oportunidade->cita_fecha) }}</td>
                <td>
                    {{ __($lista_oportunidade->gestion_tipo) }}
                    @php( $detalle_gestions = \App\Models\Postventas\Auto::where('id',$lista_oportunidade->id)->first()->detalleGestionOportunidadesagestionar() )
                    @foreach(
                        $detalle_gestions->groupby('s3s_codigo_estado_taller')
                        ->selectRaw('s3s_codigo_estado_taller, count(\'s3s_codigo_estado_taller\') AS contago ')
                        ->get() as $detalle_gestion)
                        @if(
                            $detalle_gestion->s3s_codigo_estado_taller != null
                            && $detalle_gestion->s3s_codigo_estado_taller != ''
                            && $detalle_gestion->s3s_codigo_estado_taller>0
                            )
                        <span class="btn btn-sm rounded-pill btn-outline-dark me-1 mb-3">
                            {{ __($detalle_gestion->nombre_estado_taller) }}
                            <span class="badge rounded-pill bg-info">{{ $detalle_gestion->contago }}</span>
                        </span>
                        @endif
                    @endforeach
                </td>
                <td>{{ $lista_oportunidade->s3s_codigo_seguimiento }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{ $lista_oportunidades->links('vendor.pagination.bootstrap-4') }}
</div>
<!-- END Dynamic Table Full -->
