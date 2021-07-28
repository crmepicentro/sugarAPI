<?php
namespace App\Services;

use App\Models\Interacciones;
use App\Models\Notes;
use Carbon\Carbon;

class NoteClass {

  public static function ticketNotes($data, $ticket)
  {
    $nameIteraction = '';

    if (isset($data["interaction"])) {
      $interaction = Interacciones::find($data["interaction"]);
      $nameIteraction .= $interaction->name;
    }

    $notes = new Notes();
    $notes->name = $nameIteraction . $data["name"];
    $notes->date_entered = Carbon::now();
    $notes->date_modified = Carbon::now();
    $notes->created_by = $data["created_by"];
    $notes->modified_user_id = $data["modified_user_id"];
    $notes->description = $data["description"];
    $notes->save();

    $ticket->notes()->attach($notes->id, ['id' => createdID()]);

    return $notes;
  }

  public static function prospeccionNotes($data, $prospeccion)
  {
    $notes = new Notes();
    $notes->name = $data["name"];
    $notes->date_entered = Carbon::now();
    $notes->date_modified = Carbon::now();
    $notes->created_by = $data["created_by"];
    $notes->modified_user_id = $data["modified_user_id"];
    $notes->description = $data["description"];
    $notes->save();

    $prospeccion->notes()->attach($notes->id, ['id' => createdID()]);

    return $notes;
  }
}
