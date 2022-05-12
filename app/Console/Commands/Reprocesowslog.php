<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\WsLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class Reprocesowslog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:reprocesos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reprocesos de data no integrada';

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
    public function handle(Request $request)
    {

        $ErrorLogs= Wslog::getErrorlogs();

        foreach ($ErrorLogs as $item){

            $myObj = new \stdClass();
            $myObj->datosSugarCRM = json_decode($item->datos_sugar_crm);
            $myObj->environment = $item->environment;
            $array = json_decode(json_encode($myObj), true);

            /*
            agregar token de produccion a variables de entorno para reprocesar los datos
            */
            if($item->route === "api/tickets/" && $item->environment ==="sugar_prod"){
                //se guarda json enviado en archivo de log provicional para ver si se proceso
                Storage::append('log_crontabreprocesos.txt',json_encode($array));

                $headers = ['Content-Type' => 'application/json', 'Authorization' => "Bearer ".env("TOKEN_REPROCESO")];

                $response = Http::withHeaders($headers)->post(env("APP_URL")."/".$item->route, $array);

                $statusCode = $response->status();
                $responseBody = json_decode($response->getBody(), true);

                if($responseBody != null){
                    $res = json_encode(["REPROCESO" => $responseBody]);
                }else{
                    $error = json_decode($response,true);
                    $res = json_encode(["UNDEFINED" => $error]);
                }
                $result = Wslog::updateResponse($item->id,$res);
            }
        }

        //$text = date('Y-m-d H:i:s').' --'.$user->fuente.'--'.get_connection().'--'.$user->connection.' total datos encontrados para reproceso = ['.count($ErrorLog).']';
        //Storage::append('log_crontabreprocesos.txt', count($text));
        return 0;
    }
}
