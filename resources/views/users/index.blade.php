@extends('layout.logged')

{{-- En el section se mostrará la parte que se ha escrito en logged.blade con "yield" --}}
@section('content')
    @if(auth()->user()->role_id == config('constants.roles.admin_role'))
        <div class = "btn-group">
            <button type="button" id="see-clients" class="see-clients btn btn-primary btn-lg mr-2">@lang('messages.client-users')</button>
            <button type="button" id="see-agents" class="see-agents btn btn-primary btn-lg mr-2">@lang('messages.agent-users')</button>
            <button type="button" id="see-admins" class="see-admins btn btn-primary btn-lg mr-2">@lang('messages.admin-users')</button>
        </div>
    @endif  

    {{-- Se va a incluir al final --}}
    @section('customScripts')
        @include('users.users-index-js')
    @endsection
@endsection