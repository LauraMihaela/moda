@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')



    @if(empty(auth()->user()))
        <p>Hola </p>
    @else
        <p>Hola {{ auth()->user()->username }} </p>
    @endif
    {{-- {{ dd(config('constants.roles.client_role'))}} --}}


@endsection