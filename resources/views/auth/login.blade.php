<x-guest-layout>
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
          <span class="text-danger">{{\Session::get('error')}}</span>
          @endif
          <x-button class="mt-3">
            Ingresar
          </x-button>
        </div>
      </form>
    </div>
  </div>
</x-guest-layout>

