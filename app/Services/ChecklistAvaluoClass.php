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
        $this->deletedCheckOld();
        $checkList = new CheckList();
        $checkList->created_by = $this->assigned_user_id;
        $checkList->modified_user_id = $this->assigned_user_id;
        $checkList->assigned_user_id = $this->assigned_user_id;
        $checkList->description = $this->description;
        $checkList->item_id = $this->item_id;
        $checkList->item_description = $this->item_description;
        $checkList->name = $this->item_description;
        $checkList->costo = $this->costo;
        $checkList->checklist_estado = $this->estado;
        $checkList->save();

        $checkList->avaluo()->attach($this->id_avaluo, ['id' => createdID(), 'date_modified' => Carbon::now()]);

        return $checkList;
    }

    private function deletedCheckOld()
    {
        $ids = CheckList::select('cbav_checklistavaluonew.id')
                        ->join('cbav_checklistavaluonew_cbav_avaluoscrm_c',
                                'cbav_checkef44aluonew_idb',
                                'cbav_checklistavaluonew.id')
                        ->where('cbav_checklistavaluonew_cbav_avaluoscrmcbav_avaluoscrm_ida',$this->id_avaluo)
                        ->where('item_id',$this->item_id)
                        ->get()
                        ->pluck('id');
        CheckList::whereIn('id',$ids)->update(['deleted' => 1]);
    }
}
