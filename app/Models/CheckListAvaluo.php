<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckListAvaluo extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cba_checklist_avaluo_cba_avaluos_c';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['cba_checklist_avaluo_cba_avaluoscba_avaluos_ida',
        'cba_checklist_avaluo_cba_avaluoscba_checklist_avaluo_idb',
        'date_modified', 'deleted'];
    /**
     * @var mixed
     */

    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }
}
