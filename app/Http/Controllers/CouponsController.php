<?php

namespace App\Http\Controllers;

use App\Models\Agencies;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function index(Request $request)
    {
        $agencies = Agencies::getAllCodeNameByLine('NUEVOS');
        $data['agencies'] = json_encode($agencies);
        return view('coupons.index',$data);
    }
}
