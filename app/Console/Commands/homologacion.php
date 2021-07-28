<?php

namespace App\Console\Commands;

use App\Models\Interacciones;
use App\Models\InteraccionesCstm;
use App\Models\Prospeccion;
use App\Models\ProspeccionCstm;
use App\Models\Talks;
use App\Models\TalksCstm;
use App\Models\Tickets;
use App\Models\TicketsCstm;
use App\Models\Traffic;
use App\Models\TrafficCstm;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class homologacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'homologacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Homologación de datos para medio y fuente';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $user_auth = Auth::user();
            if(!$user_auth){
                $user = Auth::loginUsingId(1);

                if($user->fuente !== 'tests_source'){
                    $user->connection = 'prod';
                }
            }
            $inicio = date('h:i:s');
            $this->interaccion();
            $this->ticket();
            $this->prospeccion();
            $this->trafico();
            $this->negocio();
            $this->info('Inicio: '.$inicio);
            $this->info('Fin: '.date('h:i:s'));
        }catch (\Exception $e){
            \DB::connection(get_connection())->rollBack();
            $this->error($e->getMessage() . '- Line: '.$e->getLine(). '- Archivo: '.$e->getFile());
        }
    }

    protected function interaccion()
    {
        $j= 1;
        do {
            \DB::connection(get_connection())->beginTransaction();

            $interacciones = Interacciones::select('cbt_interaccion_digital.id','fuente','id_c','cb_lineanegocio.name','cbt_interaccion_digital_cstm.fuente_descripcion_c')
                                            ->leftJoin('cbt_interaccion_digital_cstm', 'cbt_interaccion_digital_cstm.id_c', 'cbt_interaccion_digital.id')
                                            ->leftJoin('cb_lineanegocio', 'cb_lineanegocio.id', 'cbt_interaccion_digital.cb_lineanegocio_id_c')
                                            ->where('cbt_interaccion_digital_cstm.medio_c', null)->limit(10000)->get();
            foreach ($interacciones as $item) {
                $fuente = 6;
                switch ($item->fuente) {
                    case 'jivochat':
                        $medio = $item->name && ($item->name == 'SEMINUEVOS' || $item->name == 'SEMINUEVOS TOMA') ? 25 :13;
                        break;
                    case 'tde':
                    case '9':
                        $medio = 18;
                        break;
                    case '2':
                        $medio = 13;
                        break;
                    case '3':
                        $medio = 25;
                        break;
                    case '1':
                    case 'whatsapp':
                        $medio = $item->name && ($item->name == 'SEMINUEVOS' || $item->name == 'SEMINUEVOS TOMA') ? 26 :14;
                    break;
                    case '14':
                    case 'formulario':
                        $medio = 15;
                        break;
                    case 'acton':
                        $medio = 22;
                        break;
                    case 'facebook_tde':
                        $medio = 11;
                        break;
                    case 'facebook':
                        $medio = $item->name && ($item->name == 'SEMINUEVOS' || $item->name == 'SEMINUEVOS TOMA') ? 27 :11;
                        break;
                    case 'inconcert':
                        $medio = $item->fuente_descripcion_c == 'webchat_1001carros' ? 25 : ($item->fuente_descripcion_c == 'tde_ecuador' ? 28 : 13);
                        break;
                    case '1800':
                        $fuente = 5;
                        $medio = $item->name && ($item->name == 'SEMINUEVOS' || $item->name == 'SEMINUEVOS TOMA') ? 21 :10;
                        break;
                    case '16':
                        $fuente = 4;
                        $medio = 8;
                        break;
                    case 'pt':
                        $medio = 23;
                        break;
                    case '11':
                        $medio = 20;
                        break;
                    default:
                        $fuente = 'x';
                        $medio = 'x';
                        break;
                }
                $item->update(['fuente' => $fuente]);
                if ($item->id_c) {
                    InteraccionesCstm::find($item->id)->update( ['medio_c' => $medio]);
                } else {
                    InteraccionesCstm::create(['id_c' => $item->id, 'medio_c' => $medio]);
                }
            }
            $this->error('----------- Interacciones '.($j*10000).'----------------');
            $j ++;
            \DB::connection(get_connection())->commit();
        }while($interacciones->count() > 1);
    }

    protected function ticket()
    {
        $j= 1;
        do {
            \DB::connection(get_connection())->beginTransaction();
            $tickets = Tickets::select('id','fuente','id_c')
                                    ->leftJoin('cbt_tickets_cstm', 'id_c', 'id')
                                    ->where('medio_c', null)->limit(10000)->get();

            foreach ($tickets as $item) {
                $fuente = 6;
                switch ($item->fuente) {
                    case 'jivochat':
                        $negocio = $item->interacciones->sortByDesc('date_entered')->first();
                        $medio = $negocio && $negocio->lineaNegocio && ($negocio->lineaNegocio->name == 'SEMINUEVOS' || $negocio->lineaNegocio->name == 'SEMINUEVOS TOMA') ? 25 :13;
                      break;
                    case 'tde':
                    case '9':
                        $medio = 18;
                        break;
                    case '2':
                        $medio = 13;
                        break;
                    case '3':
                        $medio = 25;
                        break;
                    case '1':
                    case 'whatsapp':
                        $negocio = $item->interacciones->sortByDesc('date_entered')->first();
                        $medio = $negocio && $negocio->name && ($negocio->name == 'SEMINUEVOS' || $negocio->name == 'SEMINUEVOS TOMA') ? 26 :14;
                        break;
                    case '14':
                    case 'formulario':
                        $medio = 15;
                        break;
                    case 'acton':
                        $medio = 22;
                        break;
                    case 'facebook_tde':
                        $medio = 11;
                        break;
                    case 'facebook':
                        $negocio = $item->interacciones->sortByDesc('date_entered')->first();
                        $medio = $negocio && $negocio->name && ($negocio->name == 'SEMINUEVOS' || $negocio->name == 'SEMINUEVOS TOMA') ? 27 :11;
                        break;
                    case 'inconcert':
                        $negocio = $item->interacciones->sortByDesc('date_entered')->first();
                        $medio = $negocio && $negocio->fuente_descripcion_c == 'webchat_1001carros' ? 25 : ($negocio->fuente_descripcion_c == 'tde_ecuador' ? 28 : 13);
                        break;
                    case '1800':
                        $fuente = 5;
                        $negocio = $item->interacciones->sortByDesc('date_entered')->first();
                        $medio = $negocio && $negocio->lineaNegocio && ($negocio->lineaNegocio->name == 'SEMINUEVOS' || $negocio->lineaNegocio->name == 'SEMINUEVOS TOMA') ? 21 :10;
                        break;
                    case '16':
                        $fuente = 4;
                        $medio = 8;
                        break;
                    case 'pt':
                        $medio = 23;
                        break;
                    case '11':
                        $medio = 20;
                        break;
                    default:
                        $fuente = 'x';
                        $medio = 'x';
                        break;

                }
                $item->update(['fuente' => $fuente]);
                if ($item->id_c) {
                    TicketsCstm::find($item->id_c)->update([ 'medio_c' => $medio]);
                } else {
                    TicketsCstm::create(['id_c' => $item->id, 'medio_c' => $medio]);
                }
            }
            $this->error('-----------Tickets '.($j*10000).'----------------');
            $j ++;
            \DB::connection(get_connection())->commit();
        }while($tickets->count() > 1);
    }

    protected function prospeccion()
    {
        $j= 1;
        do {
            \DB::connection(get_connection())->beginTransaction();
            $prospeccion = Prospeccion::select('cbp_prospeccion.id','cb_lineanegocio.tipo_prospeccion','cb_lineanegocio.name','cbp_prospeccion_cstm.id_c')
                                        ->leftJoin('cbp_prospeccion_cstm', 'cbp_prospeccion_cstm.id_c', 'cbp_prospeccion.id')
                                        ->leftJoin('cb_lineanegocio', 'cb_lineanegocio.id', 'cbp_prospeccion.cb_lineanegocio_id_c')
                                        ->where('cbp_prospeccion_cstm.medio_c', null)->limit(10000)->get();
            foreach ($prospeccion as $item) {
                $fuente = 6;
                switch ($item->tipo_prospeccion) {
                    case 'jivochat':
                    case '8':
                    case 'inconcert':
                        $medio = $item->name && ($item->name == 'SEMINUEVOS' || $item->name == 'SEMINUEVOS TOMA') ? 25 : 13;
                        break;
                    case 'tde':
                    case '9':
                        $medio = 18;
                        break;
                    case '2':
                        $medio = 13;
                        break;
                    case '10':
                        $medio = 19;
                        break;
                    case '1':
                    case 'whatsapp':
                        $medio = $item->name && ($item->name == 'SEMINUEVOS' || $item->name == 'SEMINUEVOS TOMA') ? 26 :14;
                        break;
                    case '14':
                    case 'formulario':
                        $medio = 15;
                        break;
                    case 'acton':
                        $medio = 22;
                        break;
                    case 'facebook_tde':
                    case '7':
                        $medio = 11;
                        break;
                    case 'facebook':
                        $medio = $item->name && ($item->name == 'SEMINUEVOS' || $item->name == 'SEMINUEVOS TOMA') ? 27 :11;
                        break;
                    case '1800':
                        $fuente = 5;
                        $medio = $item->name && ($item->name == 'SEMINUEVOS' || $item->name == 'SEMINUEVOS TOMA') ? 21 :10;
                        break;
                    case '16':
                        $fuente = 4;
                        $medio = 8;
                        break;
                    case 'pt':
                        $medio = 23;
                        break;
                    case '3':
                        $medio = 25;
                        break;
                    case '11':
                        $medio = 20;
                        break;
                    case '17':
                        $fuente = 3;
                        $medio = 6;
                        break;
                    case '6':
                        $fuente = 5;
                        $medio = 21;
                        break;
                    case '5':
                        $fuente = 5;
                        $medio = 10;
                        break;
                    case '12':
                        $fuente = 2;
                        $medio = 2;
                        break;
                    default:
                        $fuente = 'x';
                        $medio = 'x';
                        break;
                }
                $item->update(['fuente' => $fuente]);
                if ($item->id_c) {
                    ProspeccionCstm::find($item->id_c)->update([ 'medio_c' => $medio]);
                } else {
                    ProspeccionCstm::create(['id_c' => $item->id, 'medio_c' => $medio]);
                }
            }
            $this->error('----------- Prospeccion '.($j*10000).'----------------');
            $j ++;
            \DB::connection(get_connection())->commit();
        }while($prospeccion->count() > 1);
    }

    protected function trafico()
    {
        $j= 1;
        do {
            \DB::connection(get_connection())->beginTransaction();
            $trafico = Traffic::select('cb_traficocontrol.id','cb_traficocontrol.efectividad_medios','cb_lineanegocio.name','cb_traficocontrol_cstm.id_c')
                                ->leftJoin('cb_traficocontrol_cstm', 'cb_traficocontrol_cstm.id_c', 'cb_traficocontrol.id')
                                ->leftJoin('cb_lineanegocio', 'cb_lineanegocio.id', 'cb_traficocontrol.cb_lineanegocio_id_c')
                                ->where('cb_traficocontrol_cstm.medio_c', null)->limit(10000)->get();
            foreach ($trafico as $item) {
                switch ($item->efectividad_medios) {
                    case 8:
                    case 19:
                        $fuente = 1;
                        $medio = 1;
                        break;
                    case 36:
                        $fuente = 2;
                        $medio = 2;
                        break;
                    case 15:
                    case 33:
                    case 17:
                    case 34:
                        $fuente = 3;
                        $medio = 4;
                        break;
                    case 2:
                        $fuente = 4;
                        $medio = 8;
                        break;
                    case 4:
                    case 3:
                    case 1:
                    case 7:
                    case 8:
                        $fuente = 4;
                        $medio = 17;
                        break;
                    case 27:
                    case 28:
                    case 37:
                    case 5:
                        $fuente = 5;
                        $medio = $item->lineaNegocio && ($item->lineaNegocio->name == 'SEMINUEVOS' || $item->lineaNegocio->name == 'SEMINUEVOS TOMA') ? 21 :10;
                        break;
                    case 22:
                    case 18:
                        $fuente = 6;
                        $medio = $item->lineaNegocio && ($item->lineaNegocio->name == 'SEMINUEVOS' || $item->lineaNegocio->name == 'SEMINUEVOS TOMA') ? 27 :11;
                        break;
                    case 41:
                        $fuente = 6;
                        $medio = 11;
                        break;
                    case 30:
                        $fuente = 6;
                        $medio = 12;
                        break;
                    case 35:
                    case 25:
                    case 39:
                        $fuente = 6;
                        $medio = 15;
                        break;
                    case 29:
                        $fuente = 6;
                        $medio = 16;
                        break;
                    case 11:
                        $fuente = 6;
                        $medio = 18;
                        break;
                    case 10:
                    case 26:
                        $fuente = 6;
                        $medio = 19;
                        break;
                    case 9:
                        $fuente = 6;
                        $medio = 20;
                        break;
                    case 40:
                        $fuente = 6;
                        $medio = 22;
                        break;
                    case 12:
                    case 31:
                    case 13:
                        $fuente = 6;
                        $medio = 23;
                        break;
                    case 16:
                    case 24:
                        $fuente = 6;
                        $medio = 24;
                        break;
                    case 38:
                        $fuente = 6;
                        $medio = $item->lineaNegocio && ($item->lineaNegocio->name == 'SEMINUEVOS' || $item->lineaNegocio->name == 'SEMINUEVOS TOMA') ? 25 :13;
                        break;
                    default:
                        $fuente = 'x';
                        $medio = 'x';
                        break;
                }
                if($item->id_c){
                    TrafficCstm::find($item->id)->update( ['medio_c' => $medio,'fuente_c' => $fuente]);
                }else{
                    TrafficCstm::create(['id_c' => $item->id, 'medio_c' => $medio,'fuente_c' => $fuente]);
                }
            }
            $this->error('----------- Trafico '.($j*10000).'----------------');
            $j ++;
            \DB::connection(get_connection())->commit();
        }while($trafico->count() > 1);
    }

    protected function negocio()
    {
        $j= 1;
        do {
            \DB::connection(get_connection())->beginTransaction();
            $negocio = Talks::select('cb_negociacion.id','efectividad_medios','cb_lineanegocio.name','cb_negociacion_cstm.id_c')
                            ->leftJoin('cb_negociacion_cstm', 'cb_negociacion_cstm.id_c', 'cb_negociacion.id')
                            ->leftJoin('cb_lineanegocio', 'cb_lineanegocio.id', 'cb_negociacion.cb_lineanegocio_id_c')
                            ->where('cb_negociacion_cstm.medio_c', null )->limit(10000)->get();
            foreach ($negocio as $item) {
                switch ($item->efectividad_medios) {
                    case 8:
                    case 19:
                        $fuente = 1;
                        $medio = 1;
                        break;
                    case 36:
                        $fuente = 2;
                        $medio = 2;
                        break;
                    case 15:
                    case 33:
                    case 17:
                    case 34:
                        $fuente = 3;
                        $medio = 4;
                        break;
                    case 2:
                        $fuente = 4;
                        $medio = 8;
                        break;
                    case 4:
                    case 3:
                    case 1:
                    case 7:
                    case 8:
                        $fuente = 4;
                        $medio = 17;
                        break;
                    case 27:
                    case 28:
                    case 37:
                    case 5:
                        $fuente = 5;
                        $medio = $item->lineaNegocio && ($item->lineaNegocio->name == 'SEMINUEVOS' || $item->lineaNegocio->name == 'SEMINUEVOS TOMA') ? 21 :10;
                        break;
                    case 22:
                    case 18:
                        $fuente = 6;
                        $medio = $item->lineaNegocio && ($item->lineaNegocio->name == 'SEMINUEVOS' || $item->lineaNegocio->name == 'SEMINUEVOS TOMA') ? 27 :11;
                        break;
                    case 41:
                        $fuente = 6;
                        $medio = 11;
                        break;
                    case 30:
                        $fuente = 6;
                        $medio = 12;
                        break;
                    case 35:
                    case 25:
                    case 39:
                        $fuente = 6;
                        $medio = 15;
                        break;
                    case 29:
                        $fuente = 6;
                        $medio = 16;
                        break;
                    case 11:
                        $fuente = 6;
                        $medio = 18;
                        break;
                    case 10:
                    case 26:
                        $fuente = 6;
                        $medio = 19;
                        break;
                    case 9:
                        $fuente = 6;
                        $medio = 20;
                        break;
                    case 40:
                        $fuente = 6;
                        $medio = 22;
                        break;
                    case 12:
                    case 31:
                    case 13:
                        $fuente = 6;
                        $medio = 23;
                        break;
                    case 16:
                    case 24:
                        $fuente = 6;
                        $medio = 24;
                        break;
                    case 38:
                        $fuente = 6;
                        $medio = $item->lineaNegocio && ($item->lineaNegocio->name == 'SEMINUEVOS' || $item->lineaNegocio->name == 'SEMINUEVOS TOMA') ? 25 :13;
                        break;
                    default:
                        $fuente = 'x';
                        $medio = 'x';
                        break;
                }
                if($item->id_c){
                    TalksCstm::find($item->id)->update( ['medio_c' => $medio,'fuente_c' => $fuente]);
                }else{
                    TalksCstm::create(['id_c' => $item->id, 'medio_c' => $medio,'fuente_c' => $fuente]);
                }
            }
            $this->error('----------- Negociacion '.($j*10000).'----------------');
            $j ++;
            \DB::connection(get_connection())->commit();
        }while($negocio->count() > 1);
    }
}
