<?php

namespace App\Models\Sugar;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'campaigns';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
      parent::__construct($attributes);

      $this->setConnection(get_connection());
    }

    public static function getDataComboVue()
    {
      return self::select('id as code','name')
                  ->where('campaign_type', 'especiales')
                  ->where('status', 'Active')
                  ->where('start_date','<',Carbon::now('UTC'))
                  ->where('end_date','>',Carbon::now('UTC')->subDay())
                  ->orderBy('name')
                  ->get();
    }
}
