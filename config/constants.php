<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Defined Variables
    |--------------------------------------------------------------------------
    |
    | This is a set of variables that are made specific to this application
    | that are better placed here rather than in .env file.
    | Use config('your_key') to get the values.
    |
    */
    //config('constants.pv_empresa')
    'pv_empresa' => env('PV_EMPRESA'),
    //config('constants.pv_codOrdenEstado')
    'pv_codOrdenEstado' => env('PV_COD_ORDEN_ESTADO'),
    //config('constants.pv_codOrdenTaller')
    'pv_codOrdenTaller' => env('PV_COD_ORDEN_TALLER'),
    //config('constants.pv_timezone')
    'pv_timezone' => env('PV_TIMEZONE'),
    //config('constants.pv_dateFormat')
    'pv_dateFormat' => env('PV_DATE_FORMAT'),
    //config('constants.pv_user_servicio')
    'pv_user_servicio' => env('PV_USER_SERVICIO'),
    //config('constants.pv_pass_servicio')
    'pv_pass_servicio' => env('PV_PASS_SERVICIO'),
    //config('constants.pv_url_servicio')
    'pv_url_servicio' => env('PV_URL_SERVICIO'),


];
