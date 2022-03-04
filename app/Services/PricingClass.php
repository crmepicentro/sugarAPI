<?php
namespace App\Services;

use ErrorException;
use Illuminate\Support\Facades\Http;
use App\Models\Strapi\PricingHistories;

class PricingClass {

    /**
     * @throws ErrorException
     */
    public static function getToken(){
        $response = Http::post(env('PRICING').'authentication',['user' => env('USER_PRICING'),'password' => env('PASSWORD_PRICING')]);
        if(!$response->successful()){
            throw new ErrorException('Error en Pricing notifique al área de BI', 777);
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
            throw new ErrorException('Error al traer data de Pricing notifique al área de BI', 777);
        }
        return $response->object();
    }
    /** Ingresar historial pricing
     * @param int $descripcion [required] Id de la descipción del auto.
     * @param string $id_avaluo_sugar [required] Año del auto.
     * @param double $price [required] Precio nuevo.
     * @param string $observation [required] Observacion de porque se cambio el precio.
     * @param string $date_save [required] Fecha en la que se guardo el avaluo.
     * @param string $date_approved [required] Fecha en la que se aprobo el avaluo.
     */
    public static function historyPricing($descripcion,$id_avaluo_sugar,$price,$observation,$date_save,$date_approved){
        $pricing = PricingHistories::where('id_avaluo_sugar',$id_avaluo_sugar)->first();
        if(!$pricing){
            $pricing = new PricingHistories();
            $pricing->created_at = date('Y-m-d H:i:s');
            $pricing->id_avaluo_sugar = $id_avaluo_sugar;
        }
        $pricing->descripcion = $descripcion;
        $pricing->price = $price;
        $pricing->observation = $observation;
        $pricing->date_save = $date_save;
        $pricing->date_approved = $date_approved;
        $pricing->status = 1;
        $pricing->approved = 1;
        $pricing->updated_at = date('Y-m-d H:i:s');
        $pricing->save();
    } 
}
