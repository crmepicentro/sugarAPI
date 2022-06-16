<script>
    function recargasitio_sobresscrito() {
        console.log('recargasitio_sobresscrito');
        console.log(Date.now());
        location.reload();
    }
    @if($autorefresca)
    recargasitio_sobresscrito();
    @endif
</script>

