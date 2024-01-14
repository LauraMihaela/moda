@extends('layout.logged')

@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-global-admins-index" class="btn btn-primary btn-lg m-3">Volver a la visión global de administradores</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">Edición del administrador {{$admin->username}}</h4>

                <form action="{{route('users.admins.update',$admin->id )}}" class="form-horizontal" enctype="multipart/form-data" method="POST"> 
                    @csrf
                    {!! method_field('put') !!}

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user-pen"></i> </span>
                        </div>
                        <span>Nombre de usuario:</span>
                        <input required type="text" id="username" name="username" 
                        class="form-control" placeholder="Nombre de usuario" 
                        value="{{$admin->username}}">
                    </div>
    
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <span>Email:</span>
                        <input required type="email" id="email" name="email" 
                        class="form-control" placeholder="Email" 
                        value="{{$admin->email}}">
                    </div>
    
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <span>Nombre:</span>
                        <input required type="text" id="name" name="name" 
                        class="form-control" placeholder="Nombre" 
                        value="{{$admin->name}}">
                    </div>
    
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <span>Apellidos</span>
                        <input required type="text" id="lastname" name="lastname" 
                        class="form-control" placeholder="Apellidos" 
                        value="{{$admin->lastname}}">
                    </div>
                    <div class="form-group">
                        <button type="submit" id="edit-admin-submit" class="btn btn-primary btn-block">Editar usuario administrador</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('users.admin.admin-edit-js')
    @endsection

@endsection