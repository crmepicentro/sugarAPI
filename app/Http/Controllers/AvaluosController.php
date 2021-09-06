<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaluosRequest;
use App\Models\Avaluos;
use App\Models\LandingPages;
use Illuminate\Http\Request;
use AvaluoTransformer;

class AvaluosController extends BaseController
{
    public function store(AvaluosRequest $request)
    {
        $avaluo = new Avaluos();
        $avaluo->fill($request->all());
        $avaluo->save();
        return $this->response->item($avaluo, new AvaluoTransformer)->setStatusCode(200);
    }
}
