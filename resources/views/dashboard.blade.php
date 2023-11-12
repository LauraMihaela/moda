
@if(empty(auth()->user()))
    <p>Hola </p>
@else
    <p>Hola {{ auth()->user()->username }} </p>
@endif