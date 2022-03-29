<?php

namespace Tests\Feature;

use App\Models\Avaluos;
use App\Models\CheckList;
use App\Models\CheckListAvaluo;
use App\Models\Imagenes;
use App\Models\Imagenes_Avaluo;
use App\Models\TrafficAvaluos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateAvaluoTestV2 extends TestCase
{
    use RefreshDatabase, WithFaker;
    public $dataAvaluo = [];

    protected function setUp(): void
    {
        $this->dataAvaluo = [
            "id" => null,
            "traffic" => createdID(),
            'testPicture1' => $image,
            'extraPicture' => [$image, $image],
            'extraPicture[1]' => $image,
            "contact" => "0015ad44-0a08-11ea-b67c-5883aaf14456",
            "document" => "1722898838",
            "coordinator" => "b9187d88-6ee4-c794-27f5-552bb40ee0d4",
            "plate" => "PCR5214",
            "brand" =>  '{"id":4,"name":"FIAT","status":true}',
            "model" => '{"id":227,"name":"Argo","status":true,"brand":{"id":4,"name":"FIAT","status":true},"start_year":"2021","end_year":"2022"}',
            "color" => '{"id":1,"name":"Blanco","status":true}',
            "year" => "2022",
            "mileage" => "23412",
            "unity" => "km",
            "status" => "1",
            "comment" => "qweasd",
            "observation" => "qweasd",
            "description" => '{"id":897,"description":"Argo Trekking 1.3L Firefly SUV 4x2 T/M A/A 100hp/6000rpm 134Nm/3500rpm 2AB ABS+EBD ESC HAC TPMS aros 15\" cam retro pant 7\" Uconnect BRA (2022)","start_year":2021,"end_year":2022,"status":true,"model":{"id":227,"name":"Argo","status":true,"brand":4,"start_year":"2021","end_year":"2022"}}',
            "priceNew" => null,
            "priceNewEdit" => "234",
            "priceFinal" => null,
            "priceFinalEdit" => "123",
            "pics" => '[{"name":"testPicture1","multiple":false},{"name":"testPicture2","multiple":false},{"name":"extraPicture","multiple":true}]',
            "checklist" => '[{"id":1,"description":"Tren Motriz","status":true,"option":"A","observation":"observacion 1","cost":"1000"},{"id":2,"description":"Dirección","status":true,"option":"E","observation":"observación 2","cost":"2000"},{"id":3,"description":"Suspensión","status":true,"option":"NA"}]'
        ];
    }

}
