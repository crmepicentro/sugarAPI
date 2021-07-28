<?php

namespace App\Http\Controllers;

use App\Services\TicketClass;
use App\Models\Tickets;
use App\Models\VehiculoMarca;
use App\Models\VehiculoModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CarMatchController extends Controller
{
    public static function getCarMatch($ticket_id)
    {
        return view('tickets/carmatch')->with('ticket_id', $ticket_id);
    }

    public function getS3sCarMatch($ticket_id)
    {
        $ticket = Tickets::find($ticket_id);

        if($ticket){
          $marca = VehiculoMarca::find($ticket->ticketsCstm->marca_c);
          $modelo = VehiculoModelo::find($ticket->ticketsCstm->modelo_c);
          $data = [
            "marca" => $marca->nombre ?? null,
            "modelo" => $modelo->nombre ?? null,
            "color" => $ticket->ticketsCstm->color_c,
            "precioMax" => intval($ticket->ticketsCstm->precio_c),
            "anioMin" => $ticket->ticketsCstm->anio_min_c,
            "anioMax"=> $ticket->ticketsCstm->anio_max_c,
            "kilometrajeMax" => $ticket->ticketsCstm->kilometraje_c,
            "combustible" => $ticket->ticketsCstm->combustible_c,
            "pagina" => 0
          ];

          $response = Http::post(env('s3sCarMatch'), $data);
          $content = $response->json();
          if($content) {
            $resultado = $content["resultado"];

            for($page = 1; $page<$content["totalPaginas"]; $page++){
              $data["pagina"] = $page;
              $response = Http::post(env('s3sCarMatch'), $data);
              $contentPage = $response->json();
              $resultado = array_merge($resultado, $contentPage["resultado"]);
            }

            return response()->json(['cars' => $resultado], 202);
          }

          return response()->json(['cars' => []], 202);
        }

        return response()->json(['cars' => 'Ticket Not Found'], 202);
    }
}
