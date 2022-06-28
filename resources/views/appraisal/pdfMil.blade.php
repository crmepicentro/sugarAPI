
<html>
<head>
    <link rel="stylesheet" href="{{ public_path('/css/pdfMil.css') }}">
</head>
<body>
    <div class="bb-mb-30">
        <div>
            <img class="bb-w-full" src="{{ public_path('images/pdfMil/cabecera-logo.jpg') }}" >
        </div>
    </div>

    <div class="bb-mb-30 bb-w-85 bb-border bb-radius bb-mx-auto">
        <table cellspacing="0" class="bb-w-full bb-px-15">
            <tr>
                <td class="bb-w-50">
                   <div class="bb-font-black bb-mt-15  bb-line-h-1 bb-text-17 bb-text-blue">Nombre: <span class="bb-font-book">{{ mb_convert_case($name, MB_CASE_UPPER, "UTF-8") }}</span></div></td>
                <td class="bb-w-50">
                    <div class="bb-font-black bb-mt-15  bb-line-h-1 bb-text-17 bb-text-blue">Marca: <span class="bb-font-book">{{  mb_convert_case($brand['name'], MB_CASE_UPPER, "UTF-8") }}</span></div>
                </td>
            </tr>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black  bb-text-17 bb-line-h-1 bb-text-blue">Modelo: <span class="bb-font-book">{{ mb_convert_case($model['name'], MB_CASE_UPPER, "UTF-8") }}</span></div>
                </td>
                <td class="bb-w-50">
                    <div class="bb-font-black  bb-text-17 bb-line-h-1 bb-text-blue">Placa: <span class="bb-font-book">{{$plate}}</span></div>
                </td>
            </tr>
            <tr>
                <td class=" bb-w-50">
                    <div class="bb-font-black  bb-text-17 bb-line-h-1 bb-text-blue">Descripción: <span class="bb-font-book">{{ mb_convert_case($description['description'], MB_CASE_UPPER, "UTF-8") }}</span></div>
                </td>
                <td class="bb-w-50">
                    <div class="bb-font-black  bb-text-17 bb-line-h-1 bb-text-blue">Año: <span class="bb-font-book">{{$year}}</span></div>
                </td>
            </tr>
            <tr>
                <td class="bb-w-50">
                    <div class="bb-font-black  bb-text-17 bb-line-h-1 bb-text-blue">Color: <span class="bb-font-book">{{ mb_convert_case($color['name'], MB_CASE_UPPER, "UTF-8") }}</span></div>
                </td>
                <td class="bb-w-50">
                    <div class="bb-font-black  bb-text-17 bb-line-h-1 bb-text-blue">Kilometraje: <span class="bb-font-book">{{$mileage}} {{ mb_convert_case($unity, MB_CASE_UPPER, "UTF-8") }}</span></div>
                </td>
            </tr>
        </table>
    </div>

    <div class="box pad" style="margin:0px 25px 25px 25px auto;">
        <div class="bb-w-85 bb-mx-auto bb-radius-t-x bb-text-white bb-line-h-1 bb-text-center bb-py-10 bb-text-20 bb-bg-blue bb-font-black bb-border">CONDICIÓN DEL VEHÍCULO</div>
        <div class="bb-mb-30 bb-w-85 bb-border bb-radius-b-x  bb-mx-auto">
            <table cellspacing="0" class="bb-w-full bb-px-15">
              @foreach($checklist as $key => $item)
                @if(($key % 2) == 0) <tr> @endif
                    <td class="bb-w-50">
                        <div class="bb-font-black  bb-line-h-1 bb-mt-15 bb-text-17 bb-text-blue">
                            {{ mb_convert_case($item['description'], MB_CASE_TITLE, "UTF-8") }}: <span class="bb-font-book">{{$statusCheck[$item['option']]}}</span>
                        </div>
                    </td>
                @if(($key % 2) != 0) </tr> @endif
              @endforeach
            </table>
        </div>
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
                <td style="padding: 10px"></td>
                <td class="bb-w-50">
                    <table class="bb-w-100" cellspacing="0">
                        <tr>
                            <td class="bb-w-50">
                                <div class="bb-pa-9 bb-font-black  bb-text-17 bb-text-white bb-radius-l-y bb-bg-blue bb-border bb-text-uppercase bb-text-center">BONO 1001CARROS.COM</div>
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
                <div class="bb-bg-yellow bb-border-yellow bb-radius-l-y bb-pd-20">
                    <table cellspacing="0" class="bb-mx-auto">
                        <tr>
                            <td>
                                <div><img style="width: 56px" src="{{ public_path('images/pdfMil/icon-oferta.png') }}"></div>
                            </td>
                            <td style="padding: 5px"></td>
                            <td>
                                <div class="bb-font-black bb-text-uppercase bb-text-35 bb-text-blue bb-text-center">oferta</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>

            <td class="bb-w-50">
                <div class="bb-relative">
                    <div class= "bb-font-black  bb-text-35 bb-radius-r-y bb-text-blue bb-border bb-border-l-tranparent bb-text-center bb-pd-20">${{number_format($priceApproved,2,".",",")}}</div>
                    {{-- <div class="bb-text-12 bb-font-black  bb-text-blue bb-absolute bb-position-custom">*El valor de la oferta incluye bonos</div> --}}
                </div>
            </td>

        </tr>
    </table>
</div>
<div class="bb-mb-30">
    <table class="bb-w-85 bb-mx-auto">
        <tr>
            <td class="bb-w-50">
                <table class="bb-w-full">
                    <tr>
                        <td>
                            <tr class="bb-px-5 bb-py-5 bb-pl-none bb-w-50">
                                <div class= "bb-font-black bb-form-text bb-text-17 bb-line-h-1 bb-text-blue bb-ml-30">Coordinador: <span class="bb-font-book">{{ $coordinator['name']}}</span></div>
                            </tr>
                            <tr class="bb-px-5 bb-py-5 bb-pl-none bb-w-50">
                                <div class= "bb-font-black bb-form-text bb-text-17 bb-line-h-1 bb-text-blue bb-ml-30">Avalúo: <span class="bb-font-book">{{$alias}}</span></div>
                            </tr>
                            <tr class="bb-px-5 bb-py-5 bb-pl-none bb-w-50">
                                <div class= "bb-font-black bb-form-text bb-text-17 bb-line-h-1 bb-text-blue bb-ml-30">Fecha: <span class="bb-font-book">{{$date}}</span></div>
                            </tr>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="bb-w-50">
                <table class="bb-w-full">
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


<img class="bb-w-full bb-mt-auto bb-mb-0 bb-absolute bb-bottom-0" src="{{ public_path('images/pdfMil/footer-pdf-mil.jpg') }}" >

</body>
</html>
