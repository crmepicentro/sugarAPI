
<html>
<head>
    <link rel="stylesheet" href="{{ public_path('/css/pdfMil.css') }}">
</head>
<body>
    <div class="bb-mb-30">
        <div>
            <img class="bb-w-100" src="{{ public_path('images/pdfMil/cabecera-logo.jpg') }}" >
        </div>
    </div>

    <div class="bb-mb-30 bb-w-85 bb-border bb-radius bb-mx-auto">
        <table cellspacing="0" class="bb-w-full bb-px-15">
            <tr>
                <td class="bb-w-50">
                   <div class="bb-font-black bb-mt-15 bb-mb-15 bb-line-h-1 bb-text-17 bb-text-blue">Nombre: {{ mb_convert_case($name, MB_CASE_UPPER, "UTF-8") }}</div></td>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mt-15 bb-mb-15 bb-line-h-1 bb-text-17 bb-text-blue">Marca: {{ mb_convert_case($brand['name'], MB_CASE_UPPER, "UTF-8") }}</div>
                </td>
            </tr>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">Cédula:</div>
                </td>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">Modelo: {{ mb_convert_case($model['name'], MB_CASE_UPPER, "UTF-8") }}</div>
                </td>
            </tr>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">Placa: {{$plate}}</div>
                </td>
                <td class=" bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">Descripción: {{ mb_convert_case($description['description'], MB_CASE_UPPER, "UTF-8") }}</div>
                </td>
            </tr>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">Año: {{$year}}</div>
                </td>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">Color: {{ mb_convert_case($color['name'], MB_CASE_UPPER, "UTF-8") }}</div>
                </td>
            </tr>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">Kilometraje: {{$mileage}} {{ mb_convert_case($unity, MB_CASE_UPPER, "UTF-8") }}</div>
                </td>
                <td class="bb-w-50"></td>
            </tr>
        </table>
    </div>

    <div class="bb-w-85 bb-mx-auto bb-radius-t-x bb-text-white bb-line-h-1 bb-text-center bb-py-10 bb-text-20 bb-bg-blue bb-font-black bb-border">CONDICIÓN DEL VEHÍCULO</div>
<div class="bb-mb-30 bb-w-85 bb-border bb-radius-b-x  bb-mx-auto">
    <table cellspacing="0" class="bb-w-full bb-px-15">
        <tbody>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-mt-15 bb-text-17 bb-text-blue">
                        {{ mb_convert_case($checklist[0]['description'], MB_CASE_TITLE, "UTF-8") }}: {{$statusCheck[$checklist[0]['option']]}}
                    </div>
                </td>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-mt-15 bb-text-17 bb-text-blue">
                        {{ mb_convert_case($checklist[1]['description'], MB_CASE_TITLE, "UTF-8") }}: {{$statusCheck[$checklist[1]['option']]}}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">
                        {{ mb_convert_case($checklist[2]['description'], MB_CASE_TITLE, "UTF-8") }}: {{$statusCheck[$checklist[2]['option']]}}
                    </div>
                </td>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">
                        {{ mb_convert_case($checklist[3]['description'], MB_CASE_TITLE, "UTF-8") }}: {{$statusCheck[$checklist[3]['option']]}}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">
                        {{ mb_convert_case($checklist[4]['description'], MB_CASE_TITLE, "UTF-8") }}: {{$statusCheck[$checklist[4]['option']]}}
                    </div>
                </td>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">
                        {{ mb_convert_case($checklist[5]['description'], MB_CASE_TITLE, "UTF-8") }}: {{$statusCheck[$checklist[5]['option']]}}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">
                        {{ mb_convert_case($checklist[6]['description'], MB_CASE_TITLE, "UTF-8") }}: {{$statusCheck[$checklist[6]['option']]}}
                    </div>
                </td>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">
                        {{ mb_convert_case($checklist[7]['description'], MB_CASE_TITLE, "UTF-8") }}: {{$statusCheck[$checklist[7]['option']]}}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mb-15 bb-text-17 bb-text-blue">
                        {{ mb_convert_case($checklist[8]['description'], MB_CASE_TITLE, "UTF-8") }}: {{$statusCheck[$checklist[8]['option']]}}
                    </div>
                </td>
                <td class="bb-w-50"></td>
            </tr>
        </tbody>
    </table>
</div>

@if ($bonoMil > 0.0 && $bonoToyota < 1.0 )
    <div class="bb-mb-30">
        <table cellspacing="0" class="bb-w-85  bb-mx-auto">
            <tr>
                <td class="bb-w-50">
                    <div class="bb-pd-20 bb-font-black  bb-text-20 bb-text-white bb-bg-blue bb-border bb-radius-l-y bb-text-uppercase bb-text-center">BONO 1001CARROS.COM</div>
                </td>
                <td class=" bb-w-50">
                    <div class="bb-pd-20 bb-font-black bb-text-uppercase bb-radius-r-y bb-text-blue bb-border bb-text-center bb-text-20">
                        ${{number_format($bonoMil,2,".",",")}}
                    </div>
                </td>
            </tr>
        </table>
    </div>
@endif

@if ($bonoToyota > 0.0 && $bonoMil < 1.0 )
    <div class="bb-mb-30">
        <table cellspacing="0" class="bb-w-85  bb-mx-auto">
            <tr>
                <td class="bb-w-50">
                    <div class="bb-pd-20 bb-font-black  bb-text-20 bb-text-white bb-bg-blue bb-border bb-radius-l-y bb-text-uppercase bb-text-center">BONO toyota</div>
                </td>
                <td class=" bb-w-50">
                    <div class="bb-pd-20 bb-font-black bb-text-uppercase bb-radius-r-y bb-text-blue bb-border bb-text-center bb-text-20">
                        ${{number_format($bonoToyota,2,".",",")}}
                    </div>
                </td>
            </tr>
        </table>
    </div>
@endif

@if ($bonoToyota > 0.0 && $bonoMil > 0.0)
    <div class="bb-mb-30">
        <table class="bb-w-85 bb-mx-auto" cellspacing="0">
            <tr>
                <td class="bb-w-50">
                    <table class="bb-w-100" cellspacing="0">
                        <tr >
                            <td class="bb-w-50">
                                <div class="bb-py-22 bb-font-black  bb-text-17 bb-text-white bb-radius-l-y bb-bg-blue bb-border bb-text-uppercase bb-text-center">BONO toyota</div>
                            </td>
                            <td class=" bb-w-50">
                                <div class="bb-pd-20 bb-font-black bb-text-uppercase bb-radius-r-y bb-text-blue bb-border bb-text-center bb-text-20">
                                    ${{number_format($bonoToyota,2,".",",")}}
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="bb-pd-20"></td>
                <td class="bb-w-50">
                    <table class="bb-w-100" cellspacing="0">
                        <tr>
                            <td class="bb-w-50">
                                <div class="bb-pa-11 bb-font-black  bb-text-17 bb-text-white bb-radius-l-y bb-bg-blue bb-border bb-text-uppercase bb-text-center">BONO 1001CARROS.COM</div>
                            </td>
                            <td class=" bb-w-50">
                                <div class="bb-pd-20 bb-font-black bb-text-uppercase bb-radius-r-y bb-text-blue bb-border bb-text-center bb-text-20">
                                    ${{number_format($bonoMil,2,".",",")}}
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
@endif

<div class="bb-mb-30">
    <table cellspacing="0" class="bb-w-85  bb-mx-auto">
        <tr>
            <td class="bb-w-50">
                <div class="bb-mx-auto bb-border-yellow bb-bg-yellow bb-radius-l-y">
                    <div class="bb-float-l">img</div>
                    <div class="bb-font-black bb-text-35 bb-text-blue  bb-text-center">oferta</div>
                </div>
            </td>

            <td class="bb-w-50">
                <div class="bb-relative">
                    <div class= "bb-font-black  bb-text-35 bb-radius-r-y bb-text-blue bb-border bb-text-center ">${{number_format($priceApproved,2,".",",")}}</div>
                    <div class="bb-text-12 bb-font-black  bb-text-blue bb-absolute bb-position-custom">*El valor de la oferta incluye bonos</div>
                </div>
            </td>

        </tr>
    </table>
</div>
<div class="bb-mb-30">
    <table class="bb-w-85 bb-mx-auto">
        <tr>
            <td class="bb-w-50">
                <table>
                    <tr>
                        <td>
                            <tr class="bb-px-5 bb-py-5 bb-pl-none bb-w-50">
                                <div class= "bb-font-black bb-form-text bb-text-17 bb-text-blue bb-ml-30">Coordinador: {{$coordinator['name']}}</div>
                            </tr>
                            <tr class="bb-px-5 bb-py-5 bb-pl-none bb-w-50">
                                <div class= "bb-font-black bb-form-text bb-text-17 bb-text-blue bb-ml-30">Avalúo: {{$alias}}</div>
                            </tr>
                            <tr class="bb-px-5 bb-py-5 bb-pl-none bb-w-50">
                                <div class= "bb-font-black bb-form-text bb-text-17 bb-text-blue bb-ml-30">Fecha: {{$date}}</div>
                            </tr>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="bb-w-50">
                <table>
                    <tr>
                        <td class="bb-px-5 bb-py-5 bb-pl-none bb-w-50 ">
                            <div class= "bb-font-black bb-form-text bb-text-25 bb-text-blue bb-text-center" >Oferta válida hasta:</div>
                            <div class= "bb-font-black bb-form-text bb-text-25 bb-text-blue bb-text-center" >{{$dateValid}}</div>
                        </td>
                    </tr>

                </table>
            </td>

        </tr>
    </table>
</div>


<img class="bb-w-full bb-mt-auto bb-mb-0" src="{{ public_path('images/pdfMil/footer-pdf-mil.jpg') }}" >

</body>
</html>
