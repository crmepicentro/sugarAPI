<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ public_path('css/solicitud_style.css') }}">
    <title>CASABACA</title>

</head>
<body>
    <img class="bb-width-100 bb-mb-30" src="{{ public_path('images/solicitud/cabecera-cb-natural.jpg') }}" alt="cabecera-logo-natural">
<!-- /*   Fin Cabecera   */ -->


    <div class="bb-max-width bb-mx-auto bb-width-100 bb-mb-30">
        <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mb-20 bb-ml-3" >Datos Generales</div>
        <table class="bb-width-100">

            <tr>
                <td class="bb-px-5 bb-py-5 bb-pl-none">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Producto</div>
                </td>
                <td class="bb-px-5 bb-py-5">
                    <div class=" bb-font-medium  bb-text-17 bb-border-red bb-cot">ID de Cotización</div>
                </td>
                <td ></td>
                <td ></td>
            </tr>

            <tr >
                <td class="bb-px-5 bb-py-5 bb-pl-none">
                    <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Valor de Producto</div>
                </td>
                <td class="bb-px-5 bb-py-5">
                    <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Entrada</div></td>
                <td class="bb-px-5 bb-py-5">
                    <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Valor a financiar</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-pr-none">
                    <div class="bb-flex">
                        <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-op-1 bb-text-gray">Plazo</div>
                        <div class="bb-form-text bb-font-medium bb-text-17 bb-op-2 bb-border-me" >meses</div>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="bb-px-5 bb-py-5 bb-pl-none">
                    <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Fecha de solicitud</div>
                </td>
                <td colspan="2" class="bb-px-5 bb-py-5">
                    <div class="bb-font-medium bb-bg-gray bb-text-17 bb-form-text bb-text-gray">Asesor</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-pr-none">
                    <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Agencia</div>
                </td>
            </tr>


        </table>
    </div>

<!-- Formulario 2 -->
    <div class="bb-max-width bb-mx-auto bb-width-100 bb-mb-30">
        <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mb-20 bb-ml-3" >Datos personales del cliente</div>
        <table class="bb-width-100">

            <tr>
                <td colspan="3" class="bb-px-5 bb-py-5 bb-pl-none bb-width-100 bb-pr-none">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Nombre completo</div>
                </td>
            </tr>

            <tr >
                <td  class="bb-px-5 bb-py-5 bb-pl-none">
                    <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">No. de cédula</div>
                </td>
                <td class="bb-px-5 bb-py-5">
                    <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">No. de pasaporte</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-pr-none">
                    <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">RUC</div>
                </td>

            </tr>

            <tr>
                <td class="bb-px-5 bb-py-5 bb-pl-none">
                    <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Estado Civil</div>
                </td>
                <td class="bb-px-5 bb-py-5">
                    <div class="bb-font-medium bb-bg-gray bb-text-17 bb-form-text bb-text-gray">Separación de bienes</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-pr-none">
                    <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Cargas familiares</div>
                </td>

            </tr>

            <tr>
                <td colspan= "2" class="bb-px-5 bb-py-5 bb-pl-none">
                    <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Nombre completo del cónyugue</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-pr-none">
                    <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">No. cédula del cónyugue</div>
                </td>
            </tr>


        </table>
    </div>

<!-- Formulario 3 -->
<div class="bb-max-width bb-mx-auto bb-width-100 bb-mb-30">
    <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mb-20 bb-ml-3" >Datos de ubicación de domicilio</div>
    <table class="bb-width-100">

        <tr>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Provincia</div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5">
                <div class=" bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Ciudad</div>
            </td>
        </tr>

        <tr >
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none">
                <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Calle principal</div>
            </td>
            <td class="bb-px-5 bb-py-5">
                <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">No.</div>
            </td>
            <td colspan="3"class="bb-px-5 bb-py-5 bb-pr-none">
                <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Calle secundaria</div>
            </td>

        </tr>

        <tr>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none">
                <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Sector/Barrio</div>
            </td>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pr-none">
                <div class="bb-font-medium bb-bg-gray bb-text-17 bb-form-text bb-text-gray">No. teléfono fijo</div>
            </td>

        </tr>

        <tr>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none">
                <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">No. de celular</div>
            </td>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pr-none">
                <div class="bb-font-medium bb-bg-gray bb-text-17 bb-form-text bb-text-gray">Correo electrónico</div>
            </td>

        </tr>

        <tr>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none">
                <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Su casa es</div>
            </td>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pr-none">
                <div class="bb-flex">
                    <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-op-4 bb-text-gray">Tiempo de residencia</div>
                    <div class="bb-form-text bb-font-medium bb-text-17 bb-op-3 bb-border-me bb-text-center" >años</div>
                </div>
            </td>
        </tr>


    </table>
</div>

<!-- Formulario 4 -->
<div class="bb-max-width bb-mx-auto bb-width-100 bb-mb-30">
    <table class="bb-width-100">
        <tr>
            <td rowspan="4" valign="top" width="250">
                <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mb-20 bb-ml-3" >Datos de trabajo / actividad económica del cliente</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-pl-none">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Situación Laboral</div></td>
            <td></td>
        </tr>

        <tr >
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none">
                <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Nombre de la empresa</div>
            </td>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pr-none">
                <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Actividad de empresa</div>
            </td>

        </tr>

        <tr>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none">
                <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Cargo</div>
            </td>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pr-none">
                <div class="bb-flex">
                    <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-op-4 bb-text-gray">Tiempo de trabajo</div>
                    <div class="bb-form-text bb-font-medium bb-text-17 bb-op-3 bb-border-me bb-text-center" >años</div>
                </div>
            </td>

        </tr>



        <tr>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none">
                <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Dirección empresa</div>
            </td>
            <td colspan="3" class="bb-px-5 bb-py-5 bb-pr-none">
                <div class="bb-font-medium bb-bg-gray bb-text-17 bb-form-text bb-text-gray">Teléfono</div>
            </td>
            <td  class="bb-px-5 bb-py-5 bb-pr-none">
                <div class="bb-font-medium bb-bg-gray bb-text-17 bb-form-text bb-text-gray">ext.</div>
            </td>

        </tr>
    </table>
</div>
<div class="bb-max-width bb-mx-auto bb-width-100 bb-mb-30">
    <table class="bb-width-100">
        <table class="bb-width-100">
            <tr>
                <td rowspan="4" valign="top" width="250">
                    <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mb-20 bb-ml-3" >Datos de trabajo / actividad económica del cónyugue</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-pl-none">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Situación Laboral</div></td>
                <td></td>
            </tr>

            <tr >
                <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none">
                    <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Nombre de la empresa</div>
                </td>
                <td colspan="4" class="bb-px-5 bb-py-5 bb-pr-none">
                    <div class="bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray">Actividad de empresa</div>
                </td>

            </tr>

            <tr>
                <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none">
                    <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Cargo</div>
                </td>
                <td colspan="4" class="bb-px-5 bb-py-5 bb-pr-none">
                    <div class="bb-flex">
                        <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-op-4 bb-text-gray">Tiempo de trabajo</div>
                        <div class="bb-form-text bb-font-medium bb-text-17 bb-op-3 bb-border-me bb-text-center" >años</div>
                    </div>
                </td>

            </tr>

            <tr>
                <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none">
                    <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Dirección empresa</div>
                </td>
                <td colspan="3" class="bb-px-5 bb-py-5 bb-pr-none">
                    <div class="bb-font-medium bb-bg-gray bb-text-17 bb-form-text bb-text-gray">Teléfono</div>
                </td>
                <td  class="bb-px-5 bb-py-5 bb-pr-none">
                    <div class="bb-font-medium bb-bg-gray bb-text-17 bb-form-text bb-text-gray">ext.</div>
                </td>

            </tr>

    </table>
</div>

<!-- Formulario 5 -->
<div class="bb-max-width bb-mx-auto bb-width-100 bb-mb-30">
    <table class="bb-width-100" >
        <tr>
            <td class="bb-title2">
                <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mb-20 bb-ml-3" > Ingresos mensuales</div>
            </td>
            <td class="bb-title2">
                <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mb-20 bb-ml-3" > Gastos / egresos mensuales </div>
            </td>
        </tr>

    </table>
    <table class="bb-width-100">

        <tr>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none " width="21%">
                <div class= "bb-border-bt bb-font-medium bb-pb-5 bb-pl-3 bb-text-17 bb-text-gray">Sueldo/Ventas mensuales</div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pr-none bb-pl-15" width="25%">
                <div class=" bb-bg-gray bb-font-medium bb-pd-10 bb-text-17 bb-text-gray">$</div>
            </td>
            <td class="bb-width-80"></td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none" width="21%">
                <div class="bb-border-bt bb-font-medium bb-pb-5 bb-pl-3 bb-text-17 bb-text-gray">Alimentación</div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pr-none bb-pl-15" width="25%">
                <div class="bb-bg-gray bb-font-medium bb-pd-10 bb-text-17 bb-text-gray">$</div>
            </td>
        </tr>

        <tr >
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none" width="21%">
                <div class="bb-border-bt bb-font-medium bb-pb-5 bb-pl-3 bb-text-17 bb-text-gray">Otros ingresos</div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pr-none bb-pl-15" width="25%">
                <div class="bb-bg-gray bb-font-medium bb-pd-10 bb-text-17 bb-text-gray">$</div>
            </td>
            <td class="bb-width-80"></td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none" width="21%">
                <div class="bb-border-bt bb-font-medium bb-pb-5 bb-pl-3 bb-text-17 bb-text-gray">Arriendo / Vivienda</div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pr-none bb-pl-15" width="25%">
                <div class="bb-bg-gray bb-font-medium bb-pd-10 bb-text-17 bb-text-gray">$</div>
            </td>

        </tr>

        <tr>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none" width="21%">
                <div class="bb-border-bt bb-pb-5 bb-text-17 bb-pl-3 bb-text-gray bb-font-bold">Total ingresos</div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pr-none bb-pl-15" width="25%">
                <div class="bb-font-medium bb-border-me bb-pd-10 bb-text-17 bb-text-gray">$</div>
            </td>
            <td class="bb-width-80"></td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none" width="21%">
                <div class="bb-border-bt bb-font-medium bb-pb-5 bb-pl-3 bb-text-17 bb-text-gray">Entidades bancarias</div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pr-none bb-pl-15" width="25%">
                <div class="bb-border-me bb-font-medium bb-pd-10 bb-text-17 bb-text-gray">$</div>
            </td>

        </tr>

        <tr>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none" width="21%">
                <div class="bb-border-bt  bb-font-medium bb-pb-5 bb-pl-3 bb-text-17 bb-text-gray">Sueldo del cónyugue</div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pr-none bb-pl-15" width="25%">
                <div class="bb-font-medium bb-bg-gray bb-text-17 bb-pd-10 bb-text-gray">$</div>
            </td>
            <td class="bb-width-80"></td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none" width="21%">
                <div class="bb-border-bt bb-font-medium bb-pb-5 bb-pl-3 bb-text-17 bb-text-gray">Otros gastos</div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pr-none bb-pl-15" width="25%">
                <div class="bb-bg-gray bb-font-medium bb-pd-10 bb-text-17 bb-text-gray">$</div>
            </td>

        </tr>

        <tr>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none" width="21%">
                <div class="bb-border-bt bb-font-bold bb-pb-5 bb-pl-3 bb-text-17 bb-text-gray"><span>Total ingreso familiar</span> </div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pr-none bb-pl-15" width="25%">
                <div class="bb-border-me bb-font-medium bb-pd-10 bb-text-17 bb-text-gray">$</div>
            </td>
            <td class="bb-width-80"></td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none" width="21%">
                <div class="bb-border-bt bb-font-bold bb-pb-5 bb-pl-3 bb-text-17 bb-text-gray ">Total gastos / egresos</div>
            </td>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pr-none bb-pl-15" width="25%">
                <div class="bb-border-me bb-font-medium bb-pd-10 bb-text-17 bb-text-gray ">$</div>
            </td>

        </tr>

        <tr>
            <td colspan="4" class="bb-px-5 bb-py-5 bb-pl-none bb-pr-none">
                <div class="bb-bg-gray bb-form-text bb-font-medium bb-text-17 bb-text-gray">Descripción otros ingresos</div>
            </td>

        </tr>


    </table>
</div>
<!-- Formulario 6 -->
<div class="bb-max-width bb-mx-auto bb-width-100 bb-mb-30">

    <table class="bb-width-100">

    <div class="bb-max-width bb-mx-auto bb-width-100">
        <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mt-30 bb-mb-10 bb-ml-3" >Situación patrimonial</div>
        <table class="bb-width-100 bb-mt-15 bb-mb-6"><tr><td class="bb-border-btg bb-py-5 bb-px-5 bb-mb-5 "></td></tr></table>
        <table class="bb-width-100 " >
            <tr >
                <td class="bb-px-5 bb-py-5 bb-pl-none bb-width-20">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Bienes/Inmuebles</div>
                </td>
                <td colspan="2" class="bb-px-5 bb-py-5 bb-width-40 ">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Ciudad/Dirección</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-width-20 ">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Valor comercial</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-pr-none bb-width-20">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Hipotecado</div>
                </td>
            </tr>
        </table>
        <table class="bb-width-100 bb-mb-6"><tr><td class="bb-border-btg bb-py-5 bb-px-5 bb-mb-5 "></td></tr></table>

        <table class="bb-width-100 bb-mt-5">
            <tr>
                <td class="bb-px-5 bb-py-5 bb-pl-none bb-width-20 ">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Marca vehículo</div>
                </td>
                <td  class="bb-px-5 bb-py-5 bb-width-25 ">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Modelo</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-width-15  ">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Año</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-width-20">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Valor comercial</div>
                </td>
                <td class="bb-px-5 bb-py-5 bb-pr-none bb-width-20">
                    <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Prendado</div>
                </td>
            </tr>
        </table>
        <table class="bb-width-100"><tr><td class="bb-border-btg bb-py-5 bb-px-5 "></td></tr></table>
    </div>
</div>


<!-- Formulario 7 -->
<div class="bb-max-width bb-mx-auto bb-width-100 bb-mb-30">
    <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mb-20 bb-ml-3" >Referencias bancarias</div>
    <table class="bb-width-100">
        <tr>
            <td class="bb-px-5 bb-py-5 bb-pl-none bb-width-20 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Institución</div>
            </td>
            <td  class="bb-px-5 bb-py-5 bb-width-20 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Tipo de cuenta</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-width-17  ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">No. de cuenta</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-width-25 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Tipo de Tarjeta de crédito</div>
            </td>
            <td class="bb-px-5 bb-py-5  bb-pr-none  bb-width-17">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Emisor</div>
            </td>
        </tr>
        <tr>
            <td class="bb-px-5 bb-py-5 bb-pl-none bb-width-20 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Institución</div>
            </td>
            <td  class="bb-px-5 bb-py-5 bb-width-20 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Tipo de cuenta</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-width-17 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">No. de cuenta</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-width-25">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Tipo de Tarjeta de crédito</div>
            </td>
            <td class="bb-px-5 bb-py-5  bb-pr-none bb-width-17 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Emisor</div>
            </td>
        </tr>

    </table>
</div>
<div class="bb-max-width bb-mx-auto bb-width-100 bb-mb-30">
    <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mb-20 bb-ml-3" >Referencias: 1 familiar y 2 personales</div>
    <table class="bb-width-100">
        <tr>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none bb-width-40 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Nombre completo</div>
            </td>
            <td  class="bb-px-5 bb-py-5 bb-width-25">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Relación con el cliente</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-width-17">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Ciudad</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-pr-none bb-width-17">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Teléfono</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none bb-width-40">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Nombre completo</div>
            </td>
            <td  class="bb-px-5 bb-py-5 bb-width-25">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Relación con el cliente</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-width-17">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Ciudad</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-pr-none bb-width-17">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Teléfono</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="bb-px-5 bb-py-5 bb-pl-none bb-width-40 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Nombre completo</div>
            </td>
            <td  class="bb-px-5 bb-py-5 bb-width-25" >
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Relación con el cliente</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-width-17">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Ciudad</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-pr-none bb-width-17">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Teléfono</div>
            </td>
        </tr>
    </table>
</div>
<div class="bb-max-width bb-mx-auto bb-width-100 bb-mb-30">
    <div class="bb-width-100 bb-text-19 bb-font-semibold bb-mb-20 bb-ml-3" >Referencias comerciales</div>
    <table class="bb-width-100">
        <tr>
            <td class="bb-px-5 bb-py-5 bb-pl-none bb-width-40 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Empresa</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-width-30">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Ciudad</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-pr-none bb-width-30">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Teléfono</div>
            </td>
        </tr>
        <tr>
            <td class="bb-px-5 bb-py-5 bb-pl-none bb-width-40 ">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Empresa</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-width-30">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Ciudad</div>
            </td>
            <td class="bb-px-5 bb-py-5 bb-pr-none bb-width-30">
                <div class= "bb-bg-gray bb-font-medium bb-form-text bb-text-17 bb-text-gray ">Teléfono</div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
