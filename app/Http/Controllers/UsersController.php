<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestMediosAsesores;
use App\Models\Agencies;
use App\Models\BusinessLine;
use App\Models\EmailAddrBeanRel;
use App\Models\EmailAddreses;
use App\Models\LineaNegocioUsers;
use App\Models\Users;
use Illuminate\Http\Request;
use UsersTransformer;
/**
 * @group Asesores
 *
 * Api para Obtener asesores
 */
class UsersController extends BaseController
{
    /**
     * Obtiene los asesores comerciales disponibles de un medio requerido
     *
     * @bodyParam  medio numeric required Medio requerido  Example: 11
     *
     * @response  {
     * "data": [
     *      {
     *          "nombres": "FRANCISCO XAVIER",
     *          "apellidos": "VILLAMAR CASTRO",
     *          "celular": "0987647944",
     *          "user_name": "MA_PALACIOS",
     *          "email": "fvillamar@1001carros.com",
     *          "agencia": "CUMBAYA",
     *          "lineas_negocio": [
     *              "SEMINUEVOS"
     *          ]
     *    },
     *    {
     *          "nombres": "Admin",
     *          "apellidos": "SugarCRM",
     *          "celular": null,
     *          "user_name": "admin",
     *          "email": "mwherrera@plus-projects.com",
     *          "agencia": "MATRIZ",
     *          "lineas_negocio": []
     *    }
     * ]
     * }
     *
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */
    public function getAsesores(RequestMediosAsesores $request)
    {
        $users = Users::get_comercial_users(false, true, $request->medio);

        return $this->response->collection($users, new UsersTransformer)->setStatusCode(200);
    }
}

