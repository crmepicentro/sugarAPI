<?php

namespace App\Jobs;

use App\Models\Postventas\DetalleGestionOportunidades;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ChequearStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $detalleGestionOportunidades;
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DetalleGestionOportunidades $detalleGestionOportunidades, User $user)
    {
        $this->detalleGestionOportunidades = $detalleGestionOportunidades;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Auth::loginUsingId($this->user->id);
        //echo print_r($this->detalleGestionOportunidades->stockavalible,true);
        $this->detalleGestionOportunidades->stockavalible;
    }
}
