<!DOCTYPE html>
<html>
    <head>
        @include('incl.headLogin')
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>
    
    <body>
        <div class="container-fluid">
            <div class="top">
                <div class="d-flex justify-content-center logo">
                </div>
            </div>

            <div class="icon">
                <i class="fas fa-hand-pointer fa-lg"></i>
            </div>
            <div class="center">
                @include ('incl.alertsContainters')
                <button type="button" id="register-button" class="register btn btn-primary btn-lg">Registrarme</button>

                <h2>Introduzca su email o nombre de usuario y su contraseña</h2>
                {{-- Esto es lo mismo que 
                    <form method="post" action="{{ url('login') }}"> 
                --}}
                {{ Form::open(array('url' => 'login', 'method' => 'POST', 'class' => 'form-horizontal')) }}          
                    {{-- csrf nos protege ante ataques tipo cross site request forgery --}}
                    @csrf
                    <input type="text" required id="username-email-field" name="username" placeholder="Nombre de usuario o email" class="form-element" autocomplete="on"/>
                    <input type="password" required id="password-field" placeholder="Contraseña" name="password" class="form-element" autocomplete="on"/>
                    <button type="submit" class="btn btn-primary btn-lg form-control form-control-lg form-element" >Entrar en Moda</button>
                {{ Form::close() }}
            </div>
            <div class="bottom">
            </div>
        </div>

        @include('incl.modals')
        @include('incl.javaScriptDeclarationLogin')
        <script type="text/javascript" src="{{ asset('js/login.js') }}"></script>
    </body> 
</html>
