<script>
    function basicPopup(url) {
        popupWindow = window.open(url,'popUpWindow','height=900,width=900,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
    }
    //basicPopup('https://www.google.com');
</script>
<h1>S3S sistema</h1>
<code >
    <pre>
         {{
    print_r(
	["gestion_id" => $gestionAgendado->codigo_seguimiento,
    "gestion_comentario" => $gestionAgendado->fecha_agendado,
	"codAgencia"=> "15",
	"placa_auto"=> $auto->placa,

	"user_name"=> "MA_TORO",
	"oportunidades"=>$gestionAgendado->detalleoportunidad->pluck('claveunicaprincipals3s'),
])
}}
    </pre>
</code>

