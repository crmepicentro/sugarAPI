<div id="autosAC" role="tablist" aria-multiselectable="true">
    @foreach( $propietario->autosgestion as $auto)
    <div class="block block-rounded mb-1">
        <div class="block-header block-header-default" role="tab" id="autosAC_h{{$loop->index}}">
            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#autosAC" href="#autosAC_q{{$loop->index}}" aria-expanded="true" aria-controls="autosAC_q{{$loop->index}}">PLACA: {{ $auto->placa }} | {{ $auto->modelo }} | {{ $auto->descVehiculo }}</a>
        </div>
        <div id="autosAC_q{{$loop->index}}" class="collapse show" role="tabpanel" aria-labelledby="autosAC_h{{$loop->index}}" style="">
            <div class="block-content">
                @include('postventas.auto.lista_auto_ordenes')
            </div>
        </div>
    </div>
    @endforeach
</div>
