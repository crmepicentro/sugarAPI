<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserBlockedRequest;
use App\Models\Fuente;
use App\Models\Medio;
use App\Models\SugarUsersBlocked;
use App\Models\Users;
use Illuminate\Http\Request;

class SugarUserBlocked extends Controller
{
    public function store(UserBlockedRequest $request){
        $userBlocked = SugarUsersBlocked::firstOrNew(['sugar_user_id' => $request->sugar_user_id]);
        $userBlocked->fill($request->all());
        $userBlocked->save();

        return response()->json(['userBlocked' => $userBlocked], 202);
    }

    public function index(Request $request){
        return view('usersBlocked.index');
    }

    public function listComercialUsers(){
        $users = Users::get_comercial_users(false, false);

        foreach ($users as $user){
            $userBlocked = SugarUsersBlocked::where('sugar_user_id', $user->id)->first();
            if($userBlocked){
                $user->status = $userBlocked->status;
                $user->sources_blocked = $userBlocked->sources_blocked;
                $sourcesBlocked = explode(",",$user->sources_blocked);
                $user->sources_label_blocked = $this->getLabelSources($sourcesBlocked);
                $user->date_unblocked = $userBlocked->date_unblocked;
            }
        }

        $fuentes = Fuente::where('estado', 1)->with('medios')->get();

        return response()->json(['users' => $users, 'fuentes' => $fuentes], 202);
    }

    public function getLabelSources($sourcesBlocked){
        $sources = [];
        $medios = Medio::whereIn('id', $sourcesBlocked)->get();

        foreach ($medios as $medio){
            $dataSource = ["label" => $medio->nombre, "code" => $medio->id];

            array_push($sources, $dataSource);
        }

        return $sources;
    }
}
