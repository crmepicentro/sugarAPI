@php( $script_add = "")
{{ Form::open(['route' => 'postventa.gestion' , 'method' => 'POST' , 'target' =>'_blank', 'id' => 'form_master'.$auto->id]) }}
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
                TIPO DE TRABAJO
            </th>
            <th>
                FECHA DE GESTIÓN
            </th>
            <th>
                FECHA DE FACTURA GANADA
            </th>
            <th>
                Nueva Cita
            </th>
            <th>
                Recordatorio
            </th>
            <th>
                Desiste
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($auto->detalleGestionOportunidades as $oportunidad)
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
                ${{ $oportunidad->cantidad * $oportunidad->cargosCobrar }}
            </td>
            <td>
                {{ $oportunidad->codServ }}|{{ $oportunidad->descServ }}
            </td>
            <td>
                FECHA DE GESTIÓN
            </td>
            <td>
                FECHA DE FACTURA GANADA
            </td>
            <td>
                <div class="form-check">
                    {{ Form::checkbox($oportunidad->claveunicaprincipal64."['cita']",$oportunidad->claveunicaprincipaljson,false,['class' => "form-check-input boton$oportunidad->claveunicaprincipal",'id' => "id-cita$oportunidad->claveunicaprincipal"]) }}
                </div>
            </td>
            @php( $script_add .= "checkLine('id-cita$oportunidad->claveunicaprincipal','boton$oportunidad->claveunicaprincipal','.pospont$oportunidad->claveunicaprincipal;.perdiot$oportunidad->claveunicaprincipal','$oportunidad->claveunicaprincipal64',nuevacita$auto->id,$auto->id );" )
            <td >
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-sm btn-info boton{{ $oportunidad->claveunicaprincipal }} pospont{{$oportunidad->claveunicaprincipal}}" data-bs-toggle="modal" data-bs-target="#modal-default-vcenter" >
                            <i class="fa fa-clock"></i>
                        </button>
                    </div>
                    <div class="col-6 form-check">
                        {{ Form::checkbox($oportunidad->claveunicaprincipal64."['recorda']",$oportunidad->claveunicaprincipaljson,false,['class' => "form-check-input boton$oportunidad->claveunicaprincipal",'id' => "id-recorda$oportunidad->claveunicaprincipal"]) }}
                    </div>
                    @php( $script_add .= "checkLine('id-recorda$oportunidad->claveunicaprincipal','boton$oportunidad->claveunicaprincipal','.pospont$oportunidad->claveunicaprincipal;.perdiot$oportunidad->claveunicaprincipal','$oportunidad->claveunicaprincipal64',recordatorio$auto->id,$auto->id);" )
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-sm btn-danger js-swal-op-perdida boton{{ $oportunidad->claveunicaprincipal }} perdiot{{$oportunidad->claveunicaprincipal}}" data-auto="{{ $auto->id }}">
                            <i class="fa fa-rectangle-xmark"></i>
                        </button>
                    </div>
                    <div class="col-6 form-check">
                        {{ Form::checkbox($oportunidad->claveunicaprincipal64."['perdida']",$oportunidad->claveunicaprincipaljson,false,['class' => "form-check-input boton$oportunidad->claveunicaprincipal",'id' => "id-desistt$oportunidad->claveunicaprincipal"]) }}
                    </div>
                    @php( $script_add .= "checkLine('id-desistt$oportunidad->claveunicaprincipal','boton$oportunidad->claveunicaprincipal','.pospont$oportunidad->claveunicaprincipal;.perdiot$oportunidad->claveunicaprincipal','$oportunidad->claveunicaprincipal64',desiste$auto->id,$auto->id);" )
                </div>
            </td>
        </tr>
        @if($loop->last)
            <tr>
                <td colspan="8">&nbsp;</td>
                <td>

                    <button class="btn btn-hero btn-success ejecutaCita{{ $auto->id }}"  data-auto="{{ $auto->id }}">
                        <i class="fa fa-check"></i>
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-hero btn-info super_agenda_{{ $auto->id }}" data-bs-toggle="modal" data-bs-target="#modal-default-vcenter"  disabled >
                        <i class="fa fa-clock"></i>
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-hero btn-danger js-swal-op-perdida super_perdida_{{ $auto->id }}" data-auto="{{ $auto->id }}"  disabled>
                        <i class="fa fa-rectangle-xmark"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td colspan="8">&nbsp;</td>
                <td colspan="3">
                    <div class="row">
                        <button type="submit" class="btn btn-success btn-info col-12 total_accion_{{ $auto->id }}"  data-auto="{{ $auto->id }}" data-porte="{{$loop->index + 1}}" >
                            <i class="fa fa-floppy-disk me-1"></i>
                            Guardar Auto
                        </button>
                    </div>
                </td>
            </tr>
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
@section('js_after') @parent
<script>
    /**/{!! $script_add !!}/**/
    $(function() { submitFomr('{{ $auto->id }}') });
</script>
@endsection


