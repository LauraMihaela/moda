<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        {{-- csrf_token: Forms (security) --}}
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ env('APP_NAME') }}</title>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        {{-- Bootstrap CSS CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        {{-- Font awesome CSS CDN --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Della+Respira&display=swap" rel="stylesheet">
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
                <h2>Introduzca su email o nombre de usuario y su contraseña</h2>
                {{-- Esto es lo mismo que 
                    <form method="post" action="{{ url('login') }}"> 
                --}}
                {{ Form::open(array('url' => 'login', 'method' => 'POST', 'class' => 'form-horizontal')) }}          
                    {{-- csrf nos protege ante ataques tipo cross site request forgery --}}
                    @csrf
                    <input type="text" required id="username-email-field" name="usernameOrEmail" placeholder="Nombre de usuario o email" class="form-element" autocomplete="on"/>
                    <input type="password" required id="password-field" placeholder="Contraseña" name="password" class="form-element" autocomplete="on"/>
                    <button type="submit" class="btn btn-primary btn-lg form-control form-control-lg form-element" >Entrar en Moda</button>
                {{ Form::close() }}
            </div>
            <div class="bottom">
            </div>
        </div>

         {{-- Bootstrap JavaScript CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        {{-- Jquery JavaScript CDN --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        {{-- Font awesome JavaScript CDN --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/login.js') }}"></script>
    </body> 
</html>
