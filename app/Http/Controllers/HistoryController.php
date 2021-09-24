<?php

namespace App\Http\Controllers;

use App\Models\Fuente;
use App\Models\Medio;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $ticketController = new TicketsController();
        $contactsController = new ContactsController();
        $talksController = new TalksController();

        $medios = Medio::where('estado', 1)->pluck('nombre', 'id');
        $fuentes = Fuente::where('estado', 1)->pluck('nombre', 'id');
        $data = [
            "contact" => $contactsController->getClient($request->numeroIdentificacion),
            "ticketHistory" => $ticketController->getHistoryTickets($request->numeroIdentificacion),
            "medios" => $medios,
            "fuentes" => $fuentes,
            "talksHistory" => $talksController->gethistory($request->numeroIdentificacion)
        ];

        return response()->json($data, 202);


    }
}
