<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>API Reference</title>

    <link rel="stylesheet" href="{{ asset('/docs/css/style.css') }}" />
    <script src="{{ asset('/docs/js/all.js') }}"></script>


    <script>
        $(function() {
            setupLanguages(["bash","javascript","php"]);
        });
    </script>
</head>

<body class="">
<a href="#" id="nav-button">
      <span>
        NAV
        <img src="/docs/images/navbar.png" />
      </span>
</a>
<div class="tocify-wrapper">
    <img src="/docs/images/logo.png" width="230px"/>
    <div class="lang-selector">
        <a href="#" data-language-name="bash">bash</a>
        <a href="#" data-language-name="javascript">javascript</a>
        <a href="#" data-language-name="php">php</a>
    </div>
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>
    <ul class="search-results"></ul>
    <div id="toc">
    </div>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <!-- START_INFO -->
        <h1>Info</h1>
        <p>Bienvenido a la documentación "API SUGAR EPICENTRO DIGITAL"</p>
        <!-- END_INFO -->
        <h1>Asesores</h1>
        <p>Api para Obtener asesores</p>
        <!-- START_00dbeb8940289d032b92cdc45e9b945e -->
        <h2>Obtiene los asesores comerciales disponibles de un medio requerido</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X GET \
    -G "https://api-sugarcrm.casabaca.com/api/asesores" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"medio":"11"}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/asesores"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "medio": "11"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api-sugarcrm.casabaca.com/api/asesores',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'medio' =&gt; '11',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": [
        {
            "nombres": "FRANCISCO XAVIER",
            "apellidos": "VILLAMAR CASTRO",
            "celular": "0987647944",
            "user_name": "MA_PALACIOS",
            "email": "fvillamar@1001carros.com",
            "agencia": "CUMBAYA",
            "lineas_negocio": [
                "SEMINUEVOS"
            ]
        },
        {
            "nombres": "Admin",
            "apellidos": "SugarCRM",
            "celular": null,
            "user_name": "admin",
            "email": "mwherrera@plus-projects.com",
            "agencia": "MATRIZ",
            "lineas_negocio": []
        }
    ]
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>GET api/asesores</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>medio</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Medio requerido</td>
            </tr>
            </tbody>
        </table>
        <!-- END_00dbeb8940289d032b92cdc45e9b945e -->
        <h1>Autenticación</h1>
        <p>APIs para gestión de tokens</p>
        <!-- START_d7b7952e7fdddc07c978c9bdaf757acf -->
        <h2>Crear usuario</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"name":"Maria","email":"mart@hotmail.com","password":"Hol@MunD0","fuente":"inconcert","fuente_id":"2","medios":"2,3,5","compania":"1"}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "name": "Maria",
    "email": "mart@hotmail.com",
    "password": "Hol@MunD0",
    "fuente": "inconcert",
    "fuente_id": "2",
    "medios": "2,3,5",
    "compania": "1"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/register',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'name' =&gt; 'Maria',
            'email' =&gt; 'mart@hotmail.com',
            'password' =&gt; 'Hol@MunD0',
            'fuente' =&gt; 'inconcert',
            'fuente_id' =&gt; '2',
            'medios' =&gt; '2,3,5',
            'compania' =&gt; '1',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "status_code": "200",
    "message": "Usuario Creado Correctamente"
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Usuario Creado Correctamente"
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/register</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>name</code></td>
                <td>string</td>
                <td>required</td>
                <td>el nombre del usuario.</td>
            </tr>
            <tr>
                <td><code>email</code></td>
                <td>email</td>
                <td>required</td>
                <td>email El email del usuario.</td>
            </tr>
            <tr>
                <td><code>password</code></td>
                <td>string</td>
                <td>optional</td>
            </tr>
            <tr>
                <td><code>fuente</code></td>
                <td>tipo</td>
                <td>optional</td>
                <td>de fuente.</td>
            </tr>
            <tr>
                <td><code>fuente_id</code></td>
                <td>Id</td>
                <td>optional</td>
                <td>de la fuente.</td>
            </tr>
            <tr>
                <td><code>medios</code></td>
                <td>Medios</td>
                <td>optional</td>
                <td>de acceso.</td>
            </tr>
            <tr>
                <td><code>compania</code></td>
                <td>Id</td>
                <td>optional</td>
                <td>de la compania.</td>
            </tr>
            </tbody>
        </table>
        <!-- END_d7b7952e7fdddc07c978c9bdaf757acf -->
        <!-- START_c3fa189a6c95ca36ad6ac4791a873d23 -->
        <h2>Crear un token de usuario</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"email":"mart@hotmail.com","password":"Hol@MunD0"}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "email": "mart@hotmail.com",
    "password": "Hol@MunD0"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/login',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'email' =&gt; 'mart@hotmail.com',
            'password' =&gt; 'Hol@MunD0',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "status_code": "200",
    "token": "slghn1EDIJjMvYNkAFQvnHGfPDl5srH8X11TKyl"
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Password incorrecto"
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/login</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>email</code></td>
                <td>email</td>
                <td>required</td>
                <td>El email del usuario.</td>
            </tr>
            <tr>
                <td><code>password</code></td>
                <td>string</td>
                <td>required</td>
            </tr>
            </tbody>
        </table>
        <!-- END_c3fa189a6c95ca36ad6ac4791a873d23 -->
        <!-- START_00e7e21641f05de650dbe13f242c6f2c -->
        <h2>Expirar un token de usuario</h2>
        <p>Debe enviar en las cabeceras el token de autorización
            Ejemplo: Authorization Bearer 1|slghn1EDIJjMvYNkAFQvnHGfPDl5srH8XM11Kyly</p>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X GET \
    -G "https://api-sugarcrm.casabaca.com/api/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/logout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api-sugarcrm.casabaca.com/api/logout',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "status_code": 200,
    "token": "Token has deleted succesfully"
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>GET api/logout</code></p>
        <!-- END_00e7e21641f05de650dbe13f242c6f2c -->
        <h1>Landing Pages</h1>
        <p>API para crear, actualizar landing pages</p>
        <!-- START_f24644e7d8f231a4b87c73b05b64be4e -->
        <h2>Landing Pages</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/create_landing_page" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"name":"Exonerados","medio":"18","properties_form":"[{\"label\": \"Tipo de discapacidad\",\"value\": \"tipo_discapacidad\",\"validations\": \"required\" } ]","autorizador":"autorizador@gmail.com","campaign":"RODRIGUEZ 0626c2b0-1ad2-11ea-830b-000c297d72b1","business_line_id":"f417e1ae-a81b-11e9-ab2c-000c297d72b1","user_login":"tde","type_transaction":"1","user_assigned_position":"2"}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/create_landing_page"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "name": "Exonerados",
        "medio": "18",
        "properties_form": "[{\"label\": \"Tipo de discapacidad\",\"value\": \"tipo_discapacidad\",\"validations\": \"required\" } ]",
        "autorizador": "autorizador@gmail.com",
        "campaign": "RODRIGUEZ 0626c2b0-1ad2-11ea-830b-000c297d72b1",
        "business_line_id": "f417e1ae-a81b-11e9-ab2c-000c297d72b1",
        "user_login": "tde",
        "type_transaction": "1",
        "user_assigned_position": "2"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/create_landing_page',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'name' =&gt; 'Exonerados',
                'medio' =&gt; '18',
                'properties_form' =&gt; '[{"label": "Tipo de discapacidad","value": "tipo_discapacidad","validations": "required" } ]',
                'autorizador' =&gt; 'autorizador@gmail.com',
                'campaign' =&gt; 'RODRIGUEZ 0626c2b0-1ad2-11ea-830b-000c297d72b1',
                'business_line_id' =&gt; 'f417e1ae-a81b-11e9-ab2c-000c297d72b1',
                'user_login' =&gt; 'tde',
                'type_transaction' =&gt; '1',
                'user_assigned_position' =&gt; '2',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "status_code": "200",
        "messsage": "Landing Page creada correctamente"
    }
}</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "status_code": "400",
        "messsage": "Revise que sus datos sean correctos"
    }
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/create_landing_page</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.name</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombre del Formulario</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.medio</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>ID del medio.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.properties_form</code></td>
                <td>array</td>
                <td>required</td>
                <td>Propiedades Extras del Formulario</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.autorizador</code></td>
                <td>string</td>
                <td>required</td>
                <td>Email del autorizador.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.campaign</code></td>
                <td>string</td>
                <td>required</td>
                <td>Código de Campaña.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.business_line_id</code></td>
                <td>string</td>
                <td>required</td>
                <td>Código de linea de negocio.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.user_login</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Celular del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.type_transaction</code></td>
                <td>numeric</td>
                <td>optional</td>
                <td>Tipo de Trasnsacción Valores válidos: 1 (Ventas),2 (Tomas),3 (Quejas),4 (Info General)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.user_assigned_position</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Cargo del usuario para asignación</td>
            </tr>
            </tbody>
        </table>
        <!-- END_f24644e7d8f231a4b87c73b05b64be4e -->
        <h1>Prospección</h1>
        <p>APIs para creación de prospectos, reagendamiento de citas, cierre de prospectos</p>
        <!-- START_5675906540fb61185904594cc17d7875 -->
        <h2>Prospección - cotización (whatsApp, webChat y Facebook)</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/quotation" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"user_name_call_center":"CG_RAMOS","ticket_id":"10438baf-0d83-9533-4fb3-602ea326288b","comments":"El cliente se acerca a la agencia...","modelo":"Hilux 4X4 2021 color rojo","medio":"10","campania":"5e686580-ee19-11ea-97ea-000c297d72b1","client":{"tipo_identificacion":"C","numero_identificacion":"1719932079","gender":"M","names":"Roberto Daniel","surnames":"J\u00e1come Rodriguez","phone_home":"022072845","cellphone_number":"0987512224","email":"mart2021@hotmail.com"}},"datos_adicionales":{"anyproperty1":"anyData1","anyproperty1N":"anyData2"}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/quotation"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "user_name_call_center": "CG_RAMOS",
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "comments": "El cliente se acerca a la agencia...",
        "modelo": "Hilux 4X4 2021 color rojo",
        "medio": "10",
        "campania": "5e686580-ee19-11ea-97ea-000c297d72b1",
        "client": {
            "tipo_identificacion": "C",
            "numero_identificacion": "1719932079",
            "gender": "M",
            "names": "Roberto Daniel",
            "surnames": "J\u00e1come Rodriguez",
            "phone_home": "022072845",
            "cellphone_number": "0987512224",
            "email": "mart2021@hotmail.com"
        }
    },
    "datos_adicionales": {
        "anyproperty1": "anyData1",
        "anyproperty1N": "anyData2"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/quotation',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'user_name_call_center' =&gt; 'CG_RAMOS',
                'ticket_id' =&gt; '10438baf-0d83-9533-4fb3-602ea326288b',
                'comments' =&gt; 'El cliente se acerca a la agencia...',
                'modelo' =&gt; 'Hilux 4X4 2021 color rojo',
                'medio' =&gt; '10',
                'campania' =&gt; '5e686580-ee19-11ea-97ea-000c297d72b1',
                'client' =&gt; [
                    'tipo_identificacion' =&gt; 'C',
                    'numero_identificacion' =&gt; '1719932079',
                    'gender' =&gt; 'M',
                    'names' =&gt; 'Roberto Daniel',
                    'surnames' =&gt; 'Jácome Rodriguez',
                    'phone_home' =&gt; '022072845',
                    'cellphone_number' =&gt; '0987512224',
                    'email' =&gt; 'mart2021@hotmail.com',
                ],
            ],
            'datos_adicionales' =&gt; [
                'anyproperty1' =&gt; 'anyData1',
                'anyproperty1N' =&gt; 'anyData2',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "prospeccion_url": "https:\/\/sugarcrm.casabaca.com\/#cbp_Prospeccion\/b9400c64-9a35-cf31-cf26-604bcac73032"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "datosSugarCRM.user_name_call_center": [
            "User-name inválido, call center no se encuentra registrado"
        ],
        "datosSugarCRM.client.tipo_identificacion": [
            "Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/quotation</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.user_name_call_center</code></td>
                <td>string</td>
                <td>required</td>
                <td>UserName del call center válido en SUGAR.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.ticket_id</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID del Ticket de SUGAR al que hace referencia.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.comments</code></td>
                <td>string</td>
                <td>required</td>
                <td>Comentarios/descripción acerca del prospecto.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.modelo</code></td>
                <td>string</td>
                <td>required</td>
                <td>Modelo a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.medio</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Medio de la llamada</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.campania</code></td>
                <td>id</td>
                <td>optional</td>
                <td>Campaña de la llamada</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.tipo_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Tipo de identificación del ciente a cotizar, valores válidos  C(Cedula),P(Pasaporte), R(RUC).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.numero_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Número de identificación del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.gender</code></td>
                <td>string</td>
                <td>required</td>
                <td>Género del cliente a cotizar. valores válidos: F (Femenino),M (Masculino)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.names</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombres del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.surnames</code></td>
                <td>string</td>
                <td>required</td>
                <td>Apellido del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.phone_home</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Telefono Local del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.cellphone_number</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Celular del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.email</code></td>
                <td>email</td>
                <td>required</td>
                <td>email del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.anyproperty1</code></td>
                <td>any</td>
                <td>optional</td>
                <td>Datos adicionales de la aplicación externa</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.anyproperty1N</code></td>
                <td>any</td>
                <td>optional</td>
                <td>Datos adicionales de la aplicación externa</td>
            </tr>
            </tbody>
        </table>
        <!-- END_5675906540fb61185904594cc17d7875 -->
        <!-- START_1ca6da367f10e1fec3fa291a8eb234d2 -->
        <h2>Prospección - cotización (1800)</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/call_quotation" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"user_name_call_center":"CG_RAMOS","date_start":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"10","direction":"Inbound","type":"seguimiento","ticket_id":"10438baf-0d83-9533-4fb3-602ea326288b","comments":"El cliente se acerca a la agencia...","modelo":"Hilux 4X4 2021 color rojo","medio":"13","client":{"tipo_identificacion":"C","numero_identificacion":"1719932079","gender":"M","names":"Roberto Daniel","surnames":"J\u00e1come Rodriguez","phone_home":"022072845","cellphone_number":"0987512224","email":"mart2021@hotmail.com"}},"datos_adicionales":{"anyproperty1":"anyData1","anyproperty1N":"anyData2"}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/call_quotation"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "user_name_call_center": "CG_RAMOS",
        "date_start": "2021-10-02 19:59",
        "duration_hours": "0",
        "duration_minutes": "10",
        "direction": "Inbound",
        "type": "seguimiento",
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "comments": "El cliente se acerca a la agencia...",
        "modelo": "Hilux 4X4 2021 color rojo",
        "medio": "13",
        "client": {
            "tipo_identificacion": "C",
            "numero_identificacion": "1719932079",
            "gender": "M",
            "names": "Roberto Daniel",
            "surnames": "J\u00e1come Rodriguez",
            "phone_home": "022072845",
            "cellphone_number": "0987512224",
            "email": "mart2021@hotmail.com"
        }
    },
    "datos_adicionales": {
        "anyproperty1": "anyData1",
        "anyproperty1N": "anyData2"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/call_quotation',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'user_name_call_center' =&gt; 'CG_RAMOS',
                'date_start' =&gt; '2021-10-02 19:59',
                'duration_hours' =&gt; '0',
                'duration_minutes' =&gt; '10',
                'direction' =&gt; 'Inbound',
                'type' =&gt; 'seguimiento',
                'ticket_id' =&gt; '10438baf-0d83-9533-4fb3-602ea326288b',
                'comments' =&gt; 'El cliente se acerca a la agencia...',
                'modelo' =&gt; 'Hilux 4X4 2021 color rojo',
                'medio' =&gt; '13',
                'client' =&gt; [
                    'tipo_identificacion' =&gt; 'C',
                    'numero_identificacion' =&gt; '1719932079',
                    'gender' =&gt; 'M',
                    'names' =&gt; 'Roberto Daniel',
                    'surnames' =&gt; 'Jácome Rodriguez',
                    'phone_home' =&gt; '022072845',
                    'cellphone_number' =&gt; '0987512224',
                    'email' =&gt; 'mart2021@hotmail.com',
                ],
            ],
            'datos_adicionales' =&gt; [
                'anyproperty1' =&gt; 'anyData1',
                'anyproperty1N' =&gt; 'anyData2',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "call_id": "aa172c6b-5595-27d3-b81e-60e7556c16bc",
        "prospeccion_url": "https:\/\/sugarcrm.casabaca.com\/#cbp_Prospeccion\/b9400c64-9a35-cf31-cf26-604bcac73032"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "datosSugarCRM.user_name_call_center": [
            "User-name inválido, call center no se encuentra registrado"
        ],
        "datosSugarCRM.client.tipo_identificacion": [
            "Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/call_quotation</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.user_name_call_center</code></td>
                <td>string</td>
                <td>required</td>
                <td>UserName del call center válido en SUGAR.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.date_start</code></td>
                <td>date</td>
                <td>required</td>
                <td>Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.duration_hours</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Indica la duración en horas de la llamada.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.duration_minutes</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Indica la duración en minutos de la llamada.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.direction</code></td>
                <td>string</td>
                <td>required</td>
                <td>Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.type</code></td>
                <td>string</td>
                <td>required</td>
                <td>Tipo de Cita, valores válidos: seguimiento, automatica</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.ticket_id</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID del Ticket de SUGAR al que hace referencia.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.comments</code></td>
                <td>string</td>
                <td>required</td>
                <td>Comentarios/descripción acerca del prospecto.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.modelo</code></td>
                <td>string</td>
                <td>required</td>
                <td>Modelo a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.medio</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Medio del Ticket</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.tipo_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Tipo de identificación del ciente a cotizar, valores válidos  C(Cedula),P(Pasaporte), R(RUC).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.numero_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Número de identificación del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.gender</code></td>
                <td>string</td>
                <td>required</td>
                <td>Género del cliente a cotizar. valores válidos: F (Femenino),M (Masculino)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.names</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombres del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.surnames</code></td>
                <td>string</td>
                <td>required</td>
                <td>Apellido del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.phone_home</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Telefono Local del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.cellphone_number</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Celular del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.client.email</code></td>
                <td>email</td>
                <td>required</td>
                <td>email del cliente a cotizar.</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.anyproperty1</code></td>
                <td>any</td>
                <td>optional</td>
                <td>Datos adicionales de la aplicación externa</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.anyproperty1N</code></td>
                <td>any</td>
                <td>optional</td>
                <td>Datos adicionales de la aplicación externa</td>
            </tr>
            </tbody>
        </table>
        <!-- END_1ca6da367f10e1fec3fa291a8eb234d2 -->
        <!-- START_57da0564914a4b1f3e5bf3bf9b953da1 -->
        <h2>Crear Llamada - Reagendamiento de cita</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/calls_prospeccion" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"user_name_asesor":"CG_RAMOS","user_name_call_center":"JA_AGUIRRE","date_start":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"10","status":"Held","direction":"Inbound","type":"cita","category":"2","notes":"Llamar lunes","prospeccion_id":"769cb57f-a32d-0ad0-3f0d-60c8e1d1658f","meeting":{"date":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"2","subject":"Prueba de Manejo","comments":"El cliente se acerca a la agencia...","location":"Agencia los Chillos","type":"1","visit_type":"1","linea_negocio":"1","marca":"1","modelo":"2","client":{"tipo_identificacion":"C","numero_identificacion":"1719932079","gender":"M","names":"Freddy Roberto","surnames":"Vargas Rodriguez","phone_home":"022072845","cellphone_number":"0987512224","email":"mart2021@hotmail.com"}}},"datos_adicionales":{"anyproperty1":"anyData1","anyproperty1N":"anyData2"}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/calls_prospeccion"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "user_name_asesor": "CG_RAMOS",
        "user_name_call_center": "JA_AGUIRRE",
        "date_start": "2021-10-02 19:59",
        "duration_hours": "0",
        "duration_minutes": "10",
        "status": "Held",
        "direction": "Inbound",
        "type": "cita",
        "category": "2",
        "notes": "Llamar lunes",
        "prospeccion_id": "769cb57f-a32d-0ad0-3f0d-60c8e1d1658f",
        "meeting": {
            "date": "2021-10-02 19:59",
            "duration_hours": "0",
            "duration_minutes": "2",
            "subject": "Prueba de Manejo",
            "comments": "El cliente se acerca a la agencia...",
            "location": "Agencia los Chillos",
            "type": "1",
            "visit_type": "1",
            "linea_negocio": "1",
            "marca": "1",
            "modelo": "2",
            "client": {
                "tipo_identificacion": "C",
                "numero_identificacion": "1719932079",
                "gender": "M",
                "names": "Freddy Roberto",
                "surnames": "Vargas Rodriguez",
                "phone_home": "022072845",
                "cellphone_number": "0987512224",
                "email": "mart2021@hotmail.com"
            }
        }
    },
    "datos_adicionales": {
        "anyproperty1": "anyData1",
        "anyproperty1N": "anyData2"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/calls_prospeccion',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'user_name_asesor' =&gt; 'CG_RAMOS',
                'user_name_call_center' =&gt; 'JA_AGUIRRE',
                'date_start' =&gt; '2021-10-02 19:59',
                'duration_hours' =&gt; '0',
                'duration_minutes' =&gt; '10',
                'status' =&gt; 'Held',
                'direction' =&gt; 'Inbound',
                'type' =&gt; 'cita',
                'category' =&gt; '2',
                'notes' =&gt; 'Llamar lunes',
                'prospeccion_id' =&gt; '769cb57f-a32d-0ad0-3f0d-60c8e1d1658f',
                'meeting' =&gt; [
                    'date' =&gt; '2021-10-02 19:59',
                    'duration_hours' =&gt; '0',
                    'duration_minutes' =&gt; '2',
                    'subject' =&gt; 'Prueba de Manejo',
                    'comments' =&gt; 'El cliente se acerca a la agencia...',
                    'location' =&gt; 'Agencia los Chillos',
                    'type' =&gt; '1',
                    'visit_type' =&gt; '1',
                    'linea_negocio' =&gt; '1',
                    'marca' =&gt; '1',
                    'modelo' =&gt; '2',
                    'client' =&gt; [
                        'tipo_identificacion' =&gt; 'C',
                        'numero_identificacion' =&gt; '1719932079',
                        'gender' =&gt; 'M',
                        'names' =&gt; 'Freddy Roberto',
                        'surnames' =&gt; 'Vargas Rodriguez',
                        'phone_home' =&gt; '022072845',
                        'cellphone_number' =&gt; '0987512224',
                        'email' =&gt; 'mart2021@hotmail.com',
                    ],
                ],
            ],
            'datos_adicionales' =&gt; [
                'anyproperty1' =&gt; 'anyData1',
                'anyproperty1N' =&gt; 'anyData2',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "call_id": "3d5a6040-cf8d-116a-85c0-60515e1f2ff2",
        "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "meeting_id": "3b970e6d-46e8-3455-1250-6054d939216c"
    }
}</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "call_id": "3d5a6040-cf8d-116a-85c0-60515e1f2ff2",
        "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "meeting_id": "N\/A"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "datosSugarCRM.user_name_asesor": [
            "User_name del asesor es requerido"
        ],
        "datosSugarCRM.date_start": [
            "La fecha de inicio debe ser una fecha"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "error": "La prospeccion seleccionada ya tiene una reunión planificada"
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/calls_prospeccion</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.user_name_asesor</code></td>
                <td>string</td>
                <td>optional</td>
                <td>UserName del asesor en SUGAR es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.user_name_call_center</code></td>
                <td>string</td>
                <td>required</td>
                <td>UserName del call center válido en SUGAR.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.date_start</code></td>
                <td>date</td>
                <td>required</td>
                <td>Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.duration_hours</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Indica la duración en horas de la llamada.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.duration_minutes</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Indica la duración en minutos de la llamada.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.status</code></td>
                <td>string</td>
                <td>required</td>
                <td>Valores válidos: Held (Realizada)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.direction</code></td>
                <td>string</td>
                <td>required</td>
                <td>Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.type</code></td>
                <td>string</td>
                <td>required</td>
                <td>Tipo de Cita, valores válidos: seguimiento, cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.category</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Categoria, valores válidos: 1 (Preventa), 2(PostVenta), 3(Prospección).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.notes</code></td>
                <td>string</td>
                <td>required</td>
                <td>Notas relacionada a la llamada realizada.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.prospeccion_id</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID del Prospecto de SUGAR al que hace referencia.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.date</code></td>
                <td>string</td>
                <td>required</td>
                <td>Fecha de la cita si la llamada es tipo cita, Zona Horaria - UTC, Formato:Y-m-d H:i.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.duration_hours</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Duracion horas requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.duration_minutes</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Duración de minutos requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.subject</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Asunto es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.comments</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Comentarios es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.location</code></td>
                <td>string</td>
                <td>required</td>
                <td>Ubicación de la cita es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.type</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Tipo de cita es requerido si la llamada es tipo cita, valores válidos  1 (Cita Física / Normal),2 (Virtual).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.visit_type</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Tipo de visita es requerido si la llamada es tipo cita, valores válidos  1 (Primera Visita),2 (Be-back), 3(Visita Anterior).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.linea_negocio</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Linea de negocio es requerido si la llamada es tipo cita, valores válidos  1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.marca</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Marca del vehículo - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.modelo</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Modelo del vehículo - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.tipo_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Tipo de identificación del ciente es requerido si la llamada es tipo cita, valores válidos  C(Cedula),P(Pasaporte), R(RUC).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.numero_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Número de identificación del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.gender</code></td>
                <td>string</td>
                <td>required</td>
                <td>Género del cliente es requerido si la llamada es tipo cita. valores válidos: F (Femenino),M (Masculino)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.names</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombres del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.surnames</code></td>
                <td>string</td>
                <td>required</td>
                <td>Apellido del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.phone_home</code></td>
                <td>numeric</td>
                <td>optional</td>
                <td>Telefono Local del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.cellphone_number</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Celular del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.email</code></td>
                <td>email</td>
                <td>required</td>
                <td>email del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.anyproperty1</code></td>
                <td>any</td>
                <td>optional</td>
                <td>Datos adicionales de la aplicación externa</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.anyproperty1N</code></td>
                <td>any</td>
                <td>optional</td>
                <td>Datos adicionales de la aplicación externa</td>
            </tr>
            </tbody>
        </table>
        <!-- END_57da0564914a4b1f3e5bf3bf9b953da1 -->
        <!-- START_ee43d68a55417a9e9a7535ff8dcb5232 -->
        <h2>Cerrar Prospección</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/close_prospeccion/7c093743-5b5d-01ec-f0b4-604a99b319d3" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"motivo_cierre":"1"}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/close_prospeccion/7c093743-5b5d-01ec-f0b4-604a99b319d3"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "motivo_cierre": "1"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/close_prospeccion/7c093743-5b5d-01ec-f0b4-604a99b319d3',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'motivo_cierre' =&gt; '1',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "prospeccion_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "prospeccion_name": "PROSPECTO-73097"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "datosSugarCRM.motivo_cierre": [
            "Motivo de cierre es requerido"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (404):</p>
        </blockquote>
        <pre><code class="language-json">{
    "error": "Prospección no existe, id inválido"
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/close_prospeccion/{id}</code></p>
        <h4>URL Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>id</code></td>
                <td>required</td>
                <td>Id de la prospección creada anteriormente en SUGAR</td>
            </tr>
            </tbody>
        </table>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.motivo_cierre</code></td>
                <td>string</td>
                <td>required</td>
                <td>Motivo para cerrar un ticket - Valores válidos: 1(No aplica a financiamiento), 2(Sólo Información), 3(No Contactado), 4(Desiste), 5(Compra Futura)</td>
            </tr>
            </tbody>
        </table>
        <!-- END_ee43d68a55417a9e9a7535ff8dcb5232 -->
        <!-- START_c9b0c7528d8e45b356488364e69b6ea1 -->
        <h2>Prospección - APP Talleres</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/forms_prospeccion" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"numero_identificacion":"1719932079","tipo_identificacion":"C","nombres":"Marta Patricia","apellidos":"Andrade Torres","email":"mart@hotmail.com","celular":"0987519882","agencia":"20","fuente":"17","modelo":"NEW HILUX 2.7 CD 4X2","comentarios":"Comentario Test","tienetoyota":"1","interesadorenovacion":"1","horaentregainmediata":"2021-08-31 14:00:00","asesorcorreo":"asesor@casabaca.com","asesornombre":"Pepito Martinez"}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/forms_prospeccion"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "numero_identificacion": "1719932079",
        "tipo_identificacion": "C",
        "nombres": "Marta Patricia",
        "apellidos": "Andrade Torres",
        "email": "mart@hotmail.com",
        "celular": "0987519882",
        "agencia": "20",
        "fuente": "17",
        "modelo": "NEW HILUX 2.7 CD 4X2",
        "comentarios": "Comentario Test",
        "tienetoyota": "1",
        "interesadorenovacion": "1",
        "horaentregainmediata": "2021-08-31 14:00:00",
        "asesorcorreo": "asesor@casabaca.com",
        "asesornombre": "Pepito Martinez"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/forms_prospeccion',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'numero_identificacion' =&gt; '1719932079',
                'tipo_identificacion' =&gt; 'C',
                'nombres' =&gt; 'Marta Patricia',
                'apellidos' =&gt; 'Andrade Torres',
                'email' =&gt; 'mart@hotmail.com',
                'celular' =&gt; '0987519882',
                'agencia' =&gt; '20',
                'fuente' =&gt; '17',
                'modelo' =&gt; 'NEW HILUX 2.7 CD 4X2',
                'comentarios' =&gt; 'Comentario Test',
                'tienetoyota' =&gt; '1',
                'interesadorenovacion' =&gt; '1',
                'horaentregainmediata' =&gt; '2021-08-31 14:00:00',
                'asesorcorreo' =&gt; 'asesor@casabaca.com',
                'asesornombre' =&gt; 'Pepito Martinez',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "prospeccion_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_url": "https:\/\/sugarcrm.casabaca.com\/#cbp_Prospeccion\/e06279dc-5629-5b20-6ebf-61081a41553a"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "numero_identificacion": [
            "Identificación es requerida"
        ],
        "nombres": [
            "Nombres son requeridos"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/forms_prospeccion</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.numero_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID del client.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.tipo_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Valores válidos: C(Cedula),P(Pasaporte), R(RUC)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.nombres</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombres del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.apellidos</code></td>
                <td>string</td>
                <td>required</td>
                <td>Apellidos del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.email</code></td>
                <td>email</td>
                <td>required</td>
                <td>Email válido del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.celular</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Celular del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.agencia</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>ID S3S de la Agencia</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.fuente</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Fuente Permitida 17(APP Talleres)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.modelo</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Nombre del Modelo</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.comentarios</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Comentario test</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.tienetoyota</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Tiene Toyota? 1(SI), 0(NO)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.interesadorenovacion</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>1(SI), 0(NO)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.horaentregainmediata</code></td>
                <td>dateTime</td>
                <td>optional</td>
                <td>Fecha y Hora de entrega Formato Y-m-d hh:mm:ss</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.asesorcorreo</code></td>
                <td>mail</td>
                <td>optional</td>
                <td>Correo del asesor</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.asesornombre</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Nombre del asesor</td>
            </tr>
            </tbody>
        </table>
        <!-- END_c9b0c7528d8e45b356488364e69b6ea1 -->
        <h1>Prospección - Citas</h1>
        <p>Api para crear Llamada - Cita - Prospección</p>
        <!-- START_4ab385e6babe171ebd61d88e554311bf -->
        <h2>Crear Llamada - Cita - Prospección</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/calls" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"user_name_asesor":"CG_RAMOS","user_name_call_center":"CG_RAMOS","date_start":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"10","status":"Held","direction":"Inbound","type":"cita","category":"2","medio":"10","campania":"5e686580-ee19-11ea-97ea-000c297d72b1","notes":"Llamar lunes","ticket":{"id":"10438baf-0d83-9533-4fb3-602ea326288b","is_closed":true,"motivo_cierre":"solo_informacion"},"meeting":{"status":"Held","date":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"2","subject":"Prueba de Manejo","comments":"El cliente se acerca a la agencia...","location":"Agencia los Chillos","type":"1","visit_type":"1","linea_negocio":"1","marca":"1","modelo":"2","client":{"tipo_identificacion":"C","numero_identificacion":"1719932079","gender":"M","names":"Freddy Roberto","surnames":"Vargas Rodriguez","phone_home":"022072845","cellphone_number":"0987512224","email":"mart2021@hotmail.com"}}},"datos_adicionales":{"anyproperty1":"anyData1","anyproperty1N":"anyData2"}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/calls"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "user_name_asesor": "CG_RAMOS",
        "user_name_call_center": "CG_RAMOS",
        "date_start": "2021-10-02 19:59",
        "duration_hours": "0",
        "duration_minutes": "10",
        "status": "Held",
        "direction": "Inbound",
        "type": "cita",
        "category": "2",
        "medio": "10",
        "campania": "5e686580-ee19-11ea-97ea-000c297d72b1",
        "notes": "Llamar lunes",
        "ticket": {
            "id": "10438baf-0d83-9533-4fb3-602ea326288b",
            "is_closed": true,
            "motivo_cierre": "solo_informacion"
        },
        "meeting": {
            "status": "Held",
            "date": "2021-10-02 19:59",
            "duration_hours": "0",
            "duration_minutes": "2",
            "subject": "Prueba de Manejo",
            "comments": "El cliente se acerca a la agencia...",
            "location": "Agencia los Chillos",
            "type": "1",
            "visit_type": "1",
            "linea_negocio": "1",
            "marca": "1",
            "modelo": "2",
            "client": {
                "tipo_identificacion": "C",
                "numero_identificacion": "1719932079",
                "gender": "M",
                "names": "Freddy Roberto",
                "surnames": "Vargas Rodriguez",
                "phone_home": "022072845",
                "cellphone_number": "0987512224",
                "email": "mart2021@hotmail.com"
            }
        }
    },
    "datos_adicionales": {
        "anyproperty1": "anyData1",
        "anyproperty1N": "anyData2"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/calls',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'user_name_asesor' =&gt; 'CG_RAMOS',
                'user_name_call_center' =&gt; 'CG_RAMOS',
                'date_start' =&gt; '2021-10-02 19:59',
                'duration_hours' =&gt; '0',
                'duration_minutes' =&gt; '10',
                'status' =&gt; 'Held',
                'direction' =&gt; 'Inbound',
                'type' =&gt; 'cita',
                'category' =&gt; '2',
                'medio' =&gt; '10',
                'campania' =&gt; '5e686580-ee19-11ea-97ea-000c297d72b1',
                'notes' =&gt; 'Llamar lunes',
                'ticket' =&gt; [
                    'id' =&gt; '10438baf-0d83-9533-4fb3-602ea326288b',
                    'is_closed' =&gt; true,
                    'motivo_cierre' =&gt; 'solo_informacion',
                ],
                'meeting' =&gt; [
                    'status' =&gt; 'Held',
                    'date' =&gt; '2021-10-02 19:59',
                    'duration_hours' =&gt; '0',
                    'duration_minutes' =&gt; '2',
                    'subject' =&gt; 'Prueba de Manejo',
                    'comments' =&gt; 'El cliente se acerca a la agencia...',
                    'location' =&gt; 'Agencia los Chillos',
                    'type' =&gt; '1',
                    'visit_type' =&gt; '1',
                    'linea_negocio' =&gt; '1',
                    'marca' =&gt; '1',
                    'modelo' =&gt; '2',
                    'client' =&gt; [
                        'tipo_identificacion' =&gt; 'C',
                        'numero_identificacion' =&gt; '1719932079',
                        'gender' =&gt; 'M',
                        'names' =&gt; 'Freddy Roberto',
                        'surnames' =&gt; 'Vargas Rodriguez',
                        'phone_home' =&gt; '022072845',
                        'cellphone_number' =&gt; '0987512224',
                        'email' =&gt; 'mart2021@hotmail.com',
                    ],
                ],
            ],
            'datos_adicionales' =&gt; [
                'anyproperty1' =&gt; 'anyData1',
                'anyproperty1N' =&gt; 'anyData2',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "call_id": "3d5a6040-cf8d-116a-85c0-60515e1f2ff2",
        "ticket_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "meeting_id": "3b970e6d-46e8-3455-1250-6054d939216c"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "datosSugarCRM.user_name_asesor": [
            "User_name del asesor es requerido"
        ],
        "datosSugarCRM.date_start": [
            "La fecha de inicio debe ser una fecha"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/calls</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.user_name_asesor</code></td>
                <td>string</td>
                <td>optional</td>
                <td>UserName del asesor en SUGAR es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.user_name_call_center</code></td>
                <td>string</td>
                <td>required</td>
                <td>UserName del call center válido en SUGAR.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.date_start</code></td>
                <td>date</td>
                <td>required</td>
                <td>Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.duration_hours</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Indica la duración en horas de la llamada.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.duration_minutes</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Indica la duración en minutos de la llamada.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.status</code></td>
                <td>string</td>
                <td>required</td>
                <td>Valores válidos: Held (Realizada)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.direction</code></td>
                <td>string</td>
                <td>required</td>
                <td>Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.type</code></td>
                <td>string</td>
                <td>required</td>
                <td>Tipo de Cita, valores válidos: seguimiento, cita, cita_chat.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.category</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Categoria, valores válidos: 1 (Preventa), 2(PostVenta), 3(Prospección).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.medio</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Medio de la llamada</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.campania</code></td>
                <td>id</td>
                <td>optional</td>
                <td>Campaña de la llamada</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.notes</code></td>
                <td>string</td>
                <td>required</td>
                <td>Notas relacionada a la llamada realizada.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.ticket.id</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID del Ticket de SUGAR al que hace referencia.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.ticket.is_closed</code></td>
                <td>boolean</td>
                <td>required</td>
                <td>Si desea cerrar el ticket asociado debe ir true.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.ticket.motivo_cierre</code></td>
                <td>string</td>
                <td>required</td>
                <td>Motivo para cerrar un ticket - Valores válidos: abandono_chat,solo_informacion,desiste,no_contesta,compra_futura</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.status</code></td>
                <td>string</td>
                <td>required</td>
                <td>Estado es requerido si la llamada es tipo cita, valores válidos: Planned (Planificada), Held (Realizada)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.date</code></td>
                <td>string</td>
                <td>required</td>
                <td>Fecha de la cita si la llamada es tipo cita, Zona Horaria - UTC, Formato:Y-m-d H:i.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.duration_hours</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Duracion horas requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.duration_minutes</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Duración de minutos requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.subject</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Asunto es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.comments</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Comentarios es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.location</code></td>
                <td>string</td>
                <td>required</td>
                <td>Ubicación de la cita es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.type</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Tipo de cita es requerido si la llamada es tipo cita, valores válidos  1 (Cita Física / Normal),2 (Virtual).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.visit_type</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Tipo de visita es requerido si la llamada es tipo cita, valores válidos  1 (Primera Visita),2 (Be-back), 3(Visita Anterior).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.linea_negocio</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Linea de negocio es requerido si la llamada es tipo cita, valores válidos  1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.marca</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Marca del vehículo - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.modelo</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Modelo del vehículo - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.tipo_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Tipo de identificación del ciente es requerido si la llamada es tipo cita, valores válidos  C(Cedula),P(Pasaporte), R(RUC).</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.numero_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Número de identificación del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.gender</code></td>
                <td>string</td>
                <td>required</td>
                <td>Género del cliente es requerido si la llamada es tipo cita. valores válidos: F (Femenino),M (Masculino)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.names</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombres del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.surnames</code></td>
                <td>string</td>
                <td>required</td>
                <td>Apellido del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.phone_home</code></td>
                <td>numeric</td>
                <td>optional</td>
                <td>Telefono Local del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.cellphone_number</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Celular del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.meeting.client.email</code></td>
                <td>email</td>
                <td>required</td>
                <td>email del cliente es requerido si la llamada es tipo cita.</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.anyproperty1</code></td>
                <td>any</td>
                <td>optional</td>
                <td>Datos adicionales de la aplicación externa</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.anyproperty1N</code></td>
                <td>any</td>
                <td>optional</td>
                <td>Datos adicionales de la aplicación externa</td>
            </tr>
            </tbody>
        </table>
        <!-- END_4ab385e6babe171ebd61d88e554311bf -->
        <h1>Tickets</h1>
        <p>APIs para crear, actualizar tickets y crear interacciones</p>
        <!-- START_c116c2f5639c323eb7e0108ce3b62ce1 -->
        <h2>Ticket - Interacción</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/tickets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"numero_identificacion":"1719932079","tipo_identificacion":"C","email":"mart@hotmail.com","user_name":"CG_RAMOS","nombres":"FREDDY ROBERTO","apellidos":"RODRIGUEZ VARGAS","celular":"0987519882","telefono":"022072827","linea_negocio":"1","tipo_transaccion":"1","anio":"2020","placa":"PCY-7933","medio":"13","campania":"5e686580-ee19-11ea-97ea-000c297d72b1","asunto":"Mantenimiento","comentario_cliente":"Necesita una cita para mantenimiento","id_interaccion_inconcert":"id_inconcert","description":"El cliente requiere una cotizacion urgente","porcentaje_discapacidad":"50_74","marca":"1","modelo":"2","precio":"25000","color":"negro","anioMin":"2018","anioMax":"2020","kilometraje":"25000","combustible":"gasolina"},"datos_adicionales":{"title":"Titulo del Formulario","pageUrl":"https:\/\/www.toyota.com.ec\/formulariox.html","thankyouPageUrl":"https:\/\/www.toyota.com.ec\/graciasFormularioX.html","fields":[{"key":"Nombres","nombre":"Maria"},{"key":"Apellidos","nombre":"Rodriguez"},{"key":"Cedula","nombre":"171999999"}]}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/tickets"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "numero_identificacion": "1719932079",
        "tipo_identificacion": "C",
        "email": "mart@hotmail.com",
        "user_name": "CG_RAMOS",
        "nombres": "FREDDY ROBERTO",
        "apellidos": "RODRIGUEZ VARGAS",
        "celular": "0987519882",
        "telefono": "022072827",
        "linea_negocio": "1",
        "tipo_transaccion": "1",
        "anio": "2020",
        "placa": "PCY-7933",
        "medio": "13",
        "campania": "5e686580-ee19-11ea-97ea-000c297d72b1",
        "asunto": "Mantenimiento",
        "comentario_cliente": "Necesita una cita para mantenimiento",
        "id_interaccion_inconcert": "id_inconcert",
        "description": "El cliente requiere una cotizacion urgente",
        "porcentaje_discapacidad": "50_74",
        "marca": "1",
        "modelo": "2",
        "precio": "25000",
        "color": "negro",
        "anioMin": "2018",
        "anioMax": "2020",
        "kilometraje": "25000",
        "combustible": "gasolina"
    },
    "datos_adicionales": {
        "title": "Titulo del Formulario",
        "pageUrl": "https:\/\/www.toyota.com.ec\/formulariox.html",
        "thankyouPageUrl": "https:\/\/www.toyota.com.ec\/graciasFormularioX.html",
        "fields": [
            {
                "key": "Nombres",
                "nombre": "Maria"
            },
            {
                "key": "Apellidos",
                "nombre": "Rodriguez"
            },
            {
                "key": "Cedula",
                "nombre": "171999999"
            }
        ]
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/tickets',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'numero_identificacion' =&gt; '1719932079',
                'tipo_identificacion' =&gt; 'C',
                'email' =&gt; 'mart@hotmail.com',
                'user_name' =&gt; 'CG_RAMOS',
                'nombres' =&gt; 'FREDDY ROBERTO',
                'apellidos' =&gt; 'RODRIGUEZ VARGAS',
                'celular' =&gt; '0987519882',
                'telefono' =&gt; '022072827',
                'linea_negocio' =&gt; '1',
                'tipo_transaccion' =&gt; '1',
                'anio' =&gt; '2020',
                'placa' =&gt; 'PCY-7933',
                'medio' =&gt; '13',
                'campania' =&gt; '5e686580-ee19-11ea-97ea-000c297d72b1',
                'asunto' =&gt; 'Mantenimiento',
                'comentario_cliente' =&gt; 'Necesita una cita para mantenimiento',
                'id_interaccion_inconcert' =&gt; 'id_inconcert',
                'description' =&gt; 'El cliente requiere una cotizacion urgente',
                'porcentaje_discapacidad' =&gt; '50_74',
                'marca' =&gt; '1',
                'modelo' =&gt; '2',
                'precio' =&gt; '25000',
                'color' =&gt; 'negro',
                'anioMin' =&gt; '2018',
                'anioMax' =&gt; '2020',
                'kilometraje' =&gt; '25000',
                'combustible' =&gt; 'gasolina',
            ],
            'datos_adicionales' =&gt; [
                'title' =&gt; 'Titulo del Formulario',
                'pageUrl' =&gt; 'https://www.toyota.com.ec/formulariox.html',
                'thankyouPageUrl' =&gt; 'https://www.toyota.com.ec/graciasFormularioX.html',
                'fields' =&gt; [
                    [
                        'key' =&gt; 'Nombres',
                        'nombre' =&gt; 'Maria',
                    ],
                    [
                        'key' =&gt; 'Apellidos',
                        'nombre' =&gt; 'Rodriguez',
                    ],
                    [
                        'key' =&gt; 'Cedula',
                        'nombre' =&gt; '171999999',
                    ],
                ],
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_name": "TCK-463587",
        "interaction_id": "1042eae5-0c94-1f7f-ef16-602e98cbd391"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "numero_identificacion": [
            "Identificación es requerida"
        ],
        "nombres": [
            "Nombres son requeridos"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (404):</p>
        </blockquote>
        <pre><code class="language-json">{
    "error": "User-name inválido, asesor  no se encuentra registrado"
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/tickets</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.numero_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID del client.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.tipo_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Valores válidos: C(Cedula),P(Pasaporte), R(RUC)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.email</code></td>
                <td>email</td>
                <td>required</td>
                <td>Email válido del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.user_name</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Es requerido si la fuente es inConcert. UserName válido del asesor en SUGAR.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.nombres</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombres del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.apellidos</code></td>
                <td>string</td>
                <td>required</td>
                <td>Apellidos del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.celular</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Celular del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.telefono</code></td>
                <td>numeric</td>
                <td>optional</td>
                <td>Telefono local del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.linea_negocio</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Valores válidos: 1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.tipo_transaccion</code></td>
                <td>numeric</td>
                <td>optional</td>
                <td>Valores válidos: 1 (Ventas),2 (Tomas),3 (Quejas),4 (Info General)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.anio</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Año del vehículo</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.placa</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Placa del vehículo</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.medio</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Medio del Ticket</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.campania</code></td>
                <td>numeric</td>
                <td>optional</td>
                <td>Id de la Campaña del Formulario</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.asunto</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Asunto requerido si existe comentario del cliente</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.comentario_cliente</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Comentario del cliente</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.id_interaccion_inconcert</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID definido en el sistema externo</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.description</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Comentario Asesor</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.porcentaje_discapacidad</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Porcentaje de discapacidad del cliente, , valores válidos: 30_49 (Del 30% al 49%),50_74 (Del 50% al 74%),75_84 (Del 75% al 84%),85_100(Del 85% al 100%)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.marca</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Marca del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.modelo</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Modelo del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.precio</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Precio del vehículo (Requerido para CarMatch)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.color</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Color del vehículo (Requerido para CarMatch)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.anioMin</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Año Mínimo  del vehículo (Requerido para CarMatch)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.anioMax</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Año Máximo del vehículo (Requerido para CarMatch)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.kilometraje</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Kilometraje del vehículo (Requerido para CarMatch)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.combustible</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Combustible del vehículo Valores válidos: gasolina,diesel (Requerido para CarMatch)</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.title</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Nombre del formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.pageUrl</code></td>
                <td>string</td>
                <td>optional</td>
                <td>URL del formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.thankyouPageUrl</code></td>
                <td>string</td>
                <td>optional</td>
                <td>URL de la página de agradecimiento</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields</code></td>
                <td>array</td>
                <td>optional</td>
                <td>Arreglo con los campos del formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.0.key</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Nombre del campo 1 del formulario  formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.0.nombre</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Data del campo 1 del formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.1.key</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Nombre del campo 2 del formulario  formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.1.nombre</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Data del campo 2 del formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.2.key</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Nombre del campo n del formulario  formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.2.nombre</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Data del campo n del formulario</td>
            </tr>
            </tbody>
        </table>
        <!-- END_c116c2f5639c323eb7e0108ce3b62ce1 -->
        <!-- START_c199d38571334fe663cb31edce93371f -->
        <h2>Ticket - Llamadas entrantes y salientes</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/call_ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"numero_identificacion":"1719932079","tipo_identificacion":"C","email":"mart@hotmail.com","user_name":"CG_RAMOS","nombres":"FREDDY ROBERTO","apellidos":"RODRIGUEZ VARGAS","celular":"0987519882","telefono":"022072827","linea_negocio":"1","tipo_transaccion":"1","medio":"13","campania":"5e686580-ee19-11ea-97ea-000c297d72b1","id_interaccion_inconcert":"id_inconcert","marca":"1","modelo":"2","comentario_cliente":"Necesita una cita para mantenimiento","description":"El cliente requiere una cotizacion urgente","porcentaje_discapacidad":"50_74"},"datos_adicionales":{"fields":[{"key":"Estado Civil","nombre":"Soltero"},{"key":"Fecha de Nacimiento","nombre":"10 Diciembre de 1970"}]}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/call_ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "numero_identificacion": "1719932079",
        "tipo_identificacion": "C",
        "email": "mart@hotmail.com",
        "user_name": "CG_RAMOS",
        "nombres": "FREDDY ROBERTO",
        "apellidos": "RODRIGUEZ VARGAS",
        "celular": "0987519882",
        "telefono": "022072827",
        "linea_negocio": "1",
        "tipo_transaccion": "1",
        "medio": "13",
        "campania": "5e686580-ee19-11ea-97ea-000c297d72b1",
        "id_interaccion_inconcert": "id_inconcert",
        "marca": "1",
        "modelo": "2",
        "comentario_cliente": "Necesita una cita para mantenimiento",
        "description": "El cliente requiere una cotizacion urgente",
        "porcentaje_discapacidad": "50_74"
    },
    "datos_adicionales": {
        "fields": [
            {
                "key": "Estado Civil",
                "nombre": "Soltero"
            },
            {
                "key": "Fecha de Nacimiento",
                "nombre": "10 Diciembre de 1970"
            }
        ]
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/call_ticket',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'numero_identificacion' =&gt; '1719932079',
                'tipo_identificacion' =&gt; 'C',
                'email' =&gt; 'mart@hotmail.com',
                'user_name' =&gt; 'CG_RAMOS',
                'nombres' =&gt; 'FREDDY ROBERTO',
                'apellidos' =&gt; 'RODRIGUEZ VARGAS',
                'celular' =&gt; '0987519882',
                'telefono' =&gt; '022072827',
                'linea_negocio' =&gt; '1',
                'tipo_transaccion' =&gt; '1',
                'medio' =&gt; '13',
                'campania' =&gt; '5e686580-ee19-11ea-97ea-000c297d72b1',
                'id_interaccion_inconcert' =&gt; 'id_inconcert',
                'marca' =&gt; '1',
                'modelo' =&gt; '2',
                'comentario_cliente' =&gt; 'Necesita una cita para mantenimiento',
                'description' =&gt; 'El cliente requiere una cotizacion urgente',
                'porcentaje_discapacidad' =&gt; '50_74',
            ],
            'datos_adicionales' =&gt; [
                'fields' =&gt; [
                    [
                        'key' =&gt; 'Estado Civil',
                        'nombre' =&gt; 'Soltero',
                    ],
                    [
                        'key' =&gt; 'Fecha de Nacimiento',
                        'nombre' =&gt; '10 Diciembre de 1970',
                    ],
                ],
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_name": "TCK-463587",
        "ticket_url": "https:\/\/sugarcrm.casabaca.com\/#cbt_Tickets\/d4417c68-87a1-2572-9443-60e5cf52d1ef"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "numero_identificacion": [
            "Identificación es requerida"
        ],
        "nombres": [
            "Nombres son requeridos"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (404):</p>
        </blockquote>
        <pre><code class="language-json">{
    "error": "User-name inválido, asesor  no se encuentra registrado"
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/call_ticket</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.numero_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID del client.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.tipo_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Valores válidos: C(Cedula),P(Pasaporte), R(RUC)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.email</code></td>
                <td>email</td>
                <td>required</td>
                <td>Email válido del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.user_name</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Es requerido si la fuente es inConcert. UserName válido del asesor en SUGAR.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.nombres</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombres del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.apellidos</code></td>
                <td>string</td>
                <td>required</td>
                <td>Apellidos del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.celular</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Celular del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.telefono</code></td>
                <td>numeric</td>
                <td>optional</td>
                <td>Telefono local del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.linea_negocio</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Valores válidos: 1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.tipo_transaccion</code></td>
                <td>numeric</td>
                <td>optional</td>
                <td>Valores válidos: 1 (Ventas),2 (Tomas),3 (Quejas),4 (Info General)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.medio</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Medio del Ticket</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.campania</code></td>
                <td>numeric</td>
                <td>optional</td>
                <td>Id de la Campaña del Formulario</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.id_interaccion_inconcert</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID definido en el sistema externo</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.marca</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Marca del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.modelo</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Modelo del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.comentario_cliente</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Comentario del cliente</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.description</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Comentario Asesor</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.porcentaje_discapacidad</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Porcentaje de discapacidad del cliente, , valores válidos: 30_49 (Del 30% al 49%),50_74 (Del 50% al 74%),75_84 (Del 75% al 84%),85_100(Del 85% al 100%)</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields</code></td>
                <td>array</td>
                <td>optional</td>
                <td>Arreglo con los campos del formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.0.key</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Estado Civil del campo 1 del formulario  formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.0.nombre</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Data del campo 1 del formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.1.key</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Fecha de Nacimiento del campo 2 del formulario  formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.1.nombre</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Data del campo 2 del formulario</td>
            </tr>
            </tbody>
        </table>
        <!-- END_c199d38571334fe663cb31edce93371f -->
        <!-- START_15589e516beeb193362ba03d6d3905b3 -->
        <h2>Ticket - Landing Pages</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/landing_ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"formulario":"Exonerados","numero_identificacion":"1719932079","tipo_identificacion":"C","nombres":"FREDDY ROBERTO","apellidos":"RODRIGUEZ VARGAS","email":"mart@hotmail.com","celular":"0987519882","concesionario":"Santo Domingo (Casabaca)"}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/landing_ticket"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "formulario": "Exonerados",
        "numero_identificacion": "1719932079",
        "tipo_identificacion": "C",
        "nombres": "FREDDY ROBERTO",
        "apellidos": "RODRIGUEZ VARGAS",
        "email": "mart@hotmail.com",
        "celular": "0987519882",
        "concesionario": "Santo Domingo (Casabaca)"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/landing_ticket',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'formulario' =&gt; 'Exonerados',
                'numero_identificacion' =&gt; '1719932079',
                'tipo_identificacion' =&gt; 'C',
                'nombres' =&gt; 'FREDDY ROBERTO',
                'apellidos' =&gt; 'RODRIGUEZ VARGAS',
                'email' =&gt; 'mart@hotmail.com',
                'celular' =&gt; '0987519882',
                'concesionario' =&gt; 'Santo Domingo (Casabaca)',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_name": "TCK-463587",
        "interaction_id": "1042eae5-0c94-1f7f-ef16-602e98cbd391",
        "ticket_url": "https:\/\/sugarcrm.casabaca.com\/#cbt_Tickets\/e06279dc-5629-5b20-6ebf-61081a41553a"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "numero_identificacion": [
            "Identificación es requerida"
        ],
        "nombres": [
            "Nombres son requeridos"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/landing_ticket</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.formulario</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombre del Formulario</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.numero_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID del client.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.tipo_identificacion</code></td>
                <td>string</td>
                <td>required</td>
                <td>Valores válidos: C(Cedula),P(Pasaporte), R(RUC)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.nombres</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombres del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.apellidos</code></td>
                <td>string</td>
                <td>required</td>
                <td>Apellidos del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.email</code></td>
                <td>email</td>
                <td>required</td>
                <td>Email válido del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.celular</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Celular del cliente.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.concesionario</code></td>
                <td>string</td>
                <td>required</td>
                <td>Nombre de la Agencia-Concesionario</td>
            </tr>
            </tbody>
        </table>
        <!-- END_15589e516beeb193362ba03d6d3905b3 -->
        <!-- START_1af19642c94c90ceb55d8a80bdb33cd6 -->
        <h2>Ticket Interacción No Contesta</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/not_answer_ticket/d9bf5143-daa6-d9ca-7d04-60df4f47f51a" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/not_answer_ticket/d9bf5143-daa6-d9ca-7d04-60df4f47f51a"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/not_answer_ticket/d9bf5143-daa6-d9ca-7d04-60df4f47f51a',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "ticket_id": "d9bf5143-daa6-d9ca-7d04-60df4f47f51a",
        "ticket_name": "TCK-463587"
    }
}</code></pre>
        <blockquote>
            <p>Example response (404):</p>
        </blockquote>
        <pre><code class="language-json">{
    "error": "Ticket no existe, id inválido"
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/not_answer_ticket/{id}</code></p>
        <h4>URL Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>id</code></td>
                <td>required</td>
                <td>Id del ticket creado anteriormente en SUGAR</td>
            </tr>
            </tbody>
        </table>
        <!-- END_1af19642c94c90ceb55d8a80bdb33cd6 -->
        <!-- START_9107eaa3e6d79e1d1134dea43eb82113 -->
        <h2>Ticket - Llamada no contesta</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/not_answer_call" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"user_name_call_center":"CG_RAMOS","date_start":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"10","direction":"Inbound","ticket_id":"10438baf-0d83-9533-4fb3-602ea326288b"},"datos_adicionales":{"fields":[{"key":"Estado Civil","nombre":"Soltero"},{"key":"Fecha de Nacimiento","nombre":"10 Diciembre de 1970"}]}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/not_answer_call"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "user_name_call_center": "CG_RAMOS",
        "date_start": "2021-10-02 19:59",
        "duration_hours": "0",
        "duration_minutes": "10",
        "direction": "Inbound",
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b"
    },
    "datos_adicionales": {
        "fields": [
            {
                "key": "Estado Civil",
                "nombre": "Soltero"
            },
            {
                "key": "Fecha de Nacimiento",
                "nombre": "10 Diciembre de 1970"
            }
        ]
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/not_answer_call',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'user_name_call_center' =&gt; 'CG_RAMOS',
                'date_start' =&gt; '2021-10-02 19:59',
                'duration_hours' =&gt; '0',
                'duration_minutes' =&gt; '10',
                'direction' =&gt; 'Inbound',
                'ticket_id' =&gt; '10438baf-0d83-9533-4fb3-602ea326288b',
            ],
            'datos_adicionales' =&gt; [
                'fields' =&gt; [
                    [
                        'key' =&gt; 'Estado Civil',
                        'nombre' =&gt; 'Soltero',
                    ],
                    [
                        'key' =&gt; 'Fecha de Nacimiento',
                        'nombre' =&gt; '10 Diciembre de 1970',
                    ],
                ],
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "call_id": "1043801af-0d83-9533-4fb3-602ea313128b",
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "user_name_call_center": [
            "User_name del call center es requerida"
        ],
        "date_start": [
            "La fecha de inicio de llamada es requerida"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/not_answer_call</code></p>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.user_name_call_center</code></td>
                <td>string</td>
                <td>required</td>
                <td>UserName del call center válido en SUGAR.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.date_start</code></td>
                <td>date</td>
                <td>required</td>
                <td>Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.duration_hours</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Indica la duración en horas de la llamada.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.duration_minutes</code></td>
                <td>numeric</td>
                <td>required</td>
                <td>Indica la duración en minutos de la llamada.</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.direction</code></td>
                <td>string</td>
                <td>required</td>
                <td>Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente)</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.ticket_id</code></td>
                <td>string</td>
                <td>required</td>
                <td>ID del Ticket de SUGAR al que hace referencia.</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields</code></td>
                <td>array</td>
                <td>optional</td>
                <td>Arreglo con los campos del formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.0.key</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Estado Civil del campo 1 del formulario  formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.0.nombre</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Data del campo 1 del formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.1.key</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Fecha de Nacimiento del campo 2 del formulario  formulario</td>
            </tr>
            <tr>
                <td><code>datos_adicionales.fields.1.nombre</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Data del campo 2 del formulario</td>
            </tr>
            </tbody>
        </table>
        <!-- END_9107eaa3e6d79e1d1134dea43eb82113 -->
        <!-- START_206f087a1aa5a0ae2035b7f6960587d2 -->
        <h2>Cerrar Ticket</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/close_ticket/7c093743-5b5d-01ec-f0b4-604a99b319d3" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"motivo_cierre":"solo_informacion"}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/close_ticket/7c093743-5b5d-01ec-f0b4-604a99b319d3"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "motivo_cierre": "solo_informacion"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/close_ticket/7c093743-5b5d-01ec-f0b4-604a99b319d3',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'motivo_cierre' =&gt; 'solo_informacion',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_name": "TCK-463587"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "datosSugarCRM.motivo_cierre": [
            "Motivo de cierre es requerido"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (404):</p>
        </blockquote>
        <pre><code class="language-json">{
    "error": "Ticket no existe, id inválido"
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/close_ticket/{id}</code></p>
        <h4>URL Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>id</code></td>
                <td>required</td>
                <td>Id del ticket creado anteriormente en SUGAR</td>
            </tr>
            </tbody>
        </table>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.motivo_cierre</code></td>
                <td>string</td>
                <td>required</td>
                <td>Motivo para cerrar un ticket - Valores válidos: abandono_chat,solo_informacion,desiste,no_contesta,compra_futura</td>
            </tr>
            </tbody>
        </table>
        <!-- END_206f087a1aa5a0ae2035b7f6960587d2 -->
        <!-- START_995795dea562b0b100b5648b0a1afdeb -->
        <h2>Agregar Notas a un Ticket</h2>
        <blockquote>
            <p>Example request:</p>
        </blockquote>
        <pre><code class="language-bash">curl -X POST \
    "https://api-sugarcrm.casabaca.com/api/ticket/addNotes/3aa93559-44b6-9527-8803-6079d0401158" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"notes":"El cliente se encuentra interesado en un RAV4","interaction":"edc861f5-95ec-dc21-d6ff-608842e5f11c","prospeccion":"85fce850-bf1a-25ba-cbc3-60a547b5b9f3"}}'
</code></pre>
        <pre><code class="language-javascript">const url = new URL(
    "https://api-sugarcrm.casabaca.com/api/ticket/addNotes/3aa93559-44b6-9527-8803-6079d0401158"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "datosSugarCRM": {
        "notes": "El cliente se encuentra interesado en un RAV4",
        "interaction": "edc861f5-95ec-dc21-d6ff-608842e5f11c",
        "prospeccion": "85fce850-bf1a-25ba-cbc3-60a547b5b9f3"
    }
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
        <pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api-sugarcrm.casabaca.com/api/ticket/addNotes/3aa93559-44b6-9527-8803-6079d0401158',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Bearer {token}',
        ],
        'json' =&gt; [
            'datosSugarCRM' =&gt; [
                'notes' =&gt; 'El cliente se encuentra interesado en un RAV4',
                'interaction' =&gt; 'edc861f5-95ec-dc21-d6ff-608842e5f11c',
                'prospeccion' =&gt; '85fce850-bf1a-25ba-cbc3-60a547b5b9f3',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
        <blockquote>
            <p>Example response (200):</p>
        </blockquote>
        <pre><code class="language-json">{
    "data": {
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_name": "TCK-463587"
    }
}</code></pre>
        <blockquote>
            <p>Example response (422):</p>
        </blockquote>
        <pre><code class="language-json">{
    "errors": {
        "datosSugarCRM.notes": [
            "Notes es requerido"
        ]
    }
}</code></pre>
        <blockquote>
            <p>Example response (404):</p>
        </blockquote>
        <pre><code class="language-json">{
    "error": "Ticket no existe, id inválido"
}</code></pre>
        <blockquote>
            <p>Example response (500):</p>
        </blockquote>
        <pre><code class="language-json">{
    "message": "Unauthenticated.",
    "status_code": 500
}</code></pre>
        <h3>HTTP Request</h3>
        <p><code>POST api/ticket/addNotes/{id}</code></p>
        <h4>URL Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>id</code></td>
                <td>required</td>
                <td>Id del ticket creado anteriormente en SUGAR</td>
            </tr>
            </tbody>
        </table>
        <h4>Body Parameters</h4>
        <table>
            <thead>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><code>datosSugarCRM.notes</code></td>
                <td>string</td>
                <td>required</td>
                <td>Notas para agregar al ticket</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.interaction</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Id de la interaccion si existe</td>
            </tr>
            <tr>
                <td><code>datosSugarCRM.prospeccion</code></td>
                <td>string</td>
                <td>optional</td>
                <td>Id de la prospección generado si existió una cita</td>
            </tr>
            </tbody>
        </table>
        <!-- END_995795dea562b0b100b5648b0a1afdeb -->
    </div>
    <div class="dark-box">
        <div class="lang-selector">
            <a href="#" data-language-name="bash">bash</a>
            <a href="#" data-language-name="javascript">javascript</a>
            <a href="#" data-language-name="php">php</a>
        </div>
    </div>
</div>
</body>
</html>
