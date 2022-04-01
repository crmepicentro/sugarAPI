<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunities extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'opportunities';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'date_entered', 'date_modified', 'modified_user_id', 'created_by',
        'description', 'deleted', 'opportunity_type', 'campaign_id',
        'team_id', 'team_set_id', 'assigned_user_id', 'team_id',
        'amount', 'amount_usdollar', 'date_closed',
        'date_closed_timestamp', 'next_step', 'sales_stage', 'sales_status', 'probability', 'best_case',
        'worst_case', 'commit_stage', 'mkto_sync', 'mkto_id', 'currency_id', 'base_rate'
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function opportunitiesCstm(){
        return $this->hasOne(OpportunitiesCstm::class, 'id_c', 'id');
    }

    

}
