<?php

namespace App\Models\Coupons;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function validSwap($code){
        return self::where('code',$code)->where('status',1)->where('deleted',0)->exists();
    }

    public static function validDateSwap($code){
        return self::where('code',$code)->where('date_validity','>=',Carbon::now('UTC')->toDateString())->where('status',1)->where('deleted',0)->exists();
    }
}
