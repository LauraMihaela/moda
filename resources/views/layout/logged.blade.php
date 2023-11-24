{{-- Estructura global de las vistas una vez logueado --}}
<!DOCTYPE html>
<html>
    @include('incl.headLogged')
    <body>
        {{-- Menú de navegación --}}
        @include('incl.navLogged')
        @include('incl.alertsContainters')

        {{-- Aquí irá el contenido específico de cada vista una vez logueado --}}
        @yield('content')

        @include('incl.footerLogged')
        @include('incl.modals')
        @include('incl.javaScriptDeclarationLogged')
    </body>
</html>