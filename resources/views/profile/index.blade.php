@extends('layout.logged')

@section('content')

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">@lang('messages.my-profile')</h4>

                <form action="{{route('users.profile.update')}}" class="form-horizontal" enctype="multipart/form-data" method="POST"> 
                    @csrf
                    {!! method_field('put') !!}

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user-pen"></i> </span>
                        </div>
                        <span>@lang('messages.username'):</span>
                        <input required type="text" id="username" name="username" 
                        class="form-control" placeholder="@lang('messages.username')" 
                        value="{{auth()->user()->username}}">
                    </div>
    
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <span>@lang('messages.email'):</span>
                        <input required type="email" id="email" name="email" 
                        class="form-control" placeholder="@lang('messages.email')" 
                        value="{{auth()->user()->email}}">
                    </div>
    
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <span>@lang('messages.name'):</span>
                        <input required type="text" id="name" name="name" 
                        class="form-control" placeholder="@lang('messages.name')" 
                        value="{{auth()->user()->name}}">
                    </div>
    
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <span>@lang('messages.lastname'):</span>
                        <input required type="text" id="lastname" name="lastname" 
                        class="form-control" placeholder="@lang('messages.lastname')"
                        value="{{auth()->user()->lastname}}">
                    </div>

                    @if(auth()->user()->role_id == config('constants.roles.client_role'))
                        {{-- Si es un cliente, se mostrará su dirección --}}
                        <div class="form-group input-group m-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                            </div>
                            <span>@lang('messages.address'):</span>
                            <textarea id="address" name="address" class="form-control" 
                            placeholder="@lang('messages.address')">{{$client->address}}</textarea>
                        </div> 
                    @endif

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend mr-2 pr-2">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <span>@lang('messages.password'):</span>
                        <input id="password" name="password" class="form-control" 
                        placeholder="@lang('messages.change-password')" type="password" autocomplete="off">
                    </div> 

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        {{-- El nombre debe ser password_confirmation para que laravel realice la
                            validación de que ambas contraseñas son iguales --}}
                        <span>@lang('messages.repeat-password'):</span>
                        <input id="password_confirmation" name="password_confirmation" class="form-control"
                         placeholder="@lang('messages.repeat-new-password')" type="password" 
                         autocomplete="off" aria-describedby="inputGroupPrepend">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="profile-submit" class="btn btn-primary btn-block">@lang('messages.update-profile')</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('profile.index-edit-js')
    @endsection

@endsection