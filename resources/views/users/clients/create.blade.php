@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-global-clients-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de clientes</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Creación de un cliente</h4>

                <form method="post" action="{{ url('users/clients') }}" class="form-horizontal" enctype="multipart/form-data"> 
                    @csrf
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user-pen"></i> </span>
                        </div>
                        <span>Nombre de usuario:</span>
                        <input required type="text" id="username" name="username" class="form-control" placeholder="Nombre de usuario">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <span>Email:</span>
                        <input required type="email" id="email" name="email" class="form-control" placeholder="Email">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <span>Nombre:</span>
                        <input required type="text" id="name" name="name" class="form-control" placeholder="Nombre">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <span>Apellidos:</span>
                        <input required type="text" id="lastname" name="lastname" class="form-control" placeholder="Apellidos">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                        </div>
                        <span>Dirección:</span>
                        <textarea id="address" name="address" class="form-control" 
                        placeholder="Direccion"></textarea>
                    </div> 
            
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend mr-2 pr-2">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <span>Contraseña:</span>
                        <input required id="password" name="password" class="form-control" 
                        placeholder="Crear contraseña" type="password" autocomplete="off">
                    </div> 

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        {{-- El nombre debe ser password_confirmation para que laravel realice la
                            validación de que ambas contraseñas son iguales --}}
                        <span>Repita contraseña:</span>
                        <input required id="password_confirmation" name="password_confirmation" class="form-control"
                         placeholder="Repetir contraseña" type="password" 
                         autocomplete="off" aria-describedby="inputGroupPrepend">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="register-submit" class="btn btn-primary btn-block">Crear cliente</button>
                    </div>   
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('users.clients.client-create-js')
    @endsection

@endsection