<!DOCTYPE html>
<html>
    <head>
        @include('incl.headLogin')
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    </head>
    <body>
        <div class="d-flex justify-content-center">
            <button type="button" id="login-button" class="btn btn-primary btn-lg m-3">Volver a Login</button>
        </div>   

        <div class="container">
            <div class="card bg-light">
                <article class="card-body mx-auto">
                    <h4 class="card-title mt-3 text-center">Creación de nuevo usuario</h4>

                    @include ('incl.alertsContainters')

                    {{ Form::open(array('url' => 'user/client/store', 'method' => 'POST', 'class' => 'form-horizontal')) }}          

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user-pen"></i> </span>
                            </div>
                            <input required type="text" id="username" name="username" class="form-control" placeholder="Nombre de usuario">
                        </div>

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                            </div>
                            <input required type="email" id="email" name="email" class="form-control" placeholder="Email">
                        </div>

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                            </div>
                            <input required type="text" id="name" name="name" class="form-control" placeholder="Nombre">
                        </div>

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                            </div>
                            <input required type="text" id="lastname" name="lastname" class="form-control" placeholder="Apellidos">
                        </div>

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                            </div>
                            <textarea id="address" name="address" class="form-control" placeholder="Direccion"></textarea>
                        </div> 
                
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend mr-2 pr-2">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                            </div>
                            <input required id="password" name="password" class="form-control input-lg input-ml" 
                            placeholder="Crear contraseña" type="password" autocomplete="off">
                        </div> 

                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                            </div>
                            {{-- El nombre debe ser password_confirmation para que laravel realice la
                                validación de que ambas contraseñas son iguales --}}
                            <input required id="password_confirmation" name="password_confirmation" class="form-control"
                             placeholder="Repetir contraseña" type="password" 
                             autocomplete="off" aria-describedby="inputGroupPrepend">
                        </div>

                        <div class="form-group">
                            <button type="submit" id="register-submit" class="btn btn-primary btn-block">Crear cuenta</button>
                        </div>    
                    {{ Form::close() }} 
                </article>
            </div> <!-- card.// -->
        </div> 

        @include('incl.modals')
        @include('incl.javaScriptDeclarationLogin')
        <script type="text/javascript" src="{{ asset('js/register.js') }}"></script>
    </body> 
</html>
