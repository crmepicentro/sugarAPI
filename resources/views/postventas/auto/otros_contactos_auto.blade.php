<!-- Block Tabs Animated Slide Right -->
<div class="block block-rounded">
    <ul class="nav nav-tabs nav-tabs-block" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="btabs-animated-slideright-home-tab" data-bs-toggle="tab" data-bs-target="#btabs-animated-slideright-home" role="tab" aria-controls="btabs-animated-slideright-home" aria-selected="true">Usuario</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="btabs-animated-slideright-profile-tab" data-bs-toggle="tab" data-bs-target="#btabs-animated-slideright-profile" role="tab" aria-controls="btabs-animated-slideright-profile" aria-selected="false">Factura</button>
        </li>
    </ul>
    <div class="block-content tab-content overflow-hidden">
        <div class="tab-pane fade fade-right active show overflow-auto" id="btabs-animated-slideright-home" role="tabpanel" aria-labelledby="btabs-animated-slideright-home-tab">
            <div class="overflow-scroll" style="height: 130px">
                <ul class="list-group"><!--TODO Colocar como tabla.-->
                    @if(isset($propietario->autosgestion))
                        @foreach($propietario->autosgestion as $auto_particular)
                            @foreach($auto_particular->usuaariosautosunicos as $usuario)
                                <li class="list-group-item"><strong>{{ $auto_particular->placa }}|</strong>{{ $usuario->nomUsuarioVista }}|{{ $usuario->fonoCelUsuarioVisita }}|{{ $usuario->mailUsuarioVisita }}</li>
                            @endforeach
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="tab-pane fade fade-right" id="btabs-animated-slideright-profile" role="tabpanel" aria-labelledby="btabs-animated-slideright-profile-tab">
            <div class="overflow-scroll" style="height: 130px">
                <ul class="list-group">
                    @if(isset($propietario->autosgestion))
                        @foreach($propietario->autosgestion as $auto_particular)
                            @foreach($auto_particular->facturasunicos as $factura)
                                <li class="list-group-item"><strong>{{ $auto_particular->placa }}|</strong>{{ $factura->ciCliFactura }}|{{ $factura->nomCliFactura }}|{{ $factura->mail1CliFactura }}|{{ $factura->mali2CliFactura }}</li>
                            @endforeach
                        @endforeach
                    @endif
                </ul>
            </div>
            <p></p>
        </div>
    </div>
</div>
<!-- END Block Tabs Animated Slide Right -->
