@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-global-clients-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de clientes</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Cliente {{$user->username}}</h4>
                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user-pen"></i> </span>
                    </div>
                    <span>Nombre de usuario:</span>
                    <input required type="text" id="username" name="username" 
                    class="form-control" placeholder="Nombre de usuario" 
                    value="{{$user->username}}" readonly>
                </div>

                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                    </div>
                    <span>Email:</span>
                    <input required type="email" id="email" name="email" 
                    class="form-control" placeholder="Email" 
                    value="{{$user->email}}" readonly>
                </div>

                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                    </div>
                    <span>Nombre:</span>
                    <input required type="text" id="name" name="name" 
                    class="form-control" placeholder="Nombre" 
                    value="{{$user->name}}" readonly>
                </div>

                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                    </div>
                    <span>Apellidos:</span>
                    <input required type="text" id="lastname" name="lastname" 
                    class="form-control" placeholder="Apellidos" 
                    value="{{$user->lastname}}" readonly>
                </div>

                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                    </div>
                    <span>Dirección:</span>
                    <textarea id="address" name="address" class="form-control" 
                    placeholder="Direccion" readonly>{{$client->address}}</textarea>
                </div> 
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('users.clients.client-show-js')
    @endsection

@endsection