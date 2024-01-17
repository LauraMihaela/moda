@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-global-admins-index" class="btn btn-primary btn-lg m-3">@lang('messages.go-back-to-the-see-all-the-admin-users')</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">@lang('messages.create-an-admin-user')</h4>

                <form method="post" action="{{ url('users/admins') }}" class="form-horizontal" enctype="multipart/form-data"> 
                    @csrf
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user-pen"></i> </span>
                        </div>
                        <span>@lang('messages.username'):</span>
                        <input required type="text" id="username" name="username" class="form-control" placeholder="@lang('messages.username')">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <span>@lang('messages.email'):</span>
                        <input required type="email" id="email" name="email" class="form-control" placeholder="@lang('messages.email')">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <span>@lang('messages.name'):</span>
                        <input required type="text" id="name" name="name" class="form-control" placeholder="@lang('messages.name')">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <span>@lang('messages.lastname'):</span>
                        <input required type="text" id="lastname" name="lastname" class="form-control" placeholder="@lang('messages.lastname')">
                    </div>
            
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend mr-2 pr-2">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <span>@lang('messages.password'):</span>
                        <input required id="password" name="password" class="form-control" 
                        placeholder="@lang('messages.create-password')" type="password" autocomplete="off">
                    </div> 

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        {{-- El nombre debe ser password_confirmation para que laravel realice la
                            validación de que ambas contraseñas son iguales --}}
                        <span>@lang('messages.repeat-the-password'):</span>
                        <input required id="password_confirmation" name="password_confirmation" class="form-control"
                         placeholder="@lang('messages.repeat-the-password')" type="password" 
                         autocomplete="off" aria-describedby="inputGroupPrepend">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="register-submit" class="btn btn-primary btn-block">@lang('messages.create-an-admin-user')</button>
                    </div>   
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('users.admin.admin-create-js')
    @endsection

@endsection