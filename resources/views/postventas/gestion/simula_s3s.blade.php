<h1>Datos del auto para gestionar</h1>
<code>
    <pre>
    {{ print_r($gestionAgendado->citas3s,true) }}
    </pre>
    <hr>
    <pre>
    {{ json_encode($gestionAgendado->citas3s) }}
    </pre>
</code>

<a href="{{ route('postventa.s3spostdatacorerespuesta',['codigo_seguimiento' =>$gestionAgendado->codigo_seguimiento,'respuesta'=> Str::random(10)]) }}" class="btn btn-primary">Respuesta de S3S</a>
