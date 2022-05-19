<!-- Dynamic Table Full -->
<div class="block block-rounded">
    <table class="table table-bordered table-striped table-vcenter table-sm">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Cliente</th>
            <th class="d-none d-sm-table-cell" style="width: 15%;">Teléfono</th>
            <th class="d-none d-sm-table-cell" style="width: 15%;">RFM</th>
            <th class="d-none d-sm-table-cell" style="width: 15%;">R</th>
            <th class="d-none d-sm-table-cell" style="width: 15%;">F</th>
            <th class="d-none d-sm-table-cell" style="width: 15%;">M</th>
            <th class="d-none d-sm-table-cell" style="width: 15%;">VHC</th>
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
                <td class="text-center">{{$loop->index + 1}}</td>
                <td class="fw-semibold">
                    <a href="#">{{ $lista_oportunidade->nombre_propietario }}</a>
                </td>
                <td class="d-none d-sm-table-cell">
                    {{ $lista_oportunidade->telefono_domicilio ?? $lista_oportunidade->telefono_domicilio ?? $lista_oportunidade->telefono_celular ?? 'No tiene' }}
                    {!! ($lista_oportunidade->telefono_trabajo != '' )?"<br>".$lista_oportunidade->telefono_trabajo:"" !!}
                    {!! ($lista_oportunidade->telefono_celular != '' )?"<br>".$lista_oportunidade->telefono_celular:"" !!}
                </td>
                <td class="d-none d-sm-table-cell">{{ 'RFM' }}</td>
                <td class="d-none d-sm-table-cell">{{ 'R' }}</td>
                <td class="d-none d-sm-table-cell">{{ 'F' }}</td>
                <td class="d-none d-sm-table-cell">{{ 'M' }}</td>
                <td class="d-none d-sm-table-cell">{{ $lista_oportunidade->cantidad_autos }}</td>
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
    {{ $lista_oportunidades->links() }}
</div>
<!-- END Dynamic Table Full -->
