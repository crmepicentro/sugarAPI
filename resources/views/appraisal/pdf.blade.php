<html>
    <head>
        <style type="text/css">
				        @page teacher {
                    size: A4 portrait;
                    margin: 0px;
                    padding:0px;
                }
                .teacherPage {
                    page: teacher;
                    page-break-after: always;
                }
                #head{
                    display:block;
                    float:left;
                }
                .txt_head{
                    width: 100%;
                    text-align: center;
                    font-size:32px;
                    font-weight:bold;
                    margin:0 0 0 0;
                }
                body{
                    font-family:Arial, Helvetica, sans-serif;
                    color:#666;
                    font-size:11px;
                    /*background-color:#E51F26;*/
                }
                .campos_b{
                    text-align:left;
                    display: inline-table;
                    float:left;
                    font-weight:bold;
                    color: #283173;
                    font-size: 16px;
                }
                .box-nomral{
                    padding: 5px 10px;
                    margin: 0 auto;
                    border:none;
                }
                .box{
                    padding: 5px 10px;
                    margin: 0 auto;
                    border:solid 2px #283173;
                    border-radius: 25px;
                }
                .respuesta{
                    text-align:left;
                    display: inline-table;
                    float:left;
                    font-size: 16px;
                }
                .head-table{
                    background-color: #283173 !important;
                    color: #ffffff;
                    padding-bottom: 0.2rem;
                    text-align: center;
                    font-size: 20px;
                    font-weight: bold;
                    height: 40px;
                    line-height: 41px;
                }
                .pad{
                    padding: 0px !important;
                }
                .container {
                    background: linear-gradient(
                        to right,
                        #283173 0%,
                        #283173 50%,
                        #ffffff 50%,
                        #ffffff  100%
                    );
                    height: 90px;
                }
                .title-oferta{
                    margin: 0 auto;
                    text-align: center;
                    color: #ffffff;
                    font-size: 40px;
                    font-weight: bold;
                    line-height: 65px;
                }
                .text-oferta{
                    font-size: 30px;
                    font-weight: bolder;
                    text-align: center;
                }
                .oferta-valida{
                    color:#283173;
                    font-size: 30px;
                    font-weight: bolder;
                    text-align: center;
                }
                .texto-fecha{
                    color:#666;
                    font-size: 25px;
                    font-weight: bolder;
                    text-align: center;
                }
                .img-header{
                    width: 100%;
                    text-align: left;
                    padding: 1px;
                }
            </style>
            <title>Avaluo</title>
            <meta name="author" content="asesor">
    </head>

    <div style="margin: 0px;padding: 0px;">
        <div class="img-header">
            <img class="img-header" src="{{ public_path('/images/hoja_01.png') }}" >
        </div>
        <br />
        <br />
        <div class="box pad" style="margin:0px 25px 25px 25px auto;">
            <table width="95%" border="0" cellspacing="0" cellpadding="5" style="margin:10px 20px 10px 20px;">
              <tr>
                  <td colspan="2"><span class="campos_b">NOMBRE: </span><span class="respuesta">{{ mb_convert_case($name, MB_CASE_UPPER, "UTF-8") }}</span></td>
              </tr>
              <tr>
                  <td><span class="campos_b">CÉDULA: </span><span class="respuesta">{{ $document }}</span></td>
                  <td><span class="campos_b">PLACA: </span><span class="respuesta">{{$plate}}</span></td>
              </tr>
              <tr>
                  <td ><span class="campos_b">MARCA: </span><span class="respuesta">{{ mb_convert_case($brand['name'], MB_CASE_UPPER, "UTF-8") }}</span></td>
                  <td ><span class="campos_b">MODELO: </span><span class="respuesta">{{ mb_convert_case($model['name'], MB_CASE_UPPER, "UTF-8") }}</span></td>
              </tr>
              <tr>
                  <td ><span class="campos_b">COLOR: </span><span class="respuesta">{{ mb_convert_case($color['name'], MB_CASE_UPPER, "UTF-8") }}</span></td>
                  <td ><span class="campos_b">AÑO: </span><span class="respuesta">{{$year}}</span></td>
              </tr>
              <tr>
                  <td ><span class="campos_b">RECORRIDO: </span><span class="respuesta">{{$mileage}} {{ mb_convert_case($unity, MB_CASE_UPPER, "UTF-8") }}</span></td>
                  <td ><span class="campos_b">DESCRIPCIÓN: </span><span class="respuesta">{{ mb_convert_case($description['description'], MB_CASE_UPPER, "UTF-8") }}</span></td>
              </tr>
              <tr>
                  <td colspan="2"><span class="campos_b">OBSERVACIÓN: </span><span class="respuesta">{{ mb_convert_case($observation, MB_CASE_UPPER, "UTF-8") }}</span></td>
              </tr>
            </table>
        </div>
        <br />
        <div class="box pad" style="margin:0px 25px 25px 25px auto;">
            <div style="border-radius: 1rem 1rem 0 0;" class="head-table">CONDICIÓN DEL VEHÍCULO</div>
            <table width="95%" border="0" cellspacing="0" cellpadding="5" style="margin:10px 20px 10px 20px;">
              @foreach($checklist as $key => $item)
                @if(($key % 2) == 0) <tr> @endif
                    <td ><span class="campos_b">{{ mb_convert_case($item['description'], MB_CASE_UPPER, "UTF-8") }}: </span><span class="respuesta">{{$statusCheck[$item['option']]}}</span></td>
                @if(($key % 2) != 0) </tr> @endif
              @endforeach
            </table>
        </div>
        <br/>
        <div class="box">
            <table width="100%" border="0" cellspacing="0" cellpadding="0"style="margin:15px 15px 15px 15px;">
              <tr>
                  <td ><div class="oferta-valida">OFERTA&nbsp;</div></td>
                  <td ><div class="text-oferta">$ {{number_format($priceApproved,2,".",",")}} </div></td>
              </tr>
            </table>
        </div>
        <div class="box-normal" style="margin:15px auto;">
            <table width="100%" border="0" cellspacing="3" cellpadding="3">
              <tr>
                  <td colspan="2" ><span class="campos_b">COORDINADOR:&nbsp;</span><span class="respuesta">{{$coordinator['name']}}</span></td>
              </tr>
              <tr>
                  <td ><span class="campos_b">AVALÚO:&nbsp;</span><span class="respuesta">{{$alias}}</span></td>
                  <td rowspan="2" >
                    <div class="oferta-valida">Oferta válida hasta</div>
                    <div class="texto-fecha">{{$dateValid}}</div>
                  </td>
              </tr>
              <tr>
                  <td ><span class="campos_b">FECHA:&nbsp;</span><span class="respuesta">{{$date}}</span></td>
              </tr>
            </table>
        </div>
    </div>
    <br>
    <div class="footer">
    * Precio sujeto a una aprobación de control legal.
    <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="padding-bottom: 25px;">
          <tr >
            <td class="img-header">
              <img class="img-header" src="{{ public_path('/images/hoja_03.jpg') }}" >
            </td>
          </tr>
        </table>
    </div>
    </body>
    </html>
