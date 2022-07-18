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

            if($item->route == "api/tickets/" && $item->environment ==="sugar_prod"){
                $datos = json_decode($item->datos_sugar_crm,true);

                $datosenvio = [ "datosSugarCRM" => $datos ];

                Storage::append('log_crontabreprocesos.txt',json_encode($datosenvio));
                $headers = ['Content-Type' => 'application/json', 'Authorization' => "Bearer ".env("TOKEN_REPROCESO")];
                $response = Http::withHeaders($headers)->post(env("APP_URL")."/".$item->route,$datosenvio);

                $responseBody = json_decode($response->getBody(), true);
                //$statusCode = $response->status();
                //print_r($responseBody);
                if($responseBody != null || $responseBody != "undefined"){
                    $res = json_encode(["REPROCESO"=> "Correcto"]);
                    //Wslog::deleteWpLogId($item->id);
                    WsLog::updateResponse($item->id,$res);

                }
            }

        }

        //$text = date('Y-m-d H:i:s').' --'.$user->fuente.'--'.get_connection().'--'.$user->connection.' total datos encontrados para reproceso = ['.count($ErrorLog).']';
        //Storage::append('log_crontabreprocesos.txt', count($text));
        return 0;
    }
}
