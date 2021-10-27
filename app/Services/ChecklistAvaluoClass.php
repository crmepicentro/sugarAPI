<?php
namespace App\Services;

use App\Models\CheckList;
use Carbon\Carbon;

class ChecklistAvaluoClass {
    public $item_id;
    public $item_description;
    public $assigned_user_id;
    public $costo;
    public $description;
    public $estado;
    public $id_avaluo;

    public function __construct($item_id, $item_description, $assigned_user_id, $estado, $description, $costo, $id_avaluo){
        $this->item_id = $item_id;
        $this->item_description = $item_description;
        $this->assigned_user_id = $assigned_user_id;
        $this->costo = $costo;
        $this->estado = $estado;
        $this->description = $description;
        $this->id_avaluo = $id_avaluo;
    }

    public function create()
    {
        $checkList = new CheckList();

        $checkList->created_by = $this->assigned_user_id;
        $checkList->modified_user_id = $this->assigned_user_id;
        $checkList->assigned_user_id = $this->assigned_user_id;
        $checkList->description = $this->description;
        $checkList->item_id = $this->item_id;
        $checkList->item_description = $this->item_description;
        $checkList->costo = $this->costo;
        $checkList->estado = $this->estado;
        $checkList->save();

        $checkList->avaluo()->attach($this->id_avaluo, ['id' => createdID(), 'date_modified' => Carbon::now()]);

        return $checkList;
    }
}
