<?php
use Illuminate\Support\Facades\Cache;
if (! function_exists('tabdata')) {
    function tabdata()
    {
        $valor  = session('tab');
        if($valor != null){
            return $valor;
        }
        return Cache::get('tab');

    }
}

