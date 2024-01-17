@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    <div class="d-flex justify-content-center">
        <button type="button" id="back-to-global-agents-index" class="btn btn-primary btn-lg m-3">@lang('messages.go-back-to-the-see-all-the-agent-users')</button>
    </div>   

    <div class="container">
        <div class="card bg-light">
            <article class="card-body mx-auto">
                <h4 class="card-title mt-3 text-center">@lang('messages.agent-user') {{$agent->username}}</h4>
                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user-pen"></i> </span>
                    </div>
                    <span>@lang('messages.username'):</span>
                    <input required type="text" id="username" name="username" 
                    class="form-control" placeholder="@lang('messages.username')" 
                    value="{{$agent->username}}" readonly>
                </div>

                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                    </div>
                    <span>@lang('messages.email'):</span>
                    <input required type="email" id="email" name="email" 
                    class="form-control" placeholder="@lang('messages.email')" 
                    value="{{$agent->email}}" readonly>
                </div>

                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                    </div>
                    <span>@lang('messages.name'):</span>
                    <input required type="text" id="name" name="name" 
                    class="form-control" placeholder="@lang('messages.name')" 
                    value="{{$agent->name}}" readonly>
                </div>

                <div class="form-group input-group m-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                    </div>
                    <span>@lang('messages.lastname'):</span>
                    <input required type="text" id="lastname" name="lastname" 
                    class="form-control" placeholder="@lang('messages.lastname')" 
                    value="{{$agent->lastname}}" readonly>
                </div>
            </article>
        </div> <!-- card.// -->

    </div> 

    @section('customScripts')
        @include('users.agents.agent-show-js')
    @endsection

@endsection