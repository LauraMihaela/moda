<!DOCTYPE html>
<html>
    @include('incl.headLogged')
    <body>
        {{-- Menú de navegación --}}
        {{-- @include('incl.alertsContainters') --}}

        {{-- Aquí irá el contenido específico de cada vista una vez logueado --}}
        @yield('content')

        {{-- @include('incl.modals')
        @include('incl.javaScriptDeclarationLogged') --}}

        {{-- Al final se encuentran los JS de cada vista --}}
        @yield('customScripts')
    </body>
</html>