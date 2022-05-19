<div class="block-content space-y-2">
    {{ Form::open(['route' => 'postventa.indice', 'method' => 'GET', 'class' => ' g-3 align-items-center',]) }}
    <div class="form-group row">
        <div class="col-3">
            <div class="mb-4">
                @php($campo = 'search_cliente')
                {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                {{ Form::text($campo, request($campo), ['class' => 'form-control col-12', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
            </div>
        </div>
        <div class="col-3">
            <div class="mb-4">
                @php($campo = 'search_chasis')
                {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                {{ Form::text($campo, request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
            </div>
        </div>
        <div class="col-3">
            <div class="mb-4">
                @php($campo = 'search_placa')
                {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                {{ Form::text($campo, request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
            </div>
        </div>
        <div class="col-3">
            <div class="mb-4">
                @php($campo = 'search_asesor')
                {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                {{ Form::text($campo, request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-3">
            <div class="mb-4">
                @php($campo = 'search_orden')
                {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                {{ Form::text($campo, request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
            </div>
        </div>
        <div class="col-3">
            <div class="mb-4">
                @php($campo = 'search_oportunidades')
                {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                {{ Form::select($campo."[]", \App\Models\DetalleGestionOportunidades::daroportunidadeslist()->pluck('descServ','codServ'), request($campo),
           ['class' => 'js-select2 form-select form-control col-12', 'style' => 'width:100%', 'data-placeholder' => __('fo.'.$campo),'id' => $campo,'multiple']) }}
            </div>
        </div>
        <div class="col-3">
            <div class="mb-4">
                @php($campo = 'search_agencia')
                {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                {{ Form::text($campo, request($campo), ['class' => 'form-control', 'id' => $campo, 'placeholder' => __('fo.'.$campo)]) }}
            </div>
        </div>
        <div class="col-3">
            <div class="mb-4">
                @php($campo = 'search_estados')
                {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                {{ Form::select($campo, \App\Models\DetalleGestionOportunidades::daroestadoslist()->pluck('gestion_tipo','gestion_tipo'), null,
           ['class' => 'js-select2 form-select form-control col-12', 'style' => '', 'data-placeholder' => __('fo.'.$campo),'id' => $campo,'multiple']) }}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-6">
            <div class="mb-4">
                @php($campo = 'search_fechaGestion')
                {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                    <input type="text" class="form-control" id="example-daterange1" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                    <span class="input-group-text fw-semibold"> <i class="fa fa-fw fa-arrow-right"></i> </span>
                    <input type="text" class="form-control" id="example-daterange2" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="mb-4">
                @php($campo = 'search_fechaFactura')
                <div class="mb-4">
                    {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                    <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        <input type="text" class="form-control" id="example-daterange1" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        <span class="input-group-text fw-semibold"> <i class="fa fa-fw fa-arrow-right"></i> </span>
                        <input type="text" class="form-control" id="example-daterange2" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-6">
            <div class="mb-4">
                @php($campo = 'search_fechaCita')
                {{ Form::label($campo, __('fo.'.$campo), ['class' => 'form-label']) }}
                <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                    <input type="text" class="form-control" id="example-daterange1" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                    <span class="input-group-text fw-semibold"> <i class="fa fa-fw fa-arrow-right"></i> </span>
                    <input type="text" class="form-control" id="example-daterange2" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                </div>
            </div>
        </div>
        <div class="col-6"><div class="mb-4"></div></div>
    </div>

    <div class="form-group row">
        <div class="col-10">
            <div class="mb-4">
            </div>
        </div>
        <div class="col-2">
            <div class="mb-4">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </div>

    {{ Form::close() }}
</div>
