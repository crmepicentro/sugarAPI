<?php

namespace App\Http\Controllers;

use App\Models\LandingPages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandingPageController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'medio' => 'required',
            'properties_form' => 'required',
            'user_login' => 'required',
            'business_line_id' => 'required',
            'type_transaction' => 'required',
            'user_assigned_position' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['status_code' => 400, 'message' => 'Revise que sus datos sean correctos']);
        }

        $landing = LandingPages::firstOrNew(['name' => $request->name]);
        $landing->fill($request->all());
        $landing->save();

        return response()->json([
            'status_code' => 200,
            'messsage' => 'Landing Page creada correctamente'
        ]);
    }
}
