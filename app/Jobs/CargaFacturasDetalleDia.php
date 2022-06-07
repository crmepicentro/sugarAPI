<?php

namespace App\Jobs;

use App\Http\Controllers\Postventas\Servicios3sController;
use App\Models\Ws_logs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CargaFacturasDetalleDia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $codAgencia ;
    private $codOrdenTaller;
    private $s3sdato;
    private $auto;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($codAgencial , $codOrdenTaller,$s3sdato,$auto)
    {
        $this->codAgencia = $codAgencial;
        $this->codOrdenTaller = $codOrdenTaller;
        $this->s3sdato = $s3sdato;
        $this->auto = $auto;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $servicios3sController = new Servicios3sController();

        $detalle = $servicios3sController->consultaApiDetalleCabecera_main($this->codAgencia, $this->codOrdenTaller);
        $ws_logs = Ws_logs::find($detalle['ws_logs']);

        if($detalle['nomMensaje'] == 'EXITO' ){
            foreach ($detalle['listaOrdenTallerCL'] as $detalle_dato){
                $servicios3sController->guardar_detalle_orden($this->s3sdato,$detalle_dato, $this->auto, $ws_logs);
            }
        }

    }
}
