@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')



    @if(empty(auth()->user()))
        <p>Hola </p>
    @else
        <p>Hola {{ auth()->user()->username }} </p>
    @endif
    {{-- {{ dd(config('constants.roles.client_role'))}} --}}

    @if(auth()->user()->role_id == config('constants.roles.admin_role'))
        <button type="button" id="create-product" class="create-product btn btn-primary btn-lg">Crear producto</button>
    @endif

    {{-- Se va a incluir al final --}}
    @section('customScripts')
        @include('dashboard.dashboard-index-js')
    @endsection
@endsection