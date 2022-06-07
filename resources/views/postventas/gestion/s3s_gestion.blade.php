@include('postventas.gestion.finaliza_gestion',[ 'autorefresca' => false])
<script>
    var windowObjectReference = null; // global variable

    function openFFPromotionPopup() {
        if(windowObjectReference == null || windowObjectReference.closed)
            /* if the pointer to the window object in memory does not exist
               or if such pointer exists but the window was closed */

        {
            windowObjectReference = window.open("{{ route('postventa.s3spostdatacore',['gestionAgendado'=> $gestionAgendado, 'auto' => $auto,'userid'=> Auth::user()->email] ) }}",
                "PromoteFirefoxWindowName", "resizable,scrollbars,status");
            recargasitio_sobresscrito();
            /* then create it. The new window will be created and
               will be brought on top of any other window. */
        }
        else
        {
            windowObjectReference.focus();
            /* else the window reference must exist and the window
               is not closed; therefore, we can bring it back on top of any other
               window with the focus() method. There would be no need to re-create
               the window or to reload the referenced resource. */
        };
    }
</script>
<h1>S3S sistema</h1>
<code >
    <pre>
        <p><a
                href="{{ route('postventa.s3spostdatacore',['gestionAgendado'=> $gestionAgendado, 'auto' => $auto,'userid'=> Auth::user()->email] ) }}"
                target="PromoteFirefoxWindowName"
                onclick="openFFPromotionPopup(); return false;"
                title="Apertura de ventana del S3S"
                class="btn btn-lg rounded-pill btn-hero btn-success me-1 mb-3"
            ><i class="fa fa-fw fa-play me-1"></i> Envia Datos a S3S</a></p>
    </pre>
</code>

