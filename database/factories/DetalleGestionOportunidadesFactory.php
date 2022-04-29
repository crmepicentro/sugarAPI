<?php

namespace Database\Factories;

use App\Models\Auto;
use App\Models\DetalleGestionOportunidades;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DetalleGestionOportunidadesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetalleGestionOportunidades::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $oportunidad_lista = [
            1=>'Capó / capota',
            2=>'Parachoque',
            3=>'Parachoques no expuesto',
            4=>'Parachoques expuesto',
            5=>'Pantalla de capota',
            6=>'Tapa de la cubierta',
            7=>'Fascia trasera y soporte',
            8=>'Guardabarros ( ala o guardabarros )',
            9=>'Clip frontal',
            10=>'Parrilla (también llamada parrilla)',
            11=>'Pilar y moldura dura',
            12=>'Soporte del núcleo del radiador',
            13=>'Spoiler',
            14=>'Llantas',
            15=>'Tapacubos',
            16=>'Neumático / Neumático',
            17=>'Ensamblaje soldado',
            18=>'Barra anti-intrusión',
            19=>'Motor de ventana',
            20=>'Cerradura de puerta y cerraduras de puerta eléctricas',
            21=>'Cierre centralizado',
            22=>'Motor de techo corredizo',
            23=>'Riel de techo corredizo',
            24=>'Parabrisas (también llamado parabrisas)',
        ];
        $id_op = $this->faker->numberBetween(1,24);
        $id_op_id = $this->faker->numberBetween(1000,999999);
        return [
            'ws_log_id' => Str::random(10).'-'.Str::random(4).'-'.Str::random(4).'-'.Str::random(5).'-'.Str::random(12),
            'auto_id'        => Auto::inRandomOrder()->first()->id,

            'oportunidad_id' => $id_op_id,
            'codServ' => $oportunidad_lista[$id_op],
            'descServ' => $oportunidad_lista[$id_op].'-'.$this->faker->text,
            'tipoCL' => 'CL'.$this->faker->numberBetween(1,2),
            'op_observacion'    => $this->faker->text,
            'op_cantidad' => $this->faker->numberBetween(1,5),
            'op_precio' => $this->faker->numberBetween(20,2000),

            'tipoServ' => $this->faker->numberBetween(1,2),
            'franquicia' => $this->faker->numberBetween(1,2),

            'facturacion_fecha' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d H:i:s'),
            'facturacion_agente' => 'AGE'.$this->faker->numberBetween(1000,1099),

        ];
    }
}
