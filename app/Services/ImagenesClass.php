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
        $this->deletedImageOld();
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

    private function deletedImageOld()
    {

        $ids = Imagenes::select('cba_imagenavaluo.id')
                        ->join('cba_imagenavaluo_cba_avaluos_c',
                                'cba_imagenavaluo_cba_avaluoscba_imagenavaluo_idb',
                                'cba_imagenavaluo.id')
                        ->where('cba_imagenavaluo_cba_avaluoscba_avaluos_ida',$this->id_avaluo)
                        ->where('orientacion',$this->orientacion)
                        ->get()
                        ->pluck('id');
        Imagenes::whereIn('id',$ids)->update(['deleted' => 1]);
    }
}
