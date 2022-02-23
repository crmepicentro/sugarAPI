<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style>
    a.button {
        background-color: #008CBA;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }
</style>
<body>
    <img src='https://sugarcrm.casabaca.com/custom/themes/default/images/company_logo.png?v=LBfbNX9iHfwRe35orZ1gdA' />
    <br>
    <br>
    <div>
        {{$data->text}}
    </div>
    <br>
    <div>
        <a href="{{$data->link}}" class="button">Enlace</a>
    </div>
    @if(isset($data->link2))
        <br>
        <div>
            <a href="{{$data->link2}}" class="button">Enlace para Móvil</a>
        </div>
    @endif
</body>
</html>
