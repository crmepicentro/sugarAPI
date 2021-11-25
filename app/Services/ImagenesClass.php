<?php
namespace App\Services;

use App\Models\Avaluos;
use App\Models\Imagenes;
use Carbon\Carbon;

class ImagenesClass {
    public $id;
    public $name;
    public $user_id_c;
    public $description;
    public $deleted;
    public $imagen_path;
    public $orientacion;
    public $assigned_user_id;
    public $id_avaluo;

    public function create()
    {
        $imagen = new Imagenes();
        $imagen->name = $this->name;
        $imagen->created_by = $this->assigned_user_id;
        $imagen->modified_user_id = $this->assigned_user_id;
        $imagen->description = $this->description;
        $imagen->deleted = "0";
        $imagen->imagen_path = $this->imagen_path;
        $imagen->orientacion = $this->orientacion;
        $imagen->assigned_user_id = $this->assigned_user_id;
        $imagen->team_id = 1;
        $imagen->team_set_id = 1;
        $imagen->save();

        $imagen->avaluo()->attach($this->id_avaluo, ['id' => createdID(), 'date_modified' => Carbon::now()]);
        return $imagen;
    }
}
