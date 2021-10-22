<?php
namespace App\Services;

use ErrorException;
use Illuminate\Support\Facades\Http;

class PricingClass {
    /**public $valor_nuevo;
      public $id_descipcion;
      public $anio;
      public $placa;
      public $recorrido;
      public $unidad;
      public $descuentos;
    */

    /**
     * @throws ErrorException
     */
    public static function getToken(){
        $response = Http::post(env('PRICING').'authentication',['user' => env('USER_PRICING'),'password' => env('PASSWORD_PRICING')]);
        if(!$response->successful()){
            throw new ErrorException('Error en Pricing notifique al área de BI', $response->status());
        }
        $response = $response->object();
        return $response->token;
    }

    /** Obtener pricing
     * @param int $id_descipcion [required] Id de la descipción del auto.
     * @param int $anio [required] Año del auto.
     * @param string $placa [required] Placa del auto.
     * @param int $recorrido [required] Recorrido del auto.
     * @param string $unidad [required] Unidad de medida del auto en Km o Mi.
     * @param array $descuentos [required] Array de objetos con id y valor de descuentos.
     * @param float $valor_nuevo [optional] El valor nuevo cuando no existe en la base de datos el pricio de referencia.
     * @throws ErrorException
     */
    public static function getPricing(int $id_descripcion, int $anio, string $placa, string $recorrido, string $unidad, array $descuentos, float $valor_nuevo = null){
        $response = Http::withToken(self::getToken())->post(env('PRICING').'pricing', [ 'data' => [
            'id_descripcion' => $id_descripcion,
            'anio' => $anio,
            'placa' => $placa[0],
            'recorrido' => $recorrido,
            'unidad' => $unidad,
            'descuentos' => $descuentos,
            'valor_nuevo' => $valor_nuevo,
        ]]);
        if(!$response->successful()){
            throw new ErrorException('Error al traer data de Pricing notifique al área de BI', $response->status());
        }
        return $response->object();
    }
}
