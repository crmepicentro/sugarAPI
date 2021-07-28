<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script src="{{ asset('js/app.js') }}"></script>
</head>

<body>
  <div class="container">
    <div class="col-5 mx-auto mt-5">
      <div class="row py-4">
        <a class="mx-auto" href="/login_sugar">
          <x-application-logo class="" />
        </a>
      </div>
      <form method="POST" action="{{ route('login_sugar') }}" class="bg-white p-4 rounded">
        @csrf
        <div class="form-group">
          <x-label for="username" value="Usuario" />
          <x-input id="username" class="form-control" type="text" name="username" :value="old('username')" required autofocus />
        </div>
        <div class="form-group">
          <x-label for="password" value="Contraseña" />
          <x-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
        </div>
        <div class="form-group text-center">
          @if(\Session::has('error'))
            <span class="text-danger">{{\Session::get('error')}}</span><br>
          @endif
          <x-button class="mt-3">
            Ingresar
          </x-button>
        </div>
        <div class="text-center">
          <span  style="color: #515050;font-size: 1.1rem;">Campañas Especiales</span>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
