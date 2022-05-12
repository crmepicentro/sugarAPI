<div class="col-12">
    <div class="row g-sm block block-rounded">
        <div class="col-6 bg-body-dark">
            <div class="block-content">
                <strong>Propietario</strong>
            </div>
        </div>
        <div class="col-6">
            <div class="block-content">
                {{$propietario->nombre_propietario}}
            </div>

        </div>
    </div>
</div>
<div class="col-12">
    <div class="row g-sm block block-rounded">
        <div class="col-6 bg-body-dark">
            <div class="block-content">
                <strong>RFM</strong>
            </div>
        </div>
        <div class="col-6">
            <div class="block-content">
                {{ "RFM" }}
            </div>

        </div>
    </div>
</div>
<div class="col-12">
    <div class="row g-sm block block-rounded">
        <div class="col-6 bg-body-dark">
            <div class="block-content">
                <strong>Vehiculos</strong>
            </div>
        </div>
        <div class="col-6">
            <div class="block-content">
                {{ $propietario->autos->count() }}
            </div>

        </div>
    </div>
</div>
<div class="col-12">
    <div class="row g-sm block block-rounded">
        <div class="col-6 bg-body-dark">
            <div class="block-content">
                <strong>MAIL | FONO</strong>
            </div>
        </div>
        <div class="col-6">
            <div class="block-content">
                {{ $propietario->email_propietario }} {{ ($propietario->email_propietario_2 != '' )?" | ".$propietario->email_propietario_2:"" }}|
                {{ $propietario->telefono_domicilio ?? $propietario->telefono_domicilio ?? $propietario->telefono_celular ?? 'No tiene' }}
                {{ ($propietario->telefono_trabajo != '' )?" | ".$propietario->telefono_trabajo:"" }}
                {{ ($propietario->telefono_celular != '' )?" | ".$propietario->telefono_celular:"" }}
            </div>
        </div>
    </div>
</div>
