<?php

namespace App\Jobs;

use App\Http\Controllers\Servicios3sController;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CargaFacturasDia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $fecha;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Carbon $fecha = null)

    {
        if($fecha == null){
            $fecha = Carbon::now();
        }
        $this->fecha = $fecha;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $servicios3sController = new Servicios3sController();
        $proceso = $servicios3sController->guardar_consulta(
            $this->fecha->subDays(1)->format(config('constants.pv_dateFormat')),
            $this->fecha->subDays(-1)->format(config('constants.pv_dateFormat'))
        );
    }
}
