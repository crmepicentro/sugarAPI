{{ Form::open(['route' => ['postventa.gestion_do_final' ,['gestionAgendado'=> $gestion, 'auto' => $auto]] ,'method' => 'POST' , 'target' =>'_blank', 'id' => 'form_fin_gestion'.$auto->id ]) }}
<div class="p-5">
    <p class="text-muted">
    @if(!empty($nuevacitas))
        <h3><i class="fa fa-info-circle"></i>Cita S3S</h3>
        <p>
            {{ Form::select('nuevacitas', [
                '---' => 'Escoja una opción...',
                '03' => 'SERVICIO NORTE',
                '12' => 'CUMBAYA',
                '19' => 'SUR',
                '15' => 'GRANADOS',
                '18' => 'CONDADO',
                '23' => 'SANTO DOMINGO',
                '14' => 'LOS CHILLOS',
                '07' => 'CARRION',
                '20' => 'COCA',
            ], null, ['class' => 'form-control', 'style' => 'width: 100%', 'data-placeholder' => 'Escoja Uno..','id' => 'nuevacitas']) }}
        <div class="mb-4">
            <label class="form-label" for="comentario_nuevacita">Comentario</label>
            <textarea class="form-control" id="comentario_nuevacita" name="comentario_nuevacita" rows="4" placeholder="Comentario.."></textarea>
        </div>
        <div class="mb-4">
            <label class="form-label" for="comentario_nuevacita">Fecha, Hora y Agente</label>
            <br>
            <a class="btn btn-sm btn-hero btn-dark me-1 mb-3" href="http://talleres.casabaca.com/externo/reservar-cita/ajax-listar-asesores?sucursal=005&fecha=2022-05-18"
             target="_blank" >
                <i class="fa fa-fw fa-calendar-day me-1"></i> Elige Fecha, Hora y Agente
            </a>
        </div>
        </p>
    @endif
    @foreach($nuevacitas as $nuevacita)
        {{ Form::hidden('id_cita[]', $nuevacita) }}
    @endforeach
    @if(!empty($desistes))
        <h3><i class="fa fa-info-circle"></i>Razon de desestimiento.</h3>
        <p>
            {{ Form::select('razon_desestimiento', [
                '0' => '--Seleccione una opción --',
                '1' => 'Razon 1',
                '2' => 'Razon 2',
                '3' => 'Razon 3',
            ], null, ['class' => 'form-control', 'style' => 'width: 100%', 'data-placeholder' => 'Escoja Uno..', 'id'=>'razon_desestimiento']) }}
        </p>
        @foreach($desistes as $desiste)
            {{ Form::hidden('id_desiste[]', $desiste) }}
        @endforeach
    @endif


    @if(!empty($recordatorios))
        <h3><i class="fa fa-info-circle"></i>Gestiones Futuras.</h3>
        <div class="row">
            <div class="mb-4">
                <label class="form-label" for="agenda_asunto">Asunto</label>
                <input class="form-control" name="agenda_asunto" id="agenda_asunto" placeholder="Asunto.." />
            </div>
            <div class="mb-4">
                <label class="form-label" for="comentario_asunto">Comentario</label>
                <textarea class="form-control" id="comentario_asunto" name="comentario_asunto" rows="4" placeholder="Comentario.."></textarea>
            </div>
            <div class="row">
                <div class="col-xl-7 mb-4">
                    <label class="form-label" for="agenda_fecha">Fecha de Agenda</label>
                    <input type="text" class="js-flatpickr form-control " id="agenda_fecha" name="agenda_fecha" data-date-format="d/m/Y H:m" data-enable-time="true" readonly="readonly">
                </div>
            </div>
        </div>
        <script>Dashmix.helpersOnLoad(['js-flatpickr','jq-validation']); </script>
        @foreach($recordatorios as $recordatorio)
            {{ Form::hidden('id_recordatorio[]', $recordatorio) }}
        @endforeach
        @endif
        </p>
</div>
<div class="modal-footer">
    <div class="col-sm-6 col-xl-4">
        <button type="submit" id="gestion_fin_{{$auto->id}}" class="btn btn-success js-click-ripple-enabled" data-toggle="click-ripple" style="overflow: hidden; position: relative; z-index: 1;">
            <span class="click-ripple animate" style="height: 92px; width: 92px; top: -18.5px; left: -0.1875px;"></span>Success
        </button>
    </div>
</div>
<script>
    submitFormFinGestion({{$auto->id}});
</script>
{{ Form::close() }}
