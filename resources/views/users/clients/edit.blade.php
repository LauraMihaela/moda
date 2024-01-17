@extends('layout.logged')

@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-global-clients-index" class="btn btn-primary btn-lg m-3">@lang('messages.go-back-to-the-see-all-the-client-users')</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">@lang('messages.edit-the-client') {{$user->username}}</h4>

                <form action="{{route('users.clients.update',$user->id )}}" class="form-horizontal" enctype="multipart/form-data" method="POST"> 
                    @csrf
                    {!! method_field('put') !!}

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user-pen"></i> </span>
                        </div>
                        <span>@lang('messages.username'):</span>
                        <input required type="text" id="username" name="username" 
                        class="form-control" placeholder="@lang('messages.username')" 
                        value="{{$user->username}}">
                    </div>
    
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <span>@lang('messages.email'):</span>
                        <input required type="email" id="email" name="email" 
                        class="form-control" placeholder="@lang('messages.email')" 
                        value="{{$user->email}}">
                    </div>
    
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <span>@lang('messages.name'):</span>
                        <input required type="text" id="name" name="name" 
                        class="form-control" placeholder="@lang('messages.name')" 
                        value="{{$user->name}}">
                    </div>
    
                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <span>@lang('messages.lastname'):</span>
                        <input required type="text" id="lastname" name="lastname" 
                        class="form-control" placeholder="@lang('messages.lastname')" 
                        value="{{$user->lastname}}">
                    </div>

                    <div class="form-group input-group m-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                        </div>
                        <span>@lang('messages.address'):</span>
                        <textarea id="address" name="address" class="form-control" 
                        placeholder="@lang('messages.address')">{{$client->address}}</textarea>
                    </div> 

                    <div class="form-group">
                        <button type="submit" id="edit-client-submit" class="btn btn-primary btn-block">@lang('messages.edit-client')</button>
                    </div>    
                </form>
                
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('users.clients.client-edit-js')
    @endsection

@endsection