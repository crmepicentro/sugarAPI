---
title: API Reference

language_tabs:
- bash
- javascript
- php

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://api-sugarcrm.casabaca.com/docs/collection.json)

<!-- END_INFO -->

#Asesores


Api para Obtener asesores
<!-- START_00dbeb8940289d032b92cdc45e9b945e -->
## Obtiene los asesores comerciales disponibles de un medio requerido

> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/asesores" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"medio":"11"}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/asesores"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/asesores',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'medio' => '11',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
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
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`GET api/asesores`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `medio` | numeric |  required  | Medio requerido
    
<!-- END_00dbeb8940289d032b92cdc45e9b945e -->

#Autenticación


APIs para gestión de tokens
<!-- START_d7b7952e7fdddc07c978c9bdaf757acf -->
## Crear usuario

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"name":"Maria","email":"mart@hotmail.com","password":"Hol@MunD0","fuente":"inconcert","fuente_id":"2","medios":"2,3,5","compania":"1"}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/register"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/register',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'name' => 'Maria',
            'email' => 'mart@hotmail.com',
            'password' => 'Hol@MunD0',
            'fuente' => 'inconcert',
            'fuente_id' => '2',
            'medios' => '2,3,5',
            'compania' => '1',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "status_code": "200",
    "message": "Usuario Creado Correctamente"
}
```
> Example response (500):

```json
{
    "message": "Usuario Creado Correctamente"
}
```

### HTTP Request
`POST api/register`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | el nombre del usuario.
        `email` | email |  required  | email El email del usuario.
        `password` | string |  optional  | 
        `fuente` | tipo |  optional  | de fuente.
        `fuente_id` | Id |  optional  | de la fuente.
        `medios` | Medios |  optional  | de acceso.
        `compania` | Id |  optional  | de la compania.
    
<!-- END_d7b7952e7fdddc07c978c9bdaf757acf -->

<!-- START_c3fa189a6c95ca36ad6ac4791a873d23 -->
## Crear un token de usuario

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"autorizador":"mart_admin@hotmail.com","email":"mart@hotmail.com","password":"Hol@MunD0","environment":"dev"}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "autorizador": "mart_admin@hotmail.com",
    "email": "mart@hotmail.com",
    "password": "Hol@MunD0",
    "environment": "dev"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/login',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'autorizador' => 'mart_admin@hotmail.com',
            'email' => 'mart@hotmail.com',
            'password' => 'Hol@MunD0',
            'environment' => 'dev',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "status_code": "200",
    "token": "slghn1EDIJjMvYNkAFQvnHGfPDl5srH8X11TKyl"
}
```
> Example response (500):

```json
{
    "message": "Password incorrecto"
}
```

### HTTP Request
`POST api/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `autorizador` | email |  required  | El email del usuario autorizador.
        `email` | email |  required  | El email del usuario.
        `password` | string |  required  | El password del usuario
        `environment` | string |  required  | Valores válidos: dev, prod
    
<!-- END_c3fa189a6c95ca36ad6ac4791a873d23 -->

<!-- START_00e7e21641f05de650dbe13f242c6f2c -->
## Expirar un token de usuario
Debe enviar en las cabeceras el token de autorización
Ejemplo: Authorization Bearer 1|slghn1EDIJjMvYNkAFQvnHGfPDl5srH8XM11Kyly

> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/logout"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/logout',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "status_code": 200,
    "token": "Token has deleted succesfully"
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`GET api/logout`


<!-- END_00e7e21641f05de650dbe13f242c6f2c -->

#Avaluos

APIs para crear, actualizar Avaluos
<!-- START_aaf671e787e153d60542cd54abafc989 -->
## api/getAvaluos
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/getAvaluos" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/getAvaluos"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/getAvaluos',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`GET api/getAvaluos`


<!-- END_aaf671e787e153d60542cd54abafc989 -->

<!-- START_886ecfa9e7067df464ed5ece912fcb4f -->
## api/getAvaluo/{id}
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/getAvaluo/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/getAvaluo/1"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/getAvaluo/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`GET api/getAvaluo/{id}`


<!-- END_886ecfa9e7067df464ed5ece912fcb4f -->

<!-- START_191fa79438deda52615343540127f4c1 -->
## api/createUpdateAvaluo
> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/createUpdateAvaluo" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/createUpdateAvaluo"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/createUpdateAvaluo',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/createUpdateAvaluo`


<!-- END_191fa79438deda52615343540127f4c1 -->

<!-- START_8036f05f3ef71a61c9e02baae9e1d948 -->
## api/pdf/{id}
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/pdf/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/pdf/1"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/pdf/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`GET api/pdf/{id}`


<!-- END_8036f05f3ef71a61c9e02baae9e1d948 -->

<!-- START_c75db24ebac03538f61ed8062f316a0f -->
## api/correo/{id}
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/correo/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/correo/1"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/correo/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`GET api/correo/{id}`


<!-- END_c75db24ebac03538f61ed8062f316a0f -->

#Landing Pages


API para crear, actualizar landing pages
<!-- START_f24644e7d8f231a4b87c73b05b64be4e -->
## Landing Pages

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/create_landing_page" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"name":"Exonerados","medio":"18","properties_form":"[{\"label\": \"Tipo de discapacidad\",\"value\": \"tipo_discapacidad\",\"validations\": \"required\" } ]","autorizador":"autorizador@gmail.com","campaign":"RODRIGUEZ 0626c2b0-1ad2-11ea-830b-000c297d72b1","business_line_id":"f417e1ae-a81b-11e9-ab2c-000c297d72b1","user_login":"tde","type_transaction":"1","user_assigned_position":"2"}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/create_landing_page"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/create_landing_page',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'name' => 'Exonerados',
                'medio' => '18',
                'properties_form' => '[{"label": "Tipo de discapacidad","value": "tipo_discapacidad","validations": "required" } ]',
                'autorizador' => 'autorizador@gmail.com',
                'campaign' => 'RODRIGUEZ 0626c2b0-1ad2-11ea-830b-000c297d72b1',
                'business_line_id' => 'f417e1ae-a81b-11e9-ab2c-000c297d72b1',
                'user_login' => 'tde',
                'type_transaction' => '1',
                'user_assigned_position' => '2',
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "status_code": "200",
        "messsage": "Landing Page creada correctamente"
    }
}
```
> Example response (200):

```json
{
    "data": {
        "status_code": "400",
        "messsage": "Revise que sus datos sean correctos"
    }
}
```

### HTTP Request
`POST api/create_landing_page`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.name` | string |  required  | Nombre del Formulario
        `datosSugarCRM.medio` | numeric |  required  | ID del medio.
        `datosSugarCRM.properties_form` | array |  required  | Propiedades Extras del Formulario
        `datosSugarCRM.autorizador` | string |  required  | Email del autorizador.
        `datosSugarCRM.campaign` | string |  required  | Código de Campaña.
        `datosSugarCRM.business_line_id` | string |  required  | Código de linea de negocio.
        `datosSugarCRM.user_login` | numeric |  required  | Celular del cliente.
        `datosSugarCRM.type_transaction` | numeric |  optional  | Tipo de Trasnsacción Valores válidos: 1 (Ventas),2 (Tomas),3 (Quejas),4 (Info General)
        `datosSugarCRM.user_assigned_position` | numeric |  required  | Cargo del usuario para asignación
    
<!-- END_f24644e7d8f231a4b87c73b05b64be4e -->

#Prospección


APIs para creación de prospectos, reagendamiento de citas, cierre de prospectos
<!-- START_5675906540fb61185904594cc17d7875 -->
## Prospección - cotización (whatsApp, webChat y Facebook)

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/quotation" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"user_name_call_center":"CG_RAMOS","ticket_id":"10438baf-0d83-9533-4fb3-602ea326288b","comments":"El cliente se acerca a la agencia...","modelo":"Hilux 4X4 2021 color rojo","medio":"10","campania":"5e686580-ee19-11ea-97ea-000c297d72b1","client":{"tipo_identificacion":"C","numero_identificacion":"1719932079","gender":"M","names":"Roberto Daniel","surnames":"J\u00e1come Rodriguez","phone_home":"022072845","cellphone_number":"0987512224","email":"mart2021@hotmail.com"}},"datos_adicionales":{"anyproperty1":"anyData1","anyproperty1N":"anyData2"}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/quotation"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/quotation',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'user_name_call_center' => 'CG_RAMOS',
                'ticket_id' => '10438baf-0d83-9533-4fb3-602ea326288b',
                'comments' => 'El cliente se acerca a la agencia...',
                'modelo' => 'Hilux 4X4 2021 color rojo',
                'medio' => '10',
                'campania' => '5e686580-ee19-11ea-97ea-000c297d72b1',
                'client' => [
                    'tipo_identificacion' => 'C',
                    'numero_identificacion' => '1719932079',
                    'gender' => 'M',
                    'names' => 'Roberto Daniel',
                    'surnames' => 'Jácome Rodriguez',
                    'phone_home' => '022072845',
                    'cellphone_number' => '0987512224',
                    'email' => 'mart2021@hotmail.com',
                ],
            ],
            'datos_adicionales' => [
                'anyproperty1' => 'anyData1',
                'anyproperty1N' => 'anyData2',
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "prospeccion_url": "https:\/\/sugarcrm.casabaca.com\/#cbp_Prospeccion\/b9400c64-9a35-cf31-cf26-604bcac73032"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "datosSugarCRM.user_name_call_center": [
            "User-name inválido, call center no se encuentra registrado"
        ],
        "datosSugarCRM.client.tipo_identificacion": [
            "Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)"
        ]
    }
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/quotation`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.user_name_call_center` | string |  required  | UserName del call center válido en SUGAR.
        `datosSugarCRM.ticket_id` | string |  required  | ID del Ticket de SUGAR al que hace referencia.
        `datosSugarCRM.comments` | string |  required  | Comentarios/descripción acerca del prospecto.
        `datosSugarCRM.modelo` | string |  required  | Modelo a cotizar.
        `datosSugarCRM.medio` | numeric |  required  | Medio de la llamada
        `datosSugarCRM.campania` | id |  optional  | Campaña de la llamada
        `datosSugarCRM.client.tipo_identificacion` | string |  required  | Tipo de identificación del ciente a cotizar, valores válidos  C(Cedula),P(Pasaporte), R(RUC).
        `datosSugarCRM.client.numero_identificacion` | string |  required  | Número de identificación del cliente a cotizar.
        `datosSugarCRM.client.gender` | string |  required  | Género del cliente a cotizar. valores válidos: F (Femenino),M (Masculino)
        `datosSugarCRM.client.names` | string |  required  | Nombres del cliente a cotizar.
        `datosSugarCRM.client.surnames` | string |  required  | Apellido del cliente a cotizar.
        `datosSugarCRM.client.phone_home` | numeric |  required  | Telefono Local del cliente a cotizar.
        `datosSugarCRM.client.cellphone_number` | numeric |  required  | Celular del cliente a cotizar.
        `datosSugarCRM.client.email` | email |  required  | email del cliente a cotizar.
        `datos_adicionales.anyproperty1` | any |  optional  | Datos adicionales de la aplicación externa
        `datos_adicionales.anyproperty1N` | any |  optional  | Datos adicionales de la aplicación externa
    
<!-- END_5675906540fb61185904594cc17d7875 -->

<!-- START_1ca6da367f10e1fec3fa291a8eb234d2 -->
## Prospección - cotización (1800)

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/call_quotation" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"user_name_call_center":"CG_RAMOS","date_start":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"10","direction":"Inbound","type":"seguimiento","ticket_id":"10438baf-0d83-9533-4fb3-602ea326288b","comments":"El cliente se acerca a la agencia...","modelo":"Hilux 4X4 2021 color rojo","medio":"13","client":{"tipo_identificacion":"C","numero_identificacion":"1719932079","gender":"M","names":"Roberto Daniel","surnames":"J\u00e1come Rodriguez","phone_home":"022072845","cellphone_number":"0987512224","email":"mart2021@hotmail.com"}},"datos_adicionales":{"anyproperty1":"anyData1","anyproperty1N":"anyData2"}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/call_quotation"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/call_quotation',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'user_name_call_center' => 'CG_RAMOS',
                'date_start' => '2021-10-02 19:59',
                'duration_hours' => '0',
                'duration_minutes' => '10',
                'direction' => 'Inbound',
                'type' => 'seguimiento',
                'ticket_id' => '10438baf-0d83-9533-4fb3-602ea326288b',
                'comments' => 'El cliente se acerca a la agencia...',
                'modelo' => 'Hilux 4X4 2021 color rojo',
                'medio' => '13',
                'client' => [
                    'tipo_identificacion' => 'C',
                    'numero_identificacion' => '1719932079',
                    'gender' => 'M',
                    'names' => 'Roberto Daniel',
                    'surnames' => 'Jácome Rodriguez',
                    'phone_home' => '022072845',
                    'cellphone_number' => '0987512224',
                    'email' => 'mart2021@hotmail.com',
                ],
            ],
            'datos_adicionales' => [
                'anyproperty1' => 'anyData1',
                'anyproperty1N' => 'anyData2',
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "call_id": "aa172c6b-5595-27d3-b81e-60e7556c16bc",
        "prospeccion_url": "https:\/\/sugarcrm.casabaca.com\/#cbp_Prospeccion\/b9400c64-9a35-cf31-cf26-604bcac73032"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "datosSugarCRM.user_name_call_center": [
            "User-name inválido, call center no se encuentra registrado"
        ],
        "datosSugarCRM.client.tipo_identificacion": [
            "Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)"
        ]
    }
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/call_quotation`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.user_name_call_center` | string |  required  | UserName del call center válido en SUGAR.
        `datosSugarCRM.date_start` | date |  required  | Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i.
        `datosSugarCRM.duration_hours` | numeric |  required  | Indica la duración en horas de la llamada.
        `datosSugarCRM.duration_minutes` | numeric |  required  | Indica la duración en minutos de la llamada.
        `datosSugarCRM.direction` | string |  required  | Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente)
        `datosSugarCRM.type` | string |  required  | Tipo de Cita, valores válidos: seguimiento, automatica
        `datosSugarCRM.ticket_id` | string |  required  | ID del Ticket de SUGAR al que hace referencia.
        `datosSugarCRM.comments` | string |  required  | Comentarios/descripción acerca del prospecto.
        `datosSugarCRM.modelo` | string |  required  | Modelo a cotizar.
        `datosSugarCRM.medio` | numeric |  required  | Medio del Ticket
        `datosSugarCRM.client.tipo_identificacion` | string |  required  | Tipo de identificación del ciente a cotizar, valores válidos  C(Cedula),P(Pasaporte), R(RUC).
        `datosSugarCRM.client.numero_identificacion` | string |  required  | Número de identificación del cliente a cotizar.
        `datosSugarCRM.client.gender` | string |  required  | Género del cliente a cotizar. valores válidos: F (Femenino),M (Masculino)
        `datosSugarCRM.client.names` | string |  required  | Nombres del cliente a cotizar.
        `datosSugarCRM.client.surnames` | string |  required  | Apellido del cliente a cotizar.
        `datosSugarCRM.client.phone_home` | numeric |  required  | Telefono Local del cliente a cotizar.
        `datosSugarCRM.client.cellphone_number` | numeric |  required  | Celular del cliente a cotizar.
        `datosSugarCRM.client.email` | email |  required  | email del cliente a cotizar.
        `datos_adicionales.anyproperty1` | any |  optional  | Datos adicionales de la aplicación externa
        `datos_adicionales.anyproperty1N` | any |  optional  | Datos adicionales de la aplicación externa
    
<!-- END_1ca6da367f10e1fec3fa291a8eb234d2 -->

<!-- START_57da0564914a4b1f3e5bf3bf9b953da1 -->
## Crear Llamada - Reagendamiento de cita

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/calls_prospeccion" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"user_name_asesor":"CG_RAMOS","user_name_call_center":"JA_AGUIRRE","date_start":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"10","status":"Held","direction":"Inbound","type":"cita","category":"2","notes":"Llamar lunes","prospeccion_id":"769cb57f-a32d-0ad0-3f0d-60c8e1d1658f","meeting":{"date":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"2","subject":"Prueba de Manejo","comments":"El cliente se acerca a la agencia...","location":"Agencia los Chillos","type":"1","visit_type":"1","linea_negocio":"1","marca":"1","modelo":"2","client":{"tipo_identificacion":"C","numero_identificacion":"1719932079","gender":"M","names":"Freddy Roberto","surnames":"Vargas Rodriguez","phone_home":"022072845","cellphone_number":"0987512224","email":"mart2021@hotmail.com"}}},"datos_adicionales":{"anyproperty1":"anyData1","anyproperty1N":"anyData2"}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/calls_prospeccion"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/calls_prospeccion',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'user_name_asesor' => 'CG_RAMOS',
                'user_name_call_center' => 'JA_AGUIRRE',
                'date_start' => '2021-10-02 19:59',
                'duration_hours' => '0',
                'duration_minutes' => '10',
                'status' => 'Held',
                'direction' => 'Inbound',
                'type' => 'cita',
                'category' => '2',
                'notes' => 'Llamar lunes',
                'prospeccion_id' => '769cb57f-a32d-0ad0-3f0d-60c8e1d1658f',
                'meeting' => [
                    'date' => '2021-10-02 19:59',
                    'duration_hours' => '0',
                    'duration_minutes' => '2',
                    'subject' => 'Prueba de Manejo',
                    'comments' => 'El cliente se acerca a la agencia...',
                    'location' => 'Agencia los Chillos',
                    'type' => '1',
                    'visit_type' => '1',
                    'linea_negocio' => '1',
                    'marca' => '1',
                    'modelo' => '2',
                    'client' => [
                        'tipo_identificacion' => 'C',
                        'numero_identificacion' => '1719932079',
                        'gender' => 'M',
                        'names' => 'Freddy Roberto',
                        'surnames' => 'Vargas Rodriguez',
                        'phone_home' => '022072845',
                        'cellphone_number' => '0987512224',
                        'email' => 'mart2021@hotmail.com',
                    ],
                ],
            ],
            'datos_adicionales' => [
                'anyproperty1' => 'anyData1',
                'anyproperty1N' => 'anyData2',
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "call_id": "3d5a6040-cf8d-116a-85c0-60515e1f2ff2",
        "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "meeting_id": "3b970e6d-46e8-3455-1250-6054d939216c"
    }
}
```
> Example response (200):

```json
{
    "data": {
        "call_id": "3d5a6040-cf8d-116a-85c0-60515e1f2ff2",
        "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "meeting_id": "N\/A"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "datosSugarCRM.user_name_asesor": [
            "User_name del asesor es requerido"
        ],
        "datosSugarCRM.date_start": [
            "La fecha de inicio debe ser una fecha"
        ]
    }
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```
> Example response (500):

```json
{
    "error": "La prospeccion seleccionada ya tiene una reunión planificada"
}
```

### HTTP Request
`POST api/calls_prospeccion`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.user_name_asesor` | string |  optional  | UserName del asesor en SUGAR es requerido si la llamada es tipo cita.
        `datosSugarCRM.user_name_call_center` | string |  required  | UserName del call center válido en SUGAR.
        `datosSugarCRM.date_start` | date |  required  | Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i.
        `datosSugarCRM.duration_hours` | numeric |  required  | Indica la duración en horas de la llamada.
        `datosSugarCRM.duration_minutes` | numeric |  required  | Indica la duración en minutos de la llamada.
        `datosSugarCRM.status` | string |  required  | Valores válidos: Held (Realizada)
        `datosSugarCRM.direction` | string |  required  | Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente)
        `datosSugarCRM.type` | string |  required  | Tipo de Cita, valores válidos: seguimiento, cita.
        `datosSugarCRM.category` | numeric |  required  | Categoria, valores válidos: 1 (Preventa), 2(PostVenta), 3(Prospección).
        `datosSugarCRM.notes` | string |  required  | Notas relacionada a la llamada realizada.
        `datosSugarCRM.prospeccion_id` | string |  required  | ID del Prospecto de SUGAR al que hace referencia.
        `datosSugarCRM.meeting.date` | string |  required  | Fecha de la cita si la llamada es tipo cita, Zona Horaria - UTC, Formato:Y-m-d H:i.
        `datosSugarCRM.meeting.duration_hours` | numeric |  required  | Duracion horas requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.duration_minutes` | numeric |  required  | Duración de minutos requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.subject` | numeric |  required  | Asunto es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.comments` | numeric |  required  | Comentarios es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.location` | string |  required  | Ubicación de la cita es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.type` | numeric |  required  | Tipo de cita es requerido si la llamada es tipo cita, valores válidos  1 (Cita Física / Normal),2 (Virtual).
        `datosSugarCRM.meeting.visit_type` | numeric |  required  | Tipo de visita es requerido si la llamada es tipo cita, valores válidos  1 (Primera Visita),2 (Be-back), 3(Visita Anterior).
        `datosSugarCRM.meeting.linea_negocio` | numeric |  required  | Linea de negocio es requerido si la llamada es tipo cita, valores válidos  1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados).
        `datosSugarCRM.meeting.marca` | string |  optional  | Marca del vehículo - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.
        `datosSugarCRM.meeting.modelo` | string |  optional  | Modelo del vehículo - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.
        `datosSugarCRM.meeting.client.tipo_identificacion` | string |  required  | Tipo de identificación del ciente es requerido si la llamada es tipo cita, valores válidos  C(Cedula),P(Pasaporte), R(RUC).
        `datosSugarCRM.meeting.client.numero_identificacion` | string |  required  | Número de identificación del cliente es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.client.gender` | string |  required  | Género del cliente es requerido si la llamada es tipo cita. valores válidos: F (Femenino),M (Masculino)
        `datosSugarCRM.meeting.client.names` | string |  required  | Nombres del cliente es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.client.surnames` | string |  required  | Apellido del cliente es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.client.phone_home` | numeric |  optional  | Telefono Local del cliente es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.client.cellphone_number` | numeric |  required  | Celular del cliente es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.client.email` | email |  required  | email del cliente es requerido si la llamada es tipo cita.
        `datos_adicionales.anyproperty1` | any |  optional  | Datos adicionales de la aplicación externa
        `datos_adicionales.anyproperty1N` | any |  optional  | Datos adicionales de la aplicación externa
    
<!-- END_57da0564914a4b1f3e5bf3bf9b953da1 -->

<!-- START_ee43d68a55417a9e9a7535ff8dcb5232 -->
## Cerrar Prospección

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/close_prospeccion/7c093743-5b5d-01ec-f0b4-604a99b319d3" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"motivo_cierre":"1"}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/close_prospeccion/7c093743-5b5d-01ec-f0b4-604a99b319d3"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/close_prospeccion/7c093743-5b5d-01ec-f0b4-604a99b319d3',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'motivo_cierre' => '1',
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "prospeccion_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "prospeccion_name": "PROSPECTO-73097"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "datosSugarCRM.motivo_cierre": [
            "Motivo de cierre es requerido"
        ]
    }
}
```
> Example response (404):

```json
{
    "error": "Prospección no existe, id inválido"
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/close_prospeccion/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Id de la prospección creada anteriormente en SUGAR
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.motivo_cierre` | string |  required  | Motivo para cerrar un ticket - Valores válidos: 1(No aplica a financiamiento), 2(Sólo Información), 3(No Contactado), 4(Desiste), 5(Compra Futura)
    
<!-- END_ee43d68a55417a9e9a7535ff8dcb5232 -->

<!-- START_c9b0c7528d8e45b356488364e69b6ea1 -->
## Prospección - APP Talleres

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/forms_prospeccion" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"numero_identificacion":"1719932079","tipo_identificacion":"C","nombres":"Marta Patricia","apellidos":"Andrade Torres","email":"mart@hotmail.com","celular":"0987519882","agencia":"20","fuente":"17","modelo":"NEW HILUX 2.7 CD 4X2","comentarios":"Comentario Test","tienetoyota":"1","interesadorenovacion":"1","horaentregainmediata":"2021-08-31 14:00:00","asesorcorreo":"asesor@casabaca.com","asesornombre":"Pepito Martinez"}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/forms_prospeccion"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/forms_prospeccion',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'numero_identificacion' => '1719932079',
                'tipo_identificacion' => 'C',
                'nombres' => 'Marta Patricia',
                'apellidos' => 'Andrade Torres',
                'email' => 'mart@hotmail.com',
                'celular' => '0987519882',
                'agencia' => '20',
                'fuente' => '17',
                'modelo' => 'NEW HILUX 2.7 CD 4X2',
                'comentarios' => 'Comentario Test',
                'tienetoyota' => '1',
                'interesadorenovacion' => '1',
                'horaentregainmediata' => '2021-08-31 14:00:00',
                'asesorcorreo' => 'asesor@casabaca.com',
                'asesornombre' => 'Pepito Martinez',
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "prospeccion_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_url": "https:\/\/sugarcrm.casabaca.com\/#cbp_Prospeccion\/e06279dc-5629-5b20-6ebf-61081a41553a"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "numero_identificacion": [
            "Identificación es requerida"
        ],
        "nombres": [
            "Nombres son requeridos"
        ]
    }
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/forms_prospeccion`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.numero_identificacion` | string |  required  | ID del client.
        `datosSugarCRM.tipo_identificacion` | string |  required  | Valores válidos: C(Cedula),P(Pasaporte), R(RUC)
        `datosSugarCRM.nombres` | string |  required  | Nombres del cliente.
        `datosSugarCRM.apellidos` | string |  required  | Apellidos del cliente, puede ir en blanco cuando el tipo de identificación es Persona Jurídica.
        `datosSugarCRM.email` | email |  required  | Email válido del cliente.
        `datosSugarCRM.celular` | numeric |  required  | Celular del cliente.
        `datosSugarCRM.agencia` | numeric |  required  | ID S3S de la Agencia
        `datosSugarCRM.fuente` | numeric |  required  | Fuente Permitida 17(APP Talleres)
        `datosSugarCRM.modelo` | string |  required  | Nombre del Modelo
        `datosSugarCRM.comentarios` | string |  optional  | Comentario test
        `datosSugarCRM.tienetoyota` | numeric |  optional  | Tiene Toyota? 1(SI), 0(NO)
        `datosSugarCRM.interesadorenovacion` | numeric |  optional  | Interesado en Renovación 1(SI), 0(NO)
        `datosSugarCRM.horaentregainmediata` | dateTime |  optional  | Fecha y Hora de entrega Formato Y-m-d hh:mm:ss
        `datosSugarCRM.asesorcorreo` | mail |  optional  | Correo del asesor
        `datosSugarCRM.asesornombre` | string |  optional  | Nombre del asesor
    
<!-- END_c9b0c7528d8e45b356488364e69b6ea1 -->

#Prospección - Citas


Api para crear Llamada - Cita - Prospección
<!-- START_4ab385e6babe171ebd61d88e554311bf -->
## Crear Llamada - Cita - Prospección

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/calls" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"user_name_asesor":"CG_RAMOS","user_name_call_center":"CG_RAMOS","date_start":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"10","status":"Held","direction":"Inbound","type":"cita","category":"2","medio":"10","campania":"5e686580-ee19-11ea-97ea-000c297d72b1","notes":"Llamar lunes","ticket":{"id":"10438baf-0d83-9533-4fb3-602ea326288b","is_closed":true,"motivo_cierre":"solo_informacion"},"meeting":{"status":"Held","date":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"2","subject":"Prueba de Manejo","comments":"El cliente se acerca a la agencia...","location":"Agencia los Chillos","type":"1","visit_type":"1","linea_negocio":"1","marca":"1","modelo":"2","client":{"tipo_identificacion":"C","numero_identificacion":"1719932079","gender":"M","names":"Freddy Roberto","surnames":"Vargas Rodriguez","phone_home":"022072845","cellphone_number":"0987512224","email":"mart2021@hotmail.com"}}},"datos_adicionales":{"anyproperty1":"anyData1","anyproperty1N":"anyData2"}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/calls"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/calls',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'user_name_asesor' => 'CG_RAMOS',
                'user_name_call_center' => 'CG_RAMOS',
                'date_start' => '2021-10-02 19:59',
                'duration_hours' => '0',
                'duration_minutes' => '10',
                'status' => 'Held',
                'direction' => 'Inbound',
                'type' => 'cita',
                'category' => '2',
                'medio' => '10',
                'campania' => '5e686580-ee19-11ea-97ea-000c297d72b1',
                'notes' => 'Llamar lunes',
                'ticket' => [
                    'id' => '10438baf-0d83-9533-4fb3-602ea326288b',
                    'is_closed' => true,
                    'motivo_cierre' => 'solo_informacion',
                ],
                'meeting' => [
                    'status' => 'Held',
                    'date' => '2021-10-02 19:59',
                    'duration_hours' => '0',
                    'duration_minutes' => '2',
                    'subject' => 'Prueba de Manejo',
                    'comments' => 'El cliente se acerca a la agencia...',
                    'location' => 'Agencia los Chillos',
                    'type' => '1',
                    'visit_type' => '1',
                    'linea_negocio' => '1',
                    'marca' => '1',
                    'modelo' => '2',
                    'client' => [
                        'tipo_identificacion' => 'C',
                        'numero_identificacion' => '1719932079',
                        'gender' => 'M',
                        'names' => 'Freddy Roberto',
                        'surnames' => 'Vargas Rodriguez',
                        'phone_home' => '022072845',
                        'cellphone_number' => '0987512224',
                        'email' => 'mart2021@hotmail.com',
                    ],
                ],
            ],
            'datos_adicionales' => [
                'anyproperty1' => 'anyData1',
                'anyproperty1N' => 'anyData2',
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "call_id": "3d5a6040-cf8d-116a-85c0-60515e1f2ff2",
        "ticket_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
        "meeting_id": "3b970e6d-46e8-3455-1250-6054d939216c"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "datosSugarCRM.user_name_asesor": [
            "User_name del asesor es requerido"
        ],
        "datosSugarCRM.date_start": [
            "La fecha de inicio debe ser una fecha"
        ]
    }
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/calls`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.user_name_asesor` | string |  optional  | UserName del asesor en SUGAR es requerido si la llamada es tipo cita.
        `datosSugarCRM.user_name_call_center` | string |  required  | UserName del call center válido en SUGAR.
        `datosSugarCRM.date_start` | date |  required  | Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i.
        `datosSugarCRM.duration_hours` | numeric |  required  | Indica la duración en horas de la llamada.
        `datosSugarCRM.duration_minutes` | numeric |  required  | Indica la duración en minutos de la llamada.
        `datosSugarCRM.status` | string |  required  | Valores válidos: Held (Realizada)
        `datosSugarCRM.direction` | string |  required  | Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente)
        `datosSugarCRM.type` | string |  required  | Tipo de Cita, valores válidos: seguimiento, cita, cita_chat.
        `datosSugarCRM.category` | numeric |  required  | Categoria, valores válidos: 1 (Preventa), 2(PostVenta), 3(Prospección).
        `datosSugarCRM.medio` | numeric |  required  | Medio de la llamada
        `datosSugarCRM.campania` | id |  optional  | Campaña de la llamada
        `datosSugarCRM.notes` | string |  required  | Notas relacionada a la llamada realizada.
        `datosSugarCRM.ticket.id` | string |  required  | ID del Ticket de SUGAR al que hace referencia.
        `datosSugarCRM.ticket.is_closed` | boolean |  required  | Si desea cerrar el ticket asociado debe ir true.
        `datosSugarCRM.ticket.motivo_cierre` | string |  required  | Motivo para cerrar un ticket - Valores válidos: abandono_chat,solo_informacion,desiste,no_contesta,compra_futura
        `datosSugarCRM.meeting.status` | string |  required  | Estado es requerido si la llamada es tipo cita, valores válidos: Planned (Planificada), Held (Realizada)
        `datosSugarCRM.meeting.date` | string |  required  | Fecha de la cita si la llamada es tipo cita, Zona Horaria - UTC, Formato:Y-m-d H:i.
        `datosSugarCRM.meeting.duration_hours` | numeric |  required  | Duracion horas requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.duration_minutes` | numeric |  required  | Duración de minutos requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.subject` | numeric |  required  | Asunto es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.comments` | numeric |  required  | Comentarios es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.location` | string |  required  | Ubicación de la cita es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.type` | numeric |  required  | Tipo de cita es requerido si la llamada es tipo cita, valores válidos  1 (Cita Física / Normal),2 (Virtual).
        `datosSugarCRM.meeting.visit_type` | numeric |  required  | Tipo de visita es requerido si la llamada es tipo cita, valores válidos  1 (Primera Visita),2 (Be-back), 3(Visita Anterior).
        `datosSugarCRM.meeting.linea_negocio` | numeric |  required  | Linea de negocio es requerido si la llamada es tipo cita, valores válidos  1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados).
        `datosSugarCRM.meeting.marca` | string |  optional  | Marca del vehículo - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.
        `datosSugarCRM.meeting.modelo` | string |  optional  | Modelo del vehículo - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.
        `datosSugarCRM.meeting.client.tipo_identificacion` | string |  required  | Tipo de identificación del ciente es requerido si la llamada es tipo cita, valores válidos  C(Cedula),P(Pasaporte), R(RUC).
        `datosSugarCRM.meeting.client.numero_identificacion` | string |  required  | Número de identificación del cliente es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.client.gender` | string |  required  | Género del cliente es requerido si la llamada es tipo cita. valores válidos: F (Femenino),M (Masculino)
        `datosSugarCRM.meeting.client.names` | string |  required  | Nombres del cliente es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.client.surnames` | string |  required  | Apellido del cliente es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.client.phone_home` | numeric |  optional  | Telefono Local del cliente es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.client.cellphone_number` | numeric |  required  | Celular del cliente es requerido si la llamada es tipo cita.
        `datosSugarCRM.meeting.client.email` | email |  required  | email del cliente es requerido si la llamada es tipo cita.
        `datos_adicionales.anyproperty1` | any |  optional  | Datos adicionales de la aplicación externa
        `datos_adicionales.anyproperty1N` | any |  optional  | Datos adicionales de la aplicación externa
    
<!-- END_4ab385e6babe171ebd61d88e554311bf -->

#Tickets


APIs para crear, actualizar tickets y crear interacciones
<!-- START_c116c2f5639c323eb7e0108ce3b62ce1 -->
## Ticket - Interacción

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/tickets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"numero_identificacion":"1719932079","tipo_identificacion":"C","email":"mart@hotmail.com","user_name":"CG_RAMOS","nombres":"FREDDY ROBERTO","apellidos":"RODRIGUEZ VARGAS","celular":"0987519882","telefono":"022072827","linea_negocio":"1","tipo_transaccion":"1","anio":"2020","placa":"PCY-7933","medio":"13","campania":"5e686580-ee19-11ea-97ea-000c297d72b1","asunto":"Mantenimiento","comentario_cliente":"Necesita una cita para mantenimiento","id_interaccion_inconcert":"id_inconcert","description":"El cliente requiere una cotizacion urgente","porcentaje_discapacidad":"50_74","marca":"1","modelo":"2","precio":"25000","color":"negro","anioMin":"2018","anioMax":"2020","kilometraje":"25000","combustible":"gasolina"},"datos_adicionales":{"title":"Titulo del Formulario","pageUrl":"https:\/\/www.toyota.com.ec\/formulariox.html","thankyouPageUrl":"https:\/\/www.toyota.com.ec\/graciasFormularioX.html","fields":[{"key":"Nombres","nombre":"Maria"},{"key":"Apellidos","nombre":"Rodriguez"},{"key":"Cedula","nombre":"171999999"}]}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/tickets"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/tickets',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'numero_identificacion' => '1719932079',
                'tipo_identificacion' => 'C',
                'email' => 'mart@hotmail.com',
                'user_name' => 'CG_RAMOS',
                'nombres' => 'FREDDY ROBERTO',
                'apellidos' => 'RODRIGUEZ VARGAS',
                'celular' => '0987519882',
                'telefono' => '022072827',
                'linea_negocio' => '1',
                'tipo_transaccion' => '1',
                'anio' => '2020',
                'placa' => 'PCY-7933',
                'medio' => '13',
                'campania' => '5e686580-ee19-11ea-97ea-000c297d72b1',
                'asunto' => 'Mantenimiento',
                'comentario_cliente' => 'Necesita una cita para mantenimiento',
                'id_interaccion_inconcert' => 'id_inconcert',
                'description' => 'El cliente requiere una cotizacion urgente',
                'porcentaje_discapacidad' => '50_74',
                'marca' => '1',
                'modelo' => '2',
                'precio' => '25000',
                'color' => 'negro',
                'anioMin' => '2018',
                'anioMax' => '2020',
                'kilometraje' => '25000',
                'combustible' => 'gasolina',
            ],
            'datos_adicionales' => [
                'title' => 'Titulo del Formulario',
                'pageUrl' => 'https://www.toyota.com.ec/formulariox.html',
                'thankyouPageUrl' => 'https://www.toyota.com.ec/graciasFormularioX.html',
                'fields' => [
                    [
                        'key' => 'Nombres',
                        'nombre' => 'Maria',
                    ],
                    [
                        'key' => 'Apellidos',
                        'nombre' => 'Rodriguez',
                    ],
                    [
                        'key' => 'Cedula',
                        'nombre' => '171999999',
                    ],
                ],
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_name": "TCK-463587",
        "interaction_id": "1042eae5-0c94-1f7f-ef16-602e98cbd391"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "numero_identificacion": [
            "Identificación es requerida"
        ],
        "nombres": [
            "Nombres son requeridos"
        ]
    }
}
```
> Example response (404):

```json
{
    "error": "User-name inválido, asesor  no se encuentra registrado"
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/tickets`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.numero_identificacion` | string |  optional  | ID del client.
        `datosSugarCRM.tipo_identificacion` | string |  optional  | Valores válidos: C(Cedula),P(Pasaporte), R(RUC)
        `datosSugarCRM.email` | email |  required  | Email válido del cliente.
        `datosSugarCRM.user_name` | string |  optional  | Es requerido si la fuente es inConcert. UserName válido del asesor en SUGAR.
        `datosSugarCRM.nombres` | string |  required  | Nombres del cliente.
        `datosSugarCRM.apellidos` | string |  required  | Apellidos del cliente.
        `datosSugarCRM.celular` | numeric |  required  | Celular del cliente.
        `datosSugarCRM.telefono` | numeric |  optional  | Telefono local del cliente.
        `datosSugarCRM.linea_negocio` | string |  optional  | Valores válidos: 1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados)
        `datosSugarCRM.tipo_transaccion` | numeric |  optional  | Valores válidos: 1 (Ventas),2 (Tomas),3 (Quejas),4 (Info General)
        `datosSugarCRM.anio` | string |  optional  | Año del vehículo
        `datosSugarCRM.placa` | string |  optional  | Placa del vehículo
        `datosSugarCRM.medio` | numeric |  required  | Medio del Ticket
        `datosSugarCRM.campania` | numeric |  optional  | Id de la Campaña del Formulario
        `datosSugarCRM.asunto` | string |  optional  | Asunto requerido si existe comentario del cliente
        `datosSugarCRM.comentario_cliente` | string |  optional  | Comentario del cliente
        `datosSugarCRM.id_interaccion_inconcert` | string |  required  | ID definido en el sistema externo
        `datosSugarCRM.description` | string |  optional  | Comentario Asesor
        `datosSugarCRM.porcentaje_discapacidad` | string |  optional  | Porcentaje de discapacidad del cliente, , valores válidos: 30_49 (Del 30% al 49%),50_74 (Del 50% al 74%),75_84 (Del 75% al 84%),85_100(Del 85% al 100%)
        `datosSugarCRM.marca` | string |  optional  | Marca del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.
        `datosSugarCRM.modelo` | string |  optional  | Modelo del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.
        `datosSugarCRM.precio` | string |  optional  | Precio del vehículo (Requerido para CarMatch)
        `datosSugarCRM.color` | string |  optional  | Color del vehículo (Requerido para CarMatch)
        `datosSugarCRM.anioMin` | string |  optional  | Año Mínimo  del vehículo (Requerido para CarMatch)
        `datosSugarCRM.anioMax` | string |  optional  | Año Máximo del vehículo (Requerido para CarMatch)
        `datosSugarCRM.kilometraje` | string |  optional  | Kilometraje del vehículo (Requerido para CarMatch)
        `datosSugarCRM.combustible` | string |  optional  | Combustible del vehículo Valores válidos: gasolina,diesel (Requerido para CarMatch)
        `datos_adicionales.title` | string |  optional  | Nombre del formulario
        `datos_adicionales.pageUrl` | string |  optional  | URL del formulario
        `datos_adicionales.thankyouPageUrl` | string |  optional  | URL de la página de agradecimiento
        `datos_adicionales.fields` | array |  optional  | Arreglo con los campos del formulario
        `datos_adicionales.fields.0.key` | string |  optional  | Nombre del campo 1 del formulario  formulario
        `datos_adicionales.fields.0.nombre` | string |  optional  | Data del campo 1 del formulario
        `datos_adicionales.fields.1.key` | string |  optional  | Nombre del campo 2 del formulario  formulario
        `datos_adicionales.fields.1.nombre` | string |  optional  | Data del campo 2 del formulario
        `datos_adicionales.fields.2.key` | string |  optional  | Nombre del campo n del formulario  formulario
        `datos_adicionales.fields.2.nombre` | string |  optional  | Data del campo n del formulario
    
<!-- END_c116c2f5639c323eb7e0108ce3b62ce1 -->

<!-- START_c199d38571334fe663cb31edce93371f -->
## Ticket - Llamadas entrantes y salientes

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/call_ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"numero_identificacion":"1719932079","tipo_identificacion":"C","email":"mart@hotmail.com","user_name":"CG_RAMOS","nombres":"FREDDY ROBERTO","apellidos":"RODRIGUEZ VARGAS","celular":"0987519882","telefono":"022072827","linea_negocio":"1","tipo_transaccion":"1","medio":"13","campania":"5e686580-ee19-11ea-97ea-000c297d72b1","id_interaccion_inconcert":"id_inconcert","marca":"1","modelo":"2","comentario_cliente":"Necesita una cita para mantenimiento","description":"El cliente requiere una cotizacion urgente","porcentaje_discapacidad":"50_74"},"datos_adicionales":{"fields":[{"key":"Estado Civil","nombre":"Soltero"},{"key":"Fecha de Nacimiento","nombre":"10 Diciembre de 1970"}]}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/call_ticket"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/call_ticket',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'numero_identificacion' => '1719932079',
                'tipo_identificacion' => 'C',
                'email' => 'mart@hotmail.com',
                'user_name' => 'CG_RAMOS',
                'nombres' => 'FREDDY ROBERTO',
                'apellidos' => 'RODRIGUEZ VARGAS',
                'celular' => '0987519882',
                'telefono' => '022072827',
                'linea_negocio' => '1',
                'tipo_transaccion' => '1',
                'medio' => '13',
                'campania' => '5e686580-ee19-11ea-97ea-000c297d72b1',
                'id_interaccion_inconcert' => 'id_inconcert',
                'marca' => '1',
                'modelo' => '2',
                'comentario_cliente' => 'Necesita una cita para mantenimiento',
                'description' => 'El cliente requiere una cotizacion urgente',
                'porcentaje_discapacidad' => '50_74',
            ],
            'datos_adicionales' => [
                'fields' => [
                    [
                        'key' => 'Estado Civil',
                        'nombre' => 'Soltero',
                    ],
                    [
                        'key' => 'Fecha de Nacimiento',
                        'nombre' => '10 Diciembre de 1970',
                    ],
                ],
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_name": "TCK-463587",
        "ticket_url": "https:\/\/sugarcrm.casabaca.com\/#cbt_Tickets\/d4417c68-87a1-2572-9443-60e5cf52d1ef"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "numero_identificacion": [
            "Identificación es requerida"
        ],
        "nombres": [
            "Nombres son requeridos"
        ]
    }
}
```
> Example response (404):

```json
{
    "error": "User-name inválido, asesor  no se encuentra registrado"
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/call_ticket`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.numero_identificacion` | string |  required  | ID del client.
        `datosSugarCRM.tipo_identificacion` | string |  required  | Valores válidos: C(Cedula),P(Pasaporte), R(RUC)
        `datosSugarCRM.email` | email |  required  | Email válido del cliente.
        `datosSugarCRM.user_name` | string |  optional  | Es requerido si la fuente es inConcert. UserName válido del asesor en SUGAR.
        `datosSugarCRM.nombres` | string |  required  | Nombres del cliente.
        `datosSugarCRM.apellidos` | string |  required  | Apellidos del cliente.
        `datosSugarCRM.celular` | numeric |  required  | Celular del cliente.
        `datosSugarCRM.telefono` | numeric |  optional  | Telefono local del cliente.
        `datosSugarCRM.linea_negocio` | string |  optional  | Valores válidos: 1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados)
        `datosSugarCRM.tipo_transaccion` | numeric |  optional  | Valores válidos: 1 (Ventas),2 (Tomas),3 (Quejas),4 (Info General)
        `datosSugarCRM.medio` | numeric |  required  | Medio del Ticket
        `datosSugarCRM.campania` | numeric |  optional  | Id de la Campaña del Formulario
        `datosSugarCRM.id_interaccion_inconcert` | string |  required  | ID definido en el sistema externo
        `datosSugarCRM.marca` | string |  optional  | Marca del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.
        `datosSugarCRM.modelo` | string |  optional  | Modelo del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>.
        `datosSugarCRM.comentario_cliente` | string |  optional  | Comentario del cliente
        `datosSugarCRM.description` | string |  optional  | Comentario Asesor
        `datosSugarCRM.porcentaje_discapacidad` | string |  optional  | Porcentaje de discapacidad del cliente, , valores válidos: 30_49 (Del 30% al 49%),50_74 (Del 50% al 74%),75_84 (Del 75% al 84%),85_100(Del 85% al 100%)
        `datos_adicionales.fields` | array |  optional  | Arreglo con los campos del formulario
        `datos_adicionales.fields.0.key` | string |  optional  | Estado Civil del campo 1 del formulario  formulario
        `datos_adicionales.fields.0.nombre` | string |  optional  | Data del campo 1 del formulario
        `datos_adicionales.fields.1.key` | string |  optional  | Fecha de Nacimiento del campo 2 del formulario  formulario
        `datos_adicionales.fields.1.nombre` | string |  optional  | Data del campo 2 del formulario
    
<!-- END_c199d38571334fe663cb31edce93371f -->

<!-- START_15589e516beeb193362ba03d6d3905b3 -->
## Ticket - Landing Pages

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/landing_ticket" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"formulario":"Exonerados","numero_identificacion":"1719932079","tipo_identificacion":"C","nombres":"FREDDY ROBERTO","apellidos":"RODRIGUEZ VARGAS","email":"mart@hotmail.com","celular":"0987519882","concesionario":"Santo Domingo (Casabaca)"}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/landing_ticket"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/landing_ticket',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'formulario' => 'Exonerados',
                'numero_identificacion' => '1719932079',
                'tipo_identificacion' => 'C',
                'nombres' => 'FREDDY ROBERTO',
                'apellidos' => 'RODRIGUEZ VARGAS',
                'email' => 'mart@hotmail.com',
                'celular' => '0987519882',
                'concesionario' => 'Santo Domingo (Casabaca)',
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_name": "TCK-463587",
        "interaction_id": "1042eae5-0c94-1f7f-ef16-602e98cbd391",
        "ticket_url": "https:\/\/sugarcrm.casabaca.com\/#cbt_Tickets\/e06279dc-5629-5b20-6ebf-61081a41553a"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "numero_identificacion": [
            "Identificación es requerida"
        ],
        "nombres": [
            "Nombres son requeridos"
        ]
    }
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/landing_ticket`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.formulario` | string |  required  | Nombre del Formulario
        `datosSugarCRM.numero_identificacion` | string |  required  | ID del client.
        `datosSugarCRM.tipo_identificacion` | string |  required  | Valores válidos: C(Cedula),P(Pasaporte), R(RUC)
        `datosSugarCRM.nombres` | string |  required  | Nombres del cliente.
        `datosSugarCRM.apellidos` | string |  required  | Apellidos del cliente.
        `datosSugarCRM.email` | email |  required  | Email válido del cliente.
        `datosSugarCRM.celular` | numeric |  required  | Celular del cliente.
        `datosSugarCRM.concesionario` | string |  required  | Nombre de la Agencia-Concesionario
    
<!-- END_15589e516beeb193362ba03d6d3905b3 -->

<!-- START_1af19642c94c90ceb55d8a80bdb33cd6 -->
## Ticket Interacción No Contesta

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/not_answer_ticket/d9bf5143-daa6-d9ca-7d04-60df4f47f51a" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/not_answer_ticket/d9bf5143-daa6-d9ca-7d04-60df4f47f51a"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/not_answer_ticket/d9bf5143-daa6-d9ca-7d04-60df4f47f51a',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "ticket_id": "d9bf5143-daa6-d9ca-7d04-60df4f47f51a",
        "ticket_name": "TCK-463587"
    }
}
```
> Example response (404):

```json
{
    "error": "Ticket no existe, id inválido"
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/not_answer_ticket/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Id del ticket creado anteriormente en SUGAR

<!-- END_1af19642c94c90ceb55d8a80bdb33cd6 -->

<!-- START_9107eaa3e6d79e1d1134dea43eb82113 -->
## Ticket - Llamada no contesta

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/not_answer_call" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"user_name_call_center":"CG_RAMOS","date_start":"2021-10-02 19:59","duration_hours":"0","duration_minutes":"10","direction":"Inbound","ticket_id":"10438baf-0d83-9533-4fb3-602ea326288b"},"datos_adicionales":{"fields":[{"key":"Estado Civil","nombre":"Soltero"},{"key":"Fecha de Nacimiento","nombre":"10 Diciembre de 1970"}]}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/not_answer_call"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/not_answer_call',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'user_name_call_center' => 'CG_RAMOS',
                'date_start' => '2021-10-02 19:59',
                'duration_hours' => '0',
                'duration_minutes' => '10',
                'direction' => 'Inbound',
                'ticket_id' => '10438baf-0d83-9533-4fb3-602ea326288b',
            ],
            'datos_adicionales' => [
                'fields' => [
                    [
                        'key' => 'Estado Civil',
                        'nombre' => 'Soltero',
                    ],
                    [
                        'key' => 'Fecha de Nacimiento',
                        'nombre' => '10 Diciembre de 1970',
                    ],
                ],
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "call_id": "1043801af-0d83-9533-4fb3-602ea313128b",
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "user_name_call_center": [
            "User_name del call center es requerida"
        ],
        "date_start": [
            "La fecha de inicio de llamada es requerida"
        ]
    }
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/not_answer_call`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.user_name_call_center` | string |  required  | UserName del call center válido en SUGAR.
        `datosSugarCRM.date_start` | date |  required  | Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i.
        `datosSugarCRM.duration_hours` | numeric |  required  | Indica la duración en horas de la llamada.
        `datosSugarCRM.duration_minutes` | numeric |  required  | Indica la duración en minutos de la llamada.
        `datosSugarCRM.direction` | string |  required  | Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente)
        `datosSugarCRM.ticket_id` | string |  required  | ID del Ticket de SUGAR al que hace referencia.
        `datos_adicionales.fields` | array |  optional  | Arreglo con los campos del formulario
        `datos_adicionales.fields.0.key` | string |  optional  | Estado Civil del campo 1 del formulario  formulario
        `datos_adicionales.fields.0.nombre` | string |  optional  | Data del campo 1 del formulario
        `datos_adicionales.fields.1.key` | string |  optional  | Fecha de Nacimiento del campo 2 del formulario  formulario
        `datos_adicionales.fields.1.nombre` | string |  optional  | Data del campo 2 del formulario
    
<!-- END_9107eaa3e6d79e1d1134dea43eb82113 -->

<!-- START_206f087a1aa5a0ae2035b7f6960587d2 -->
## Cerrar Ticket

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/close_ticket/7c093743-5b5d-01ec-f0b4-604a99b319d3" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"motivo_cierre":"solo_informacion"}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/close_ticket/7c093743-5b5d-01ec-f0b4-604a99b319d3"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/close_ticket/7c093743-5b5d-01ec-f0b4-604a99b319d3',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'motivo_cierre' => 'solo_informacion',
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_name": "TCK-463587"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "datosSugarCRM.motivo_cierre": [
            "Motivo de cierre es requerido"
        ]
    }
}
```
> Example response (404):

```json
{
    "error": "Ticket no existe, id inválido"
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/close_ticket/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Id del ticket creado anteriormente en SUGAR
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.motivo_cierre` | string |  required  | Motivo para cerrar un ticket - Valores válidos: abandono_chat,solo_informacion,desiste,no_contesta,compra_futura
    
<!-- END_206f087a1aa5a0ae2035b7f6960587d2 -->

<!-- START_995795dea562b0b100b5648b0a1afdeb -->
## Agregar Notas a un Ticket

> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/ticket/addNotes/3aa93559-44b6-9527-8803-6079d0401158" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"datosSugarCRM":{"notes":"El cliente se encuentra interesado en un RAV4","interaction":"edc861f5-95ec-dc21-d6ff-608842e5f11c","prospeccion":"85fce850-bf1a-25ba-cbc3-60a547b5b9f3"}}'

```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/ticket/addNotes/3aa93559-44b6-9527-8803-6079d0401158"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/ticket/addNotes/3aa93559-44b6-9527-8803-6079d0401158',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
        'json' => [
            'datosSugarCRM' => [
                'notes' => 'El cliente se encuentra interesado en un RAV4',
                'interaction' => 'edc861f5-95ec-dc21-d6ff-608842e5f11c',
                'prospeccion' => '85fce850-bf1a-25ba-cbc3-60a547b5b9f3',
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "data": {
        "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
        "ticket_name": "TCK-463587"
    }
}
```
> Example response (422):

```json
{
    "errors": {
        "datosSugarCRM.notes": [
            "Notes es requerido"
        ]
    }
}
```
> Example response (404):

```json
{
    "error": "Ticket no existe, id inválido"
}
```
> Example response (500):

```json
{
    "message": "Unauthenticated.",
    "status_code": 500
}
```

### HTTP Request
`POST api/ticket/addNotes/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | Id del ticket creado anteriormente en SUGAR
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `datosSugarCRM.notes` | string |  required  | Notas para agregar al ticket
        `datosSugarCRM.interaction` | string |  optional  | Id de la interaccion si existe
        `datosSugarCRM.prospeccion` | string |  optional  | Id de la prospección generado si existió una cita
    
<!-- END_995795dea562b0b100b5648b0a1afdeb -->

#general


<!-- START_d06dd0a900cc3fee868117e5af3884d6 -->
## api/history
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/history" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/history"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/history',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`GET api/history`


<!-- END_d06dd0a900cc3fee868117e5af3884d6 -->

<!-- START_a9c53c2422434eaa99613c2d0de6fb12 -->
## api/validToken
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/validToken" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/validToken"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/validToken',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`GET api/validToken`


<!-- END_a9c53c2422434eaa99613c2d0de6fb12 -->

<!-- START_a15a2ca9d84ef0ffc5e4b9b5abb59a93 -->
## api/getAgencies/{linea}
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/getAgencies/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/getAgencies/1"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/getAgencies/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`GET api/getAgencies/{linea}`


<!-- END_a15a2ca9d84ef0ffc5e4b9b5abb59a93 -->

<!-- START_f61a85fda706298b2205dc574371d14e -->
## api/pricing
> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/pricing" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/pricing"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/pricing',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/pricing`


<!-- END_f61a85fda706298b2205dc574371d14e -->

<!-- START_bcf39d07ce09c63d5294a4025e877bce -->
## api/getUsers/{agency}/{position}
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/getUsers/1/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/getUsers/1/1"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/getUsers/1/1',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`GET api/getUsers/{agency}/{position}`


<!-- END_bcf39d07ce09c63d5294a4025e877bce -->

<!-- START_efef88a76939a558d04e0da3ef4589c2 -->
## api/coupons
> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/coupons" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/coupons"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/coupons',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/coupons`


<!-- END_efef88a76939a558d04e0da3ef4589c2 -->

<!-- START_6433753a73e964f743fce5e3fe639d15 -->
## api/coupons
> Example request:

```bash
curl -X PUT \
    "http://api-sugarcrm.casabaca.com/api/coupons" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/coupons"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://api-sugarcrm.casabaca.com/api/coupons',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/coupons`


<!-- END_6433753a73e964f743fce5e3fe639d15 -->

<!-- START_394276df2816b59c0b3eddc4d74d05af -->
## api/coupons/validate
> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/coupons/validate" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/coupons/validate"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/coupons/validate',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/coupons/validate`


<!-- END_394276df2816b59c0b3eddc4d74d05af -->

<!-- START_c59a089bf9e887b937ffa6755006f11f -->
## api/c2cOmnichannel
> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/c2cOmnichannel" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/c2cOmnichannel"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/c2cOmnichannel',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/c2cOmnichannel`


<!-- END_c59a089bf9e887b937ffa6755006f11f -->

<!-- START_e28e11bfc1c337f46ac0d9b520009cb3 -->
## api/sendEmail
> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/sendEmail" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/sendEmail"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/sendEmail',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/sendEmail`


<!-- END_e28e11bfc1c337f46ac0d9b520009cb3 -->

<!-- START_510595bdd6c92cdf3136d3ecdd71f935 -->
## api/getCreditoDataBook
> Example request:

```bash
curl -X POST \
    "http://api-sugarcrm.casabaca.com/api/getCreditoDataBook" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/getCreditoDataBook"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://api-sugarcrm.casabaca.com/api/getCreditoDataBook',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/getCreditoDataBook`


<!-- END_510595bdd6c92cdf3136d3ecdd71f935 -->

<!-- START_41017e4fcaf1cca0c88b37763a0857ac -->
## api/sumate
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/sumate" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/sumate"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/sumate',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
false
```

### HTTP Request
`GET api/sumate`


<!-- END_41017e4fcaf1cca0c88b37763a0857ac -->

<!-- START_bb59b6bccf1caefad055b8876d423c35 -->
## api/destinos
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/destinos" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/destinos"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/destinos',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
false
```

### HTTP Request
`GET api/destinos`


<!-- END_bb59b6bccf1caefad055b8876d423c35 -->

<!-- START_02eaf8a15e6b2d27cd6abc657c050a18 -->
## api/negocios
> Example request:

```bash
curl -X GET \
    -G "http://api-sugarcrm.casabaca.com/api/negocios" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://api-sugarcrm.casabaca.com/api/negocios"
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
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://api-sugarcrm.casabaca.com/api/negocios',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer {token}',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
false
```

### HTTP Request
`GET api/negocios`


<!-- END_02eaf8a15e6b2d27cd6abc657c050a18 -->


