<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
      //
        '/vehiculos/faces/jsp/consulta/masters/detalle.jsp/gestion_data',
        '/vehiculos/faces/jsp/consulta/masters/detalle.jsp/gestion_final/*/*',
    ];
}
