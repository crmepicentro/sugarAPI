<?php

namespace App\Models\Coupons;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function validateCampaing($id){
        return self::where('id',$id)->where('date_start','<=',Carbon::now('UTC')->toDateString())->where('date_end','>=',Carbon::now('UTC')->toDateString())->where('status',1)->where('deleted',0)->exists();
    }
}

